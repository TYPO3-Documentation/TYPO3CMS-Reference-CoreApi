<?php

use TYPO3\CMS\Backend\Clipboard\Clipboard;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ModuleController extends ActionController implements LoggerAwareInterface
{
    protected function getCurrentClipboard(): array
    {
        /** @var $clipboard Clipboard */
        $clipboard = GeneralUtility::makeInstance(Clipboard::class);
        // Read the clipboard content from the user session
        $clipboard->initializeClipboard();
        // Access files and pages content of current pad
        $clipboardContent = [
            'files' => $clipboard->elFromTable('_FILE'),
            'pages' => $clipboard->elFromTable('pages'),
        ];
        return $clipboardContent;
    }
}
