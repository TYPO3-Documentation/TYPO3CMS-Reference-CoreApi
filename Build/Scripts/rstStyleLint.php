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
 * Check the reST sources against the rules of the style guide that can be
 * decided without reading the page: two spaces after `..`, directive options one
 * level, four spaces, deeper, and the interlink prefix on permalink URLs.
 *
 * Only these are checked, because they are the ones that can be decided without
 * understanding the document. Everything else reST indents — bullet
 * continuations, field lists, tables, definition lists — has its own width, so
 * a general "multiple of four" rule reports far more noise than findings. That
 * is also why editorconfig-checker skips reST entirely.
 *
 * The body of a literal directive is left alone: its indentation is the code it
 * shows, not the structure of the page. Documentation/CodeSnippets/ is skipped
 * as a whole, because a generator writes those files and decides their format.
 *
 * A permalink URL needs the target manual's interlink prefix before the anchor,
 * as in https://docs.typo3.org/permalink/t3coreapi:extbase-domain-model. Without
 * it the URL returns 404. The renderer cannot gate this: these are ordinary
 * external URLs, so it only warns and the page still builds, leaving the broken
 * link to be found by a reader clicking it. Which prefix is correct depends on
 * where the anchor is defined, so only its presence is checked, not its value.
 * A prefix may itself contain a slash, as in typo3/cms-form:some-anchor.
 */

const LITERAL_DIRECTIVES = [
    'code-block', 'literalinclude', 'parsed-literal', 'math', 'uml',
];

// The anchor part of a permalink URL, stopping at whatever ends the link: the
// closing `>` of an RST external link, a backtick, whitespace, or a bracket. A
// trailing dot or comma is sentence punctuation rather than part of the anchor.
const PERMALINK_PATTERN = '#https?://docs\.typo3\.org/permalink/([^\s>`\'"()\[\]]*[^\s>`\'"()\[\].,;])#';

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

    // A permalink needs the target manual's prefix, and can appear on any line,
    // including inside a literal block that the directive walk below skips.
    for ($i = 0; $i < $count; $i++) {
        if (!preg_match_all(PERMALINK_PATTERN, $lines[$i], $links)) {
            continue;
        }
        foreach ($links[1] as $target) {
            if (!str_contains($target, ':')) {
                printf(
                    "%s:%d: permalink \"%s\" has no manual prefix, expected e.g. \"t3coreapi:%s\"\n",
                    $file,
                    $i + 1,
                    $target,
                    $target
                );
                $failed++;
                continue;
            }

            // The anchor is published with hyphens even where it is defined with
            // underscores, so an underscore here is a 404 the prefix cannot save.
            [$prefix, $anchor] = explode(':', $target, 2);
            if (str_contains($anchor, '_')) {
                printf(
                    "%s:%d: permalink anchor \"%s\" contains \"_\", published as \"%s\"\n",
                    $file,
                    $i + 1,
                    $anchor,
                    str_replace('_', '-', $anchor)
                );
                $failed++;
            }
        }
    }

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
