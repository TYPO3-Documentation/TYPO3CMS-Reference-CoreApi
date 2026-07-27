<?php

use TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory;
use TYPO3\CMS\Linkvalidator\Repository\BrokenLinkRepository;

final readonly class CheckExternalLinksToLocalPagesEventListener
{
    public function __construct(
        private BrokenLinkRepository $brokenLinkRepository,
        private SoftReferenceParserFactory $softReferenceParserFactory,
    ) {}
}
