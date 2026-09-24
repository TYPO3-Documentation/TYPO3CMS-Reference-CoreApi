:navigation-title: Encryption

..  include:: /Includes.rst.txt
..  _encryption:

==========================================================
Encrypt and decrypt sensitive data with the cipher service
==========================================================

..  versionadded:: 14.0

    See `Feature: #108002 - Introduce built-in symmetric encryption/decryption
    cipher service
    <https://docs.typo3.org/permalink/changelog:feature-108002-1762466108>`_.

An extension sometimes has to store a value that it needs again in plain text,
for example an API token of a third-party service. The
:php:`\TYPO3\CMS\Core\Crypto\Cipher\CipherService` encrypts and decrypts
such a value. It uses the XChaCha20-Poly1305 cipher of the PHP extension
`sodium`. The cipher authenticates the data as well: the service rejects a
value that somebody changed after the encryption.

Do not use the cipher service for a password of a website user. A password is
verified, not decrypted. Use :ref:`password hashing <password-hashing>` for it.

..  _encryption-key:

Derive a key from the TYPO3 encryption key
==========================================

The cipher service needs a key. The
:php:`\TYPO3\CMS\Core\Crypto\Cipher\KeyFactory` derives that key from the
:ref:`encryption key <typo3ConfVars_sys_encryptionKey>` of the installation.
Pass a seed to the method
:php-short:`\TYPO3\CMS\Core\Crypto\Cipher\KeyFactory::deriveSharedKeyFromEncryptionKey()`.
The seed names the purpose of the key, for example the class that uses it.
Each seed produces a different key.

..  warning::

    The cipher service cannot decrypt the value after somebody changed the
    encryption key of the installation. Keep a backup of the encryption key.

The factory also creates a key without the encryption key. The method
:php-short:`\TYPO3\CMS\Core\Crypto\Cipher\KeyFactory::createSharedKeyFromString()`
takes a key of your own, for example from an environment variable. The method
:php-short:`\TYPO3\CMS\Core\Crypto\Cipher\KeyFactory::generateSharedKey()`
returns a new random key. Store such a key yourself, otherwise the data stays
encrypted forever.

..  _encryption-encrypt-and-decrypt:

Encrypt and decrypt a value with the cipher service
===================================================

The method :php-short:`\TYPO3\CMS\Core\Crypto\Cipher\CipherService::encrypt()`
returns a :php:`\TYPO3\CMS\Core\Crypto\Cipher\CipherValue` object. Cast that
object to a string to store it. Each call returns a different string, because
the service uses a new random nonce every time.

The method :php-short:`\TYPO3\CMS\Core\Crypto\Cipher\CipherService::decrypt()`
takes the cipher value back. Build it from the stored string with
:php-short:`\TYPO3\CMS\Core\Crypto\Cipher\CipherValue::fromSerialized()`.
The method throws a
:php:`\TYPO3\CMS\Core\Crypto\Cipher\CipherDecryptionFailedException`
when the key is wrong or when somebody changed the stored value. Catch that
exception.

..  literalinclude:: _CodeSnippets/_TokenEncryptionService.php
    :caption: packages/my_extension/Classes/Service/TokenEncryptionService.php

..  _encryption-additional-data:

Bind encrypted data to a context with additional authenticated data
===================================================================

Both methods take additional authenticated data as a third argument. The
service does not encrypt this data. It includes the data in the integrity
check instead. The decryption therefore only succeeds when the caller passes
the same data again.

Use this argument to bind a value to the record that it belongs to. The
example stores an API token in an account record. It passes the table name
and the uid of the record as additional data.

..  literalinclude:: _CodeSnippets/_AccountTokenEncryptionService.php
    :caption: packages/my_extension/Classes/Service/AccountTokenEncryptionService.php

Somebody who copies the stored token of account 5 into account 7 gains
nothing. The service builds the additional data from the uid of account 7 and
refuses to decrypt the token.
