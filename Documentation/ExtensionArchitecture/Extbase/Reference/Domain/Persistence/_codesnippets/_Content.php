<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Content extends AbstractEntity
{
    protected string $header = '';
    protected string $bodytext = '';

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    public function getBodytext(): string
    {
        return $this->bodytext;
    }

    public function setBodytext(string $bodytext): void
    {
        $this->bodytext = $bodytext;
    }
}
