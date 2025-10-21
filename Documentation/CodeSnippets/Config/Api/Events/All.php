<?php

// https://github.com/TYPO3-Documentation/t3docs-codesnippets
// ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/

return array_merge(
    include ('EventsBackend.php'),
    include ('EventsCore.php'),
    include ('EventsCoreResource.php'),
    include ('EventsExtbase.php'),
    include ('EventsExtensionManager.php'),
    include ('EventsFilelist.php'),
    include ('EventsForm.php'),
    include ('EventsFrontend.php'),
    include ('EventsFrontendLogin.php'),
    include ('EventsImpexp.php'),
    include ('EventsIndexedSearch.php'),
    include ('EventsInfo.php'),
    include ('EventsInstall.php'),
    include ('EventsLocalization.php'),
    include ('EventsLinkvalidator.php'),
    include ('EventsLowlevel.php'),
    include ('EventsRedirects.php'),
    include ('EventsScheduler.php'),
    include ('EventsSeo.php'),
    include ('EventsSetup.php'),
    include ('EventsWorkspaces.php'),
);
