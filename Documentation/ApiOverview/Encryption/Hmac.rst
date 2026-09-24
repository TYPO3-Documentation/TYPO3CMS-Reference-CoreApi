:navigation-title: HMAC

..  include:: /Includes.rst.txt
..  _hmac:

=============================================
Sign a value with an HMAC of the hash service
=============================================

..  versionchanged:: 14.0

    TYPO3 Core signs cHash values, password reset tokens, file dump URLs,
    form protection tokens and session identifiers with SHA3-256 now. See
    `Breaking: #106307 - Use stronger cryptographic algorithm for HMAC
    <https://docs.typo3.org/permalink/changelog:breaking-106307-1763824774>`_.

An HMAC proves that TYPO3 created a value itself. Add such a signature to a
value that leaves the installation and comes back later, for example a
parameter of a URL. The :php:`\TYPO3\CMS\Core\Crypto\HashService`
creates and validates the signature.

The service builds the secret from the
:ref:`encryption key <typo3ConfVars_sys_encryptionKey>` of the installation
and from an additional secret that the caller passes. The additional secret
must not be empty. Pass a value that names the purpose of the signature, for
example the class that creates it.

..  _hmac-algorithm:

Choose the algorithm with the HashAlgo enum
===========================================

Every method takes a case of the enum :php:`\TYPO3\CMS\Core\Crypto\HashAlgo`
as its last argument. The enum provides `SHA1`, `SHA256`, `SHA384`,
`SHA512`, `SHA3_256`, `SHA3_384` and `SHA3_512`.

The methods still use `HashAlgo::SHA1` as the default, because another default
would invalidate every signature that an installation created before. Pass
`HashAlgo::SHA3_256` in new code. TYPO3 Core passes it since version 14.0.

Validate a value with the algorithm that signed it. Another algorithm produces
another signature, and the validation fails.

..  _hmac-sign-and-validate:

Sign and validate a value with the hash service
===============================================

The hash service provides four methods:

*   :php-short:`\TYPO3\CMS\Core\Crypto\HashService::hmac()`
    returns the signature of a value.
*   :php-short:`\TYPO3\CMS\Core\Crypto\HashService::appendHmac()`
    returns the value with the signature attached to it.
*   :php-short:`\TYPO3\CMS\Core\Crypto\HashService::validateHmac()`
    compares a value with a signature and returns a boolean.
*   :php-short:`\TYPO3\CMS\Core\Crypto\HashService::validateAndStripHmac()`
    removes the signature from a value and returns the value without it.
    It throws an
    :php:`\TYPO3\CMS\Core\Exception\Crypto\InvalidHashStringException`
    when the signature does not match, or when the value is shorter than the
    signature.

..  literalinclude:: _CodeSnippets/_DownloadLinkService.php
    :caption: packages/my_extension/Classes/Service/DownloadLinkService.php
