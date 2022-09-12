<?php

return [
    [
        'action'=> 'createPhpClassDocs',
        'class'=> \TYPO3\CMS\Core\Session\UserSessionManager::class,
        'targetFileName'=> 'Api/SessionStorage/UserSessionManager.rst.txt',
        'withCode'=> false
    ],
    [
        'action'=> 'createPhpClassDocs',
        'class'=> \TYPO3\CMS\Core\Session\UserSession::class,
        'targetFileName'=> 'Api/SessionStorage/UserSession.rst.txt',
        'withCode'=> false
    ],
];