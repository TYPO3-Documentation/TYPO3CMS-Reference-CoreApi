<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Conference extends AbstractEntity
{
    protected ?FileReference $logo = null;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $impressions;

    public function __construct()
    {
        $this->impressions = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->impressions = $this->impressions ?? new ObjectStorage();
    }

    public function getLogo(): ?FileReference
    {
        return $this->logo;
    }

    public function setLogo(?FileReference $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImpressions(): ObjectStorage
    {
        return $this->impressions;
    }

    public function setImpressions(ObjectStorage $impressions): void
    {
        $this->impressions = $impressions;
    }
}
