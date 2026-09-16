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
 * Check the JSON snippets of the manual for syntax errors.
 *
 * Trailing commas, single quotes and a bare member without its enclosing
 * object read like JSON and are rejected by every JSON parser, Composer
 * included, so they are worth catching before a reader copies them.
 *
 * Unlike YAML or TypoScript, JSON has no comment syntax, so an excerpt cannot
 * mark what it leaves out and still has to be a well formed document: wrap the
 * part being shown in the braces it belongs in and say "(excerpt)" in the
 * caption. Where the manual needs to show that more members follow, it writes
 * a "...": "..." member, which is ordinary JSON.
 *
 * PHP reports no position for a JSON error, so this names the file only. The
 * snippets are short enough for that to be enough.
 */

$directory = $argv[1] ?? 'Documentation';

$files = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'json') {
        $files[] = $file->getPathname();
    }
}
sort($files);

$failed = 0;
foreach ($files as $file) {
    try {
        json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        printf("%s: %s\n", $file, lcfirst($e->getMessage()));
        $failed++;
    }
}

printf("\n%d files checked, %d with errors\n", count($files), $failed);

exit($failed > 0 ? 1 : 0);
