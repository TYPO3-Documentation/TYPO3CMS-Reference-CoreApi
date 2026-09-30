<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository;
use TYPO3\CMS\Core\Domain\RawRecord;

final readonly class RecordTranslationService
{
  public function __construct(
    private LocalizationRepository $localizationRepository,
  ) {}

  /**
   * @return RawRecord[] indexed by language ID
   */
  public function findTranslations(int $conferenceUid): array
  {
    return $this->localizationRepository->getRecordTranslations(
      'tx_myextension_conference',
      $conferenceUid,
    );
  }

  public function findTranslation(
    int $conferenceUid,
    int $languageId,
  ): ?RawRecord {
    return $this->localizationRepository->getRecordTranslation(
      'tx_myextension_conference',
      $conferenceUid,
      $languageId,
    );
  }

  public function countTranslations(int $conferenceUid): int
  {
    return count($this->findTranslations($conferenceUid));
  }
}
