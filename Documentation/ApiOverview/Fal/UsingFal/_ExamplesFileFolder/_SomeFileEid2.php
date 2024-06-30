<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use MyVendor\MyExtension\Domain\Model\SomeModel;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

class SomeClass {
    public function getPublicUrl(SomeModel $resourceObject): string {
        $queryParameterArray = ['eID' => 'dumpFile', 't' => 'r'];
        $queryParameterArray['f'] = $resourceObject->getUid();
        $queryParameterArray['s'] = '320c:280c:320:280:320:280';
        $queryParameterArray['cv'] = 'default';
        $queryParameterArray['token'] = GeneralUtility::hmac(implode('|', $queryParameterArray), 'resourceStorageDumpFile');
        $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
        $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);
        return $publicUrl;
    }
}
