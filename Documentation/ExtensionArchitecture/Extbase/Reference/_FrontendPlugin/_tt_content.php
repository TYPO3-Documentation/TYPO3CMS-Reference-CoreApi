<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

(static function (): void {
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'BlogExample',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PostSingle',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'Single Post (BlogExample)',
        // plugin icon, use an icon identifier from the icon registry
        'my-icon',
        // plugin group, to define where the new plugin will be located in
        'default',
        // plugin description, as visible in the new content element wizard
        'My plugin description',
    );
})();
