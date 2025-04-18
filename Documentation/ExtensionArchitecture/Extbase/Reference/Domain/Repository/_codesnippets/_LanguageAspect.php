<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\Repository;

final class MyRepository extends Repository
{
    public function findSomethingByLanguage(int $languageId, int $contentId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setLanguageAspect(
            new LanguageAspect(
                $languageId,
                $contentId,
                LanguageAspect::OVERLAYS_MIXED,
            ),
        );
        // query something
    }
}
