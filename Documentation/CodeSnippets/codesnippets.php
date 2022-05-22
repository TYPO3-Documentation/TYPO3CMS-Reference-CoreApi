<?php

    return array_merge(
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
    );