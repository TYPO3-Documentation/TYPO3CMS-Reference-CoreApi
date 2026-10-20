<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Package\Resource\Definition\PublicResourceDefinition;
use TYPO3\CMS\Core\Package\VirtualAppPackage;

return static function (
  VirtualAppPackage $package,
  string $relativePublicPath,
) {
  return [
    // The folder lies outside the public folder and gets published
    new PublicResourceDefinition('assets/Public'),
  ];
};
