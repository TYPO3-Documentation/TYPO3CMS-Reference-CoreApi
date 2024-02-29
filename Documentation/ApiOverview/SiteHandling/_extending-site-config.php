<?php

// Experimental example to add a new field to the site configuration

// Configure a new simple required input field to site
$GLOBALS['SiteConfiguration']['site']['columns']['myNewField'] = [
    'label' => 'A new custom field',
    'config' => [
        'type' => 'input',
        'eval' => 'required',
    ],
];

// And add it to showitem
$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] = str_replace(
    'base,',
    'base, myNewField, ',
    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'],
);
