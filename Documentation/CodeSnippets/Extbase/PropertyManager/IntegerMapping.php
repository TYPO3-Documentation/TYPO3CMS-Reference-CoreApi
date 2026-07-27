<?php

use TYPO3\CMS\Extbase\Property\Exception;

class PostController extends AbstractController
{
    /**
     * This method demonstrates property mapping to an integer
     * @throws Exception
     */
    protected function mapIntegerFromString(string $numberString = '42'): int
    {
        return $output = $this->propertyMapper->convert($numberString, 'integer');
    }
}
