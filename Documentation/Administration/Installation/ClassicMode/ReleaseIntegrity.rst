..  include:: /Includes.rst.txt

..  _release_integrity:

=======================
TYPO3 release integrity
=======================

TYPO3 release packages (the downloadable tarballs and zip files) as well as
Git tags are signed using :abbr:`PGP (Pretty Good Privacy)` signatures during
the automated release process. SHA2-256, SHA1 and MD5 hashes are also generated
for these files.

Release contents
================

Every release of TYPO3 is made available with the following files:

..  code-block:: bash
    :caption: `TYPO3 CMS 12.4.11 <https://get.typo3.org/version/12#accordion-heading-zip>`_ release as an example

    typo3_src-12.4.11.tar.gz
    typo3_src-12.4.11.tar.gz.sig
    typo3_src-12.4.11.zip
    typo3_src-12.4.11.zip.sig

*   :file:`*.tar.gz` and :file:`*.zip` files are the actual release packages,
    containing the source code of TYPO3
*   :file:`*.sig` files contain the corresponding signatures for each release
    package file

Checking file hashes
====================

File hashes are used to check that a downloaded file was transferred and stored
correctly on the local system. TYPO3 uses cryptographic hash methods including `MD5`_
and `SHA2-256`_.

The file hashes for each version are published on get.typo3.org and can be found
on the corresponding release page, for example https://get.typo3.org/version/12#package-checksums contains:

..  code-block:: text
    :caption: TYPO3 v12.4.11 checksums
    :name: Checksums

    SHA256:
    a93bb3e8ceae5f00c77f985438dd948d2a33426ccfd7c2e0e5706325c43533a3  typo3_src-12.4.11.tar.gz
    8e0a8eaeed082e273289f3e17318817418c38c295833a12e7f94abb2845830ee  typo3_src-12.4.11.zip

    SHA1:
    9fcecf7b0e72074b060516c22115d57dd29fd5b0  typo3_src-12.4.11.tar.gz
    3606bcc9331f2875812ddafd89ccc2ddf8922b63  typo3_src-12.4.11.zip

    MD5:
    a4fbb1da81411f350081872fe2ff2dac  typo3_src-12.4.11.tar.gz
    c514ef9b7aad7c476fa4f36703e686fb  typo3_src-12.4.11.zip


To verify file hashes, the hashes need to be generated locally for the packages
downloaded and then compared to the published hashes on get.typo3.org.
To generate the hashes locally, one of the following command line tools
:bash:`md5sum`, :bash:`sha1sum` or :bash:`shasum` needs to be used.

The following commands generate hashes for the :file:`.tar.gz` and :file:`.zip`
packages:

..  code-block:: bash
    :caption: ~$

    shasum -a 256 typo3_src-*.tar.gz typo3_src-*.zip
    a93bb3e8ceae5f00c77f985438dd948d2a33426ccfd7c2e0e5706325c43533a3  typo3_src-12.4.11.tar.gz
    8e0a8eaeed082e273289f3e17318817418c38c295833a12e7f94abb2845830ee  typo3_src-12.4.11.zip

..  code-block:: bash
    :caption: ~$

    sha1sum -c typo3_src-*.tar.gz typo3_src-*.zip
    9fcecf7b0e72074b060516c22115d57dd29fd5b0  typo3_src-12.4.11.tar.gz
    3606bcc9331f2875812ddafd89ccc2ddf8922b63  typo3_src-12.4.11.zip

..  code-block:: bash
    :caption: ~$

    md5sum typo3_src-*.tar.gz typo3_src-*.zip
    a4fbb1da81411f350081872fe2ff2dac  typo3_src-12.4.11.tar.gz
    c514ef9b7aad7c476fa4f36703e686fb  typo3_src-12.4.11.zip

These hashes must match the hashes published on get.typo3.org to ensure package integrity.

..  _MD5: https://en.wikipedia.org/wiki/MD5
..  _SHA2-256: https://en.wikipedia.org/wiki/SHA-2


Checking file signatures
========================

TYPO3 uses `Pretty Good Privacy`_ to sign release packages and Git release tags.
To validate these signatures `The GNU Privacy Guard`_ is recommend, however
any `OpenPGP`_ compliant tool can also be used.

The release packages are using a detached binary signature. This means that
the file :file:`typo3_src-12.4.11.tar.gz` has an additional signature file
:file:`typo3_src-12.4.11.tar.gz.sig` which is the detached signature.

..  code-block:: bash
    :caption: ~$

    gpg --verify typo3_src-12.4.11.tar.gz.sig typo3_src-12.4.11.tar.gz

..  code-block:: text

    gpg: Signature made 13 Feb 2024 10:56:11 CET
    gpg:                using RSA key 2B1F3D58AEEFB6A7EE3241A0C19FAFD699012A5A
    gpg: Can't check signature: No public key

The warning means that the public key ``2B1F3D58AEEFB6A7EE3241A0C19FAFD699012A5A`` is not yet available on the
local system and cannot be used to validate the signature. The public key can be
obtained by any key server - a popular one is `pgpkeys.mit.edu`_.

..  code-block:: bash
    :caption: ~$

    wget -qO- https://get.typo3.org/KEYS | gpg --import

..  code-block:: text

    gpg: requesting key 59BC94C4 from hkp server pgpkeys.mit.edu
    gpg: key 59BC94C4: public key "TYPO3 Release Team (RELEASE) <typo3cms@typo3.org>" imported
    gpg: key FA9613D1: public key "Benjamin Mack <benni@typo3.org>" imported
    gpg: key 16490937: public key "Oliver Hader <oliver@typo3.org>" imported
    gpg: no ultimately trusted keys found
    gpg: Total number processed: 3
    gpg:               imported: 3  (RSA: 3)

Once the public key has been imported, the previous command on verifying the
signature of the :file:`typo3_src-12.4.11.tar.gz` file can be repeated.

..  code-block:: bash
    :caption: ~$

    gpg --verify typo3_src-12.4.11.tar.gz.sig typo3_src-12.4.11.tar.gz

..  code-block:: text

    gpg: Signature made Tue Feb 13 10:56:11 2024 CET
    gpg:                using RSA key 2B1F3D58AEEFB6A7EE3241A0C19FAFD699012A5A
    gpg: Good signature from "Oliver Hader <oliver@typo3.org>" [unknown]
    gpg:                 aka "Oliver Hader <oliver.hader@typo3.org>" [unknown]
    gpg: WARNING: This key is not certified with a trusted signature!
    gpg:          There is no indication that the signature belongs to the owner.
    Primary key fingerprint: 0C4E 4936 2CFA CA0B BFCE  5D16 A36E 4D1F 1649 0937
         Subkey fingerprint: 2B1F 3D58 AEEF B6A7 EE32  41A0 C19F AFD6 9901 2A5A

The new warning is expected since everybody could have created the public key
and uploaded it to the key server. The important point here is to validate the key
fingerprint `0C4E 4936 2CFA CA0B BFCE  5D16 A36E 4D1F 1649 0937` which is in
this case the correct one for TYPO3 CMS release packages (see below for a list
of currently used keys or access the https://get.typo3.org/KEYS file directly).

..  code-block:: bash
    :caption: ~$

    gpg --fingerprint 0C4E49362CFACA0BBFCE5D16A36E4D1F16490937

..  code-block:: text

    pub   rsa4096 2017-08-10 [SC] [expires: 2024-08-14]
         0C4E 4936 2CFA CA0B BFCE  5D16 A36E 4D1F 1649 0937
    uid           [ unknown] Oliver Hader <oliver@typo3.org>
    uid           [ unknown] Oliver Hader <oliver.hader@typo3.org>
    sub   rsa4096 2017-08-10 [E] [expires: 2024-08-14]
    sub   rsa4096 2017-08-10 [S] [expires: 2024-08-14]

..  _Pretty Good Privacy: https://en.wikipedia.org/wiki/Pretty_Good_Privacy
..  _The GNU Privacy Guard: http://www.gnupg.org/
..  _OpenPGP: http://www.openpgp.org/
..  _pgpkeys.mit.edu: https://pgpkeys.mit.edu/


Checking tag signature
======================

Checking signatures on Git tags works similar to verifying the results using the
:bash:`gpg` tool, but with using the :bash:`git tag --verify` command directly.

..  code-block:: bash
    :caption: ~$

    git tag --verify v12.4.11


..  code-block:: text

    object 3f83ff31e72053761f33b975410fa2881174e0e5
    type commit
    tag v12.4.11
    tagger Oliver Hader <oliver@typo3.org> 1707818102 +0100

    Release of TYPO3 12.4.11
    gpg: Signature made Tue Feb 13 10:55:02 2024 CET
    gpg:                using RSA key 2B1F3D58AEEFB6A7EE3241A0C19FAFD699012A5A
    gpg: Good signature from "Oliver Hader <oliver@typo3.org>" [unknown]
    gpg:                 aka "Oliver Hader <oliver.hader@typo3.org>" [unknown]
    Primary key fingerprint: 0C4E 4936 2CFA CA0B BFCE  5D16 A36E 4D1F 1649 0937
         Subkey fingerprint: 2B1F 3D58 AEEF B6A7 EE32  41A0 C19F AFD6 9901 2A5A

The :bash:`git show` command on the name of the tag reveals more details.

..  code-block:: bash
    :caption: ~$

    git show v12.4.11

..  code-block:: text

    tag v12.4.11
    Tagger: Oliver Hader <oliver@typo3.org>
    Date:   Tue Feb 13 10:55:02 2024 +0100

    Release of TYPO3 12.4.11
    -----BEGIN PGP SIGNATURE-----
    ...
    -----END PGP SIGNATURE-----



Public keys
===========

..  note::
    Starting in June 2017, TYPO3 releases have been cryptographically signed by the
    `TYPO3 Release Team <typo3cms@typo3.org>` with a dedicated public key.
    Since July 2017 releases are signed by individual members of the TYPO3
    Release Team directly, namely `Benni Mack <benni@typo3.org>` and
    `Oliver Hader <oliver@typo3.org>`.

You can download the used public keys from `get.typo3.org.keys`_

*   TYPO3 Release Team <typo3cms@typo3.org>

    *   4096 bit RSA key
    *   Key ID `0x9B9CB92E59BC94C4`_
    *   Fingerprint `7AF5 1AAA DED9 D002 4F89  B06B 9B9C B92E 59BC 94C4`

*   Benni Mack <benni@typo3.org>

    *   4096 bit RSA key
    *   Key ID `0x3304BBDBFA9613D1`_
    *   Fingerprint `E7ED 29A7 0309 A0D1 AE34  DA73 3304 BBDB FA96 13D1`

*   Oliver Hader <oliver@typo3.org>

    *   4096 bit RSA key
    *   Key ID `0xC19FAFD699012A5A`_, subkey of `0xA36E4D1F16490937`_
    *   Fingerprint `0C4E 4936 2CFA CA0B BFCE  5D16 A36E 4D1F 1649 0937`

*   Benjamin Franzke <ben@bnf.dev>

    *   256 bit Ed25519 key
    *   Key ID `0x6E19848CF6A4CF16`_
    *   Fingerprint `63BF 864E FCEC 136F 693C EF1B 6E19 848C F6A4 CF16`


.. _0x9B9CB92E59BC94C4: https://keys.openpgp.org/search?q=9B9CB92E59BC94C4
.. _0x3304BBDBFA9613D1: https://keys.openpgp.org/search?q=3304BBDBFA9613D1
.. _0xC19FAFD699012A5A: https://keys.openpgp.org/search?q=C19FAFD699012A5A
.. _0xA36E4D1F16490937: https://keys.openpgp.org/search?q=A36E4D1F16490937
.. _0x6E19848CF6A4CF16: https://keys.openpgp.org/search?q=6E19848CF6A4CF16
.. _get.typo3.org.keys: https://get.typo3.org/KEYS
