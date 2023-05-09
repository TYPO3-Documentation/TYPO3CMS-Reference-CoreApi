<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Containers;

use TYPO3\CMS\Backend\Form\Container\AbstractContainer;

final class SomeContainer extends AbstractContainer
{
    public function render(): array
    {
        $result = $this->initializeResultArray();
        $data = $this->data;
        $data['renderType'] = 'subContainer';
        $childArray = $this->nodeFactory->create($data)->render();
        $resultArray = $this->mergeChildReturnIntoExistingResult($result, $childArray, false);
        $result['html'] = '<h1>A headline</h1>' . $childArray['html'];
        return $result;
    }
}
