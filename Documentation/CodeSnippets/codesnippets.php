<?php

    // https://github.com/TYPO3-Documentation/t3docs-codesnippets
    // ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/

    return array_merge(
        include('Config/Extbase.php'),
        include('Config/EventsBackend.php'),
        include('Config/EventsCore.php'),
        include('Config/EventsCoreResource.php'),
        include('Config/EventsExtbase.php'),
        include('Config/EventsExtensionManager.php'),
        include('Config/EventsFilelist.php'),
        include('Config/EventsFrontend.php'),
        include('Config/EventsFrontendLogin.php'),
        include('Config/EventsImpexp.php'),
        include('Config/EventsInfo.php'),
        include('Config/EventsInstall.php'),
        include('Config/EventsLinkvalidator.php'),
        include('Config/EventsRecordlist.php'),
        include('Config/EventsRedirects.php'),
        include('Config/EventsSeo.php'),
        include('Config/EventsSetup.php'),
        include('Config/EventsWorkspaces.php'),
        include('Config/ManualBackend.php'),
        include('Config/ManualCore.php'),
        include('Config/LoginProvider.php'),
        include('Config/Tutorials/Tea.php'),
        include('Config/Tutorials/CommandControllers.php'),
    );