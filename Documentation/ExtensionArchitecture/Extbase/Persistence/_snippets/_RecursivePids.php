<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function __construct(
        protected readonly PageRepository $pageRepository,
    ) {
        parent::__construct();
    }

    /**
     * @param int[] $startPages Pages chosen by an editor or by plugin settings
     */
    public function findInPagesRecursive(array $startPages, int $depth): QueryResultInterface
    {
        $storagePageIds = $this->pageRepository->getPageIdsRecursive($startPages, $depth);

        $query = $this->createQuery();
        $query->getQuerySettings()->setStoragePageIds($storagePageIds);
        return $query->execute();
    }
}
