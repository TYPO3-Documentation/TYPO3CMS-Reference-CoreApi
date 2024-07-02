<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use MyVendor\MyExtension\Domain\Model\SomeModel;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Crypto\HashService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

class SomeClass
{
    public function __construct(private readonly HashService $hashService) {}
    public function getPublicUrl(SomeModel $resourceObject): string
    {
        $queryParameterArray = ['eID' => 'dumpFile', 't' => 'p'];
        $queryParameterArray['p'] = $resourceObject->getUid();
        $queryParameterArray['token'] = $this->hashService->hmac(
            implode('|', $queryParameterArray),
            'resourceStorageDumpFile',
        );
        $publicUrl = GeneralUtility::locationHeaderUrl(PathUtility::getAbsoluteWebPath(Environment::getPublicPath() . '/index.php'));
        $publicUrl .= '?' . http_build_query($queryParameterArray, '', '&', PHP_QUERY_RFC3986);
        return $publicUrl;
    }
}
