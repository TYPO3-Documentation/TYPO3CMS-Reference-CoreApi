<?php

// https://github.com/TYPO3-Documentation/t3docs-codesnippets
// ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/

return array_merge(
    include ('DataProcessing.php'),
    include ('FlexForms.php'),
    include ('LoginProvider.php'),
    include ('ManualCore.php'),
);
