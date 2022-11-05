<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Session\SessionManager::class,
        'targetFileName' => 'ApiOverview/SessionStorageFramework/_SessionManager.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Session\UserSession::class,
        'targetFileName' => 'ApiOverview/SessionStorageFramework/_UserSession.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Session\UserSessionManager::class,
        'targetFileName' => 'ApiOverview/SessionStorageFramework/_UserSessionManager.rst.txt',
        'withCode' => false,
    ],
];
