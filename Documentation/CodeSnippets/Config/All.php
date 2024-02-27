<?php

// https://github.com/TYPO3-Documentation/t3docs-codesnippets
// ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/

return array_merge(
    include ('Api/All.php'),
    include ('Examples/All.php'),
    include ('ExtensionDevelopment/All.php'),
    include ('Tutorials/All.php'),
);
