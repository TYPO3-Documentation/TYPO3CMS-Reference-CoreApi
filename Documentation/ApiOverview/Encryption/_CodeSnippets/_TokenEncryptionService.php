<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Crypto\Cipher\CipherDecryptionFailedException;
use TYPO3\CMS\Core\Crypto\Cipher\CipherService;
use TYPO3\CMS\Core\Crypto\Cipher\CipherValue;
use TYPO3\CMS\Core\Crypto\Cipher\KeyFactory;

final readonly class TokenEncryptionService
{
  public function __construct(
    private CipherService $cipherService,
    private KeyFactory $keyFactory,
  ) {}

  public function encryptToken(string $token): string
  {
    $key = $this->keyFactory->deriveSharedKeyFromEncryptionKey(self::class);
    return (string)$this->cipherService->encrypt($token, $key);
  }

  public function decryptToken(string $storedToken): string
  {
    $key = $this->keyFactory->deriveSharedKeyFromEncryptionKey(self::class);
    try {
      $cipherValue = CipherValue::fromSerialized($storedToken);
      return $this->cipherService->decrypt($cipherValue, $key);
    } catch (CipherDecryptionFailedException $exception) {
      throw new \RuntimeException(
        'The stored token cannot be decrypted',
        1758700800,
        $exception,
      );
    }
  }
}
