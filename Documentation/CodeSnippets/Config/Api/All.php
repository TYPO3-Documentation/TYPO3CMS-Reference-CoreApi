<?php

// https://github.com/TYPO3-Documentation/t3docs-codesnippets
// ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/

return array_merge(
    include('Events/All.php'),
    include('BackendApi.php'),
    include('LanguageServiceApi.php'),
    include('SessionManagement.php'),
);
