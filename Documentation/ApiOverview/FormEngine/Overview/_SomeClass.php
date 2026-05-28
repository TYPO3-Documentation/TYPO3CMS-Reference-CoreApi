<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Backend\Form\FormResult;
use TYPO3\CMS\Backend\Form\FormResultFactory;
use TYPO3\CMS\Backend\Form\FormResultHandler;
use TYPO3\CMS\Backend\Form\NodeFactory;

final class SomeClass
{
    public function __construct(
        private readonly TcaDatabaseRecord $formDataGroup,
        private readonly FormDataCompiler $formDataCompiler,
        private readonly NodeFactory $nodeFactory,
        private readonly FormResultFactory $formResultFactory,
        private readonly FormResultHandler $formResultHandler,
    ) {}

    /**
     * @throws \TYPO3\CMS\Backend\Form\Exception
     */
    public function someMethod(string $request, string $table, int $theUid, string $command): string
    {
        $formDataCompilerInput = [
            'request' => $request, // the PSR-7 request object
            'tableName' => $table,
            'vanillaUid' => $theUid,
            'command' => $command,
        ];
        $formData = $this->formDataCompiler->compile($formDataCompilerInput, $this->formDataGroup);
        $formData['renderType'] = 'outerWrapContainer';
        /** @var array $rawFormResult */
        $rawFormResult = $this->nodeFactory->create($formData)->render();
        // Convert the raw result array into a FormResult object
        /** @var FormResult $formResult */
        $formResult = $this->formResultFactory->create($rawFormResult);

        // Use FormResultHandler to pass collected assets (JS, CSS, labels) to PageRenderer
        $this->formResultHandler->addAssets($formResult);

        // Form HTML markup is accessible in the FormResult DTO
        return $formResult->html;
    }
}
