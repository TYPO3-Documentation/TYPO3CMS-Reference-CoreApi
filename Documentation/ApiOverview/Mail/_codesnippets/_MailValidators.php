<?php

use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\RFCValidation;

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['validators'] = [
    RFCValidation::class,
    DNSCheckValidation::class,
];
