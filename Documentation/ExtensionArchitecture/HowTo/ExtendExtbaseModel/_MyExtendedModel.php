<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use OriginalVendor\OriginalExtension\Domain\Model\SomeModel;

class MyExtendedModel extends SomeModel
{
    protected string $txMyExtensionAdditionalField;

    public function getTxMyExtensionAdditionalField(): string
    {
        return $this->txMyExtensionAdditionalField;
    }

    public function setTxMyExtensionAdditionalField(string $txMyExtensionAdditionalField): void
    {
        $this->txMyExtensionAdditionalField = $txMyExtensionAdditionalField;
    }
}
