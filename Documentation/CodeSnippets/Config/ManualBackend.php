<?php

return [
    [
        "action" => "createPhpClassDocs",
        "class" => \TYPO3\CMS\Backend\Module\ModuleInterface::class,
        "targetFileName" => "Manual/Backend/ModuleInterface.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => \TYPO3\CMS\Backend\Module\ModuleProvider::class,
        "targetFileName" => "Manual/Backend/ModuleProvider.rst.txt",
        "withCode" => false
    ],
    [
        "action" => "createPhpClassDocs",
        "class" => \TYPO3\CMS\Backend\Preview\PreviewRendererInterface::class,
        "targetFileName" => "Manual/Backend/PreviewRendererInterface.rst.txt",
        "withCode" => false
    ],
];
