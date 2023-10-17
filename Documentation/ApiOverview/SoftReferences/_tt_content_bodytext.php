<?php

$GLOBALS['TCA']['tt_content']['columns']['bodytext'] = [
    // ...
    'config' => [
        'type' => 'text',
        'softref' => 'typolink_tag,email[subst],url',
        // ...
    ],
    // ...
];
