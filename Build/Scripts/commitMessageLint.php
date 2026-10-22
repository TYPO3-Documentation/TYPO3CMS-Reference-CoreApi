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
 * Check a commit message against the trailer conventions in AGENTS.md.
 *
 * The `Releases:` trailer is what a maintainer reads when deciding which
 * `backport <version>` label a pull request gets, and a contributor who cannot
 * set labels has no other way to say it. It is also the trailer most easily
 * forgotten, because nothing downstream complains: the pull request merges,
 * the release branch simply never sees the change.
 *
 * Checked here is only what AGENTS.md itself mandates:
 *
 * - a `Releases:` trailer naming only branches this repository has,
 * - `Assisted-by:` written as a model name followed by a contact address,
 *   rather than a tool-specific slug such as `vendor-tool:model-id` that an
 *   agent may carry in from its own configuration,
 * - the trailer order rule 5 gives.
 *
 * The subject prefix is deliberately not checked. AGENTS.md does not mandate
 * one, and 105 of the 346 commits on main in 2026 carry none, so a check would
 * report style rather than defects.
 *
 * A cherry-picked backport keeps the original message, so it carries the
 * trailer already and passes; all 34 commits of the merged backport pull
 * requests do. Merge, revert and fixup commits carry somebody else's message
 * and are skipped.
 *
 * Usage:
 *   php Build/Scripts/commitMessageLint.php <file>   # the commit-msg hook argument
 *   php Build/Scripts/commitMessageLint.php -        # read the message from stdin
 */

$source = $argv[1] ?? '-';
$message = $source === '-' ? (string)file_get_contents('php://stdin') : (string)file_get_contents($source);

$knownBranches = ['main', '14.3', '13.4'];
$trailerOrder = ['Resolves', 'References', 'Releases', 'Assisted-by', 'Signed-off-by'];

$lines = [];
foreach (preg_split('/\R/', $message) as $line) {
    if (!str_starts_with($line, '#')) {
        $lines[] = rtrim($line);
    }
}

$subject = trim($lines[0] ?? '');
if ($subject === '') {
    fwrite(STDERR, "The commit message is empty.\n");
    exit(1);
}

// A backport, a merge and a fixup all carry somebody else's message.
foreach (['[Backport', 'Merge ', 'fixup!', 'squash!', 'Revert '] as $prefix) {
    if (str_starts_with($subject, $prefix)) {
        exit(0);
    }
}

// Collect every trailer line in the message, not only the block it ends on: a
// cherry-pick appends "(cherry picked from commit ...)" and often a second
// Signed-off-by below the trailers, which would cut a block scan short and
// report the `Releases:` line above it as missing.
$trailers = [];
$tail = [];
foreach ($lines as $index => $line) {
    if ($index === 0 || trim($line) === '') {
        continue;
    }
    if (preg_match('/^([A-Z][A-Za-z-]+):[ \t]*(.*)$/', $line, $matches)) {
        $trailers[] = [$matches[1], trim($matches[2])];
        $tail[] = $index;
    }
}
$keys = array_column($trailers, 0);

// The order rule is only meaningful while the trailers sit together at the end.
$contiguous = $tail !== [] && $tail === range($tail[0], $tail[0] + count($tail) - 1)
    && end($tail) === array_key_last($lines);

$problems = [];

$releases = null;
foreach ($trailers as [$key, $value]) {
    if ($key === 'Releases') {
        $releases = $value;
    }
}
if ($releases === null) {
    $problems[] = 'no `Releases:` trailer. It tells the maintainer which '
        . '`backport <version>` labels the pull request needs. The default is '
        . '`Releases: main, 14.3`; see rule 4 in AGENTS.md before adding `13.4`.';
} else {
    $listed = array_filter(array_map('trim', explode(',', $releases)), static fn(string $v): bool => $v !== '');
    if ($listed === []) {
        $problems[] = '`Releases:` is empty.';
    }
    foreach ($listed as $branch) {
        if (!in_array($branch, $knownBranches, true)) {
            $problems[] = sprintf(
                '`Releases:` names `%s`, which is not a branch of this repository (%s).',
                $branch,
                implode(', ', $knownBranches)
            );
        }
    }
}

foreach ($trailers as [$key, $value]) {
    if ($key === 'Assisted-by' && !preg_match('/^.+\s<[^<>@\s]+@[^<>\s]+>$/', $value)) {
        $problems[] = sprintf(
            '`Assisted-by: %s` is not a model name followed by a contact address, '
            . 'for example `Assisted-by: Claude Sonnet 5 <noreply@anthropic.com>`. '
            . 'Name the model that actually assisted.',
            $value
        );
    }
}

$known = array_values(array_filter($keys, static fn(string $k): bool => in_array($k, $trailerOrder, true)));
$sorted = $known;
usort($sorted, static fn(string $a, string $b): int => array_search($a, $trailerOrder, true) <=> array_search($b, $trailerOrder, true));
if ($contiguous && $known !== $sorted) {
    $problems[] = 'the trailers are out of order. Rule 5 in AGENTS.md has them as: '
        . implode(', ', array_map(static fn(string $k): string => $k . ':', $trailerOrder)) . '.';
}

if ($problems === []) {
    exit(0);
}

fwrite(STDERR, "The commit message does not follow AGENTS.md:\n");
foreach ($problems as $problem) {
    fwrite(STDERR, '  - ' . $problem . "\n");
}
fwrite(STDERR, "\nFix the message and commit again, or pass --no-verify to skip this check.\n");
exit(1);
