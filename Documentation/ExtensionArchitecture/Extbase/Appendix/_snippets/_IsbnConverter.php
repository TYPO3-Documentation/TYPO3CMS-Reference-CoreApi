<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Property\TypeConverter;

use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;

class IsbnConverter extends AbstractTypeConverter
{
  public function convertFrom(
    $source,
    string $targetType,
    array $convertedChildProperties = [],
    ?PropertyMappingConfigurationInterface $configuration = null,
  ): mixed {
    // return the converted value or a \TYPO3\CMS\Extbase\Error\Error instance
  }
}
