<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Configuration\Features;

final class SomeClass
{
  public function __construct(
    private readonly Features $features,
  ) {}

  public function doSomething(): void
  {
    if ($this->features->isFeatureEnabled('myFeatureName')) {
      // do custom processing
    }

    // ...
  }
}
