<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Check the reST sources against the two indentation rules of the style guide:
 * two spaces after `..`, and directive options one level, four spaces, deeper.
 *
 * Only these two are checked, because they are the ones that can be decided
 * without understanding the document. Everything else reST indents — bullet
 * continuations, field lists, tables, definition lists — has its own width, so
 * a general "multiple of four" rule reports far more noise than findings. That
 * is also why editorconfig-checker skips reST entirely.
 *
 * The body of a literal directive is left alone: its indentation is the code it
 * shows, not the structure of the page. Documentation/CodeSnippets/ is skipped
 * as a whole, because a generator writes those files and decides their format.
 */

const LITERAL_DIRECTIVES = [
    'code-block', 'literalinclude', 'parsed-literal', 'math', 'uml',
];

$directory = $argv[1] ?? 'Documentation';

$files = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $path = $file->getPathname();
    if (!str_ends_with($path, '.rst') && !str_ends_with($path, '.rst.txt')) {
        continue;
    }
    if (str_contains($path, '/CodeSnippets/')) {
        continue;
    }
    $files[] = $path;
}
sort($files);

$failed = 0;
foreach ($files as $file) {
    $lines = explode("\n", file_get_contents($file));
    $count = count($lines);

    for ($i = 0; $i < $count; $i++) {
        if (!preg_match('/^( *)\.\.( +)(?=[A-Za-z|_])/', $lines[$i], $matches)) {
            continue;
        }
        $indent = strlen($matches[1]);
        $spaces = strlen($matches[2]);

        if ($spaces !== 2) {
            printf("%s:%d: %d spaces after '..', expected 2\n", $file, $i + 1, $spaces);
            $failed++;
        }

        $j = $i + 1;
        while ($j < $count && preg_match('/^( *):[\w-]+:/', $lines[$j], $option)) {
            if (strlen($option[1]) !== $indent + 4) {
                printf(
                    "%s:%d: option indented %d, expected %d\n",
                    $file,
                    $j + 1,
                    strlen($option[1]),
                    $indent + 4
                );
                $failed++;
            }
            $j++;
        }

        // Skip what a literal directive shows, that indentation is its content.
        $name = preg_match('/^ *\.\. +([\w-]+)::/', $lines[$i], $d) ? $d[1] : '';
        if (in_array($name, LITERAL_DIRECTIVES, true)) {
            while ($j < $count && trim($lines[$j]) === '') {
                $j++;
            }
            while ($j < $count
                && (trim($lines[$j]) === '' || strlen($lines[$j]) - strlen(ltrim($lines[$j])) > $indent)
            ) {
                $j++;
            }
        }

        $i = max($j, $i + 1) - 1;
    }
}

printf("\n%d files checked, %d findings\n", count($files), $failed);

exit($failed > 0 ? 1 : 0);
