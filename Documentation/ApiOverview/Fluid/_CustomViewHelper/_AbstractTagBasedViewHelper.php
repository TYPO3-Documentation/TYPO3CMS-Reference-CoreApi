<?php

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AbstractTagBasedViewHelper extends AbstractViewHelper
{
    protected $additionalArguments = [];
    // ...
    public function handleAdditionalArguments(array $arguments): void
    {
        $this->additionalArguments = $arguments;
        parent::handleAdditionalArguments($arguments);
    }
}
