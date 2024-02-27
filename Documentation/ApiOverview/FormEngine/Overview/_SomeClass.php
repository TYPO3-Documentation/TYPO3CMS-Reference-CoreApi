<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Backend\Form\FormResultCompiler;
use TYPO3\CMS\Backend\Form\NodeFactory;

final class SomeClass
{
    public function __construct(
        private readonly TcaDatabaseRecord $formDataGroup,
        private readonly FormDataCompiler $formDataCompiler,
        private readonly NodeFactory $nodeFactory,
        private readonly FormResultCompiler $formResultCompiler,
    ) {}

    /**
     * @throws \TYPO3\CMS\Backend\Form\Exception
     */
    public function someMethod(string $request, string $table, int $theUid, string $command): void
    {
        $formDataCompilerInput = [
            'request' => $request, // the PSR-7 request object
            'tableName' => $table,
            'vanillaUid' => $theUid,
            'command' => $command,
        ];
        $formData = $this->formDataCompiler->compile($formDataCompilerInput, $this->formDataGroup);
        $formData['renderType'] = 'outerWrapContainer';
        $formResult = $this->nodeFactory->create($formData)->render();
        $this->formResultCompiler->mergeResult($formResult);
    }
}
