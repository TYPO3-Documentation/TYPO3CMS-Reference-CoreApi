<?php

$GLOBALS['TCA'][$myTable]['columns']['mainCategory'] = [
    'config' => [
        'type' => 'category',
        'relationship' => 'oneToOne',
    ],
];
