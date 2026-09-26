<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Crypto\HashAlgo;
use TYPO3\CMS\Core\Crypto\HashService;

final readonly class DownloadLinkService
{
  public function __construct(private HashService $hashService) {}

  public function createToken(int $fileUid): string
  {
    return $this->hashService->hmac(
      (string)$fileUid,
      self::class,
      HashAlgo::SHA3_256,
    );
  }

  public function isValidToken(int $fileUid, string $token): bool
  {
    return $this->hashService->validateHmac(
      (string)$fileUid,
      self::class,
      $token,
      HashAlgo::SHA3_256,
    );
  }
}
