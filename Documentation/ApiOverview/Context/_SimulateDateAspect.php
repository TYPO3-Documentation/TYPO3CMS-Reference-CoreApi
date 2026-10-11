<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Preview;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\DateTimeAspect;
use TYPO3\CMS\Core\Domain\DateTimeFactory;

final readonly class SimulateDate
{
  public function __construct(
    private Context $context,
  ) {}

  public function simulate(int $timestamp): void
  {
    $this->context->setAspect(
      'date',
      new DateTimeAspect(DateTimeFactory::createFromTimestamp($timestamp)),
    );
  }
}
