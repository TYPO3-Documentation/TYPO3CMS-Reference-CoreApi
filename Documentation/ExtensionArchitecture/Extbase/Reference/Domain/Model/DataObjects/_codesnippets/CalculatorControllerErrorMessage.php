<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CalculatorController extends ActionController
{
    // ...
    protected function getErrorFlashMessage(): bool|string
    {
        return 'Check your measurements. ';
    }
}
