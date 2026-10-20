<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Package\Package;
use TYPO3\CMS\Core\Package\Resource\Definition\PublicFileDefinition;
use TYPO3\CMS\Core\Package\Resource\Definition\PublicResourceDefinition;
use TYPO3\CMS\Core\Package\Resource\Definition\ResourceDefinition;

return static function (Package $package) {
  return [
    // Published below public/_assets/ in a folder with a hash name
    new PublicResourceDefinition('Build/Public'),
    // Published to public/_assets/my-vendor/my-extension-icons/
    new PublicResourceDefinition(
      relativePath: 'Build/Icons',
      publicPrefix: 'my-vendor/my-extension-icons',
    ),
    // Publishes this one file only
    new PublicFileDefinition(relativePath: 'Build/styles.css'),
    // Private: can be resolved on the server, is never published
    new ResourceDefinition('Build/Templates'),
  ];
};
