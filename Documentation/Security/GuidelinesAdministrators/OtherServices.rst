:navigation-title: Insecure Uploads

.. include:: /Includes.rst.txt
.. _security-other-services:

===========================
Avoid insecure file uploads
===========================

Uploading untrusted scripts (e.g. PHP, Perl, Python) or executables into the
web root is a major security risk. TYPO3 prevents this via backend restrictions
(see :ref:`Global TYPO3 configuration options <security-global-typo3-options>`).

These safeguards are bypassed if services like :abbr:`FTP`, :abbr:`SFTP`,
:abbr:`SSH`, or :abbr:`WebDAV` allow direct file uploads—commonly into
:file:`fileadmin/`.

Such access can enable:

-   Upload of malicious scripts
-   Overwriting TYPO3 Core files
-   Abuse via leaked credentials

Recommended actions:

-   **Disable FTP/SFTP/SSH access** to the document root for users.
-   **Use the TYPO3 backend** for all file uploads.
-   **Enforce secure upload policies** through TYPO3’s file storage configuration.

..  warning::
    The TYPO3 Security Team considers FTP insecure due to lack of encryption.
    **Do not use FTP under any circumstances.**
