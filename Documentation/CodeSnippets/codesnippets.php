<?php

    // https://github.com/TYPO3-Documentation/t3docs-codesnippets
    // ddev exec vendor/bin/typo3  restructured_api_tools:php_domain public/fileadmin/TYPO3CMS-Reference-CoreApi/Documentation/CodeSnippets/

    return array_merge(
        include('Config/EventsBackend.php'),
        include('Config/EventsCore.php'),
        include('Config/EventsCoreResource.php'),
        include('Config/EventsExtbase.php'),
        include('Config/EventsExtensionManager.php'),
        include('Config/EventsFrontend.php'),
        include('Config/EventsFrontendLogin.php'),
        include('Config/EventsImpexp.php'),
        include('Config/EventsInstall.php'),
        include('Config/EventsLinkvalidator.php'),
        include('Config/EventsSeo.php'),
        include('Config/EventsSetup.php'),
        include('Config/EventsWorkspaces.php'),
    );