<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Core\Country\Country;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Tea extends AbstractEntity
{
    protected ?Country $countryOfOrigin = null;

    public function getCountryOfOrigin(): ?Country
    {
        return $this->countryOfOrigin;
    }

    public function setCountryOfOrigin(?Country $countryOfOrigin): void
    {
        $this->countryOfOrigin = $countryOfOrigin;
    }
}
