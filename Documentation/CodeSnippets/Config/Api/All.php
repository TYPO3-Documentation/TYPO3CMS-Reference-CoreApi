<?php

// https://github.com/TYPO3-Documentation/t3docs-codesnippets
// ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/

return array_merge(
    include ('Events/All.php'),
    include ('BackendApi.php'),
    include ('Cache.php'),
    include ('CountryApi.php'),
    include ('Database.php'),
    include ('Entity.php'),
    include ('LanguageServiceApi.php'),
    include ('Middleware.php'),
    include ('Registry.php'),
    include ('SessionManagement.php'),
    include ('Resource.php'),
    include ('Sites.php'),
);
