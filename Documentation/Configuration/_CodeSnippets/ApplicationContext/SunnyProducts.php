<?php
use TYPO3\CMS\Core\Core\Environment;
class SunnyProducts
{
    public function getDiscount(): int
    {
        if (Environment::getContext()->isDevelopment()) {
            return 20;
        }

        return 4;
    }
}
