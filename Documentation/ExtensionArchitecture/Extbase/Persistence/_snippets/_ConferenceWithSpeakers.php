<?php

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Conference extends AbstractEntity
{
    /**
     * @var ObjectStorage<Speaker>
     */
    protected ObjectStorage $speakers;

    public function __construct()
    {
        $this->speakers = new ObjectStorage();
    }

    public function getSpeakers(): ObjectStorage
    {
        return $this->speakers;
    }

    public function setSpeakers(ObjectStorage $speakers): void
    {
        $this->speakers = $speakers;
    }

    public function addSpeaker(Speaker $speaker): void
    {
        $this->speakers->attach($speaker);
    }

    public function removeSpeaker(Speaker $speaker): void
    {
        // Detaches the link only — the Speaker record itself is not deleted,
        // because it may still belong to other conferences.
        $this->speakers->detach($speaker);
    }
}
