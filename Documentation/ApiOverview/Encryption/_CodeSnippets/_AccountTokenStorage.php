<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Crypto\Cipher\CipherService;
use TYPO3\CMS\Core\Crypto\Cipher\CipherValue;
use TYPO3\CMS\Core\Crypto\Cipher\KeyFactory;

final readonly class AccountTokenStorage
{
  private const TABLE = 'tx_myextension_domain_model_account';

  public function __construct(
    private CipherService $cipherService,
    private KeyFactory $keyFactory,
  ) {}

  public function encryptToken(string $token, int $accountUid): string
  {
    $key = $this->keyFactory->deriveSharedKeyFromEncryptionKey(self::class);
    $cipherValue = $this->cipherService->encrypt(
      $token,
      $key,
      $this->buildContext($accountUid),
    );
    return (string)$cipherValue;
  }

  public function decryptToken(string $storedToken, int $accountUid): string
  {
    $key = $this->keyFactory->deriveSharedKeyFromEncryptionKey(self::class);
    // A token of another account record throws a
    // CipherDecryptionFailedException here
    return $this->cipherService->decrypt(
      CipherValue::fromSerialized($storedToken),
      $key,
      $this->buildContext($accountUid),
    );
  }

  private function buildContext(int $accountUid): string
  {
    return self::TABLE . ':' . $accountUid;
  }
}
