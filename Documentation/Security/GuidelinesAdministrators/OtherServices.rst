:navigation-title: Insecure Uploads

.. include:: /Includes.rst.txt
.. _security-other-services:

===========================
Avoid insecure file uploads
===========================

Uploading untrusted scripts (e.g. PHP, Perl, Python) or executables into the
web root is a major security risk. TYPO3 prevents this via backend restrictions
(see :ref:`Global TYPO3 configuration options <security-global-typo3-options>`).

These safeguards are bypassed if services like :abbr:`FTP (File Transfer Protocol)`,
:abbr:`SFTP (SSH File Transfer Protocol)`, :abbr:`SSH (Secure Shell)`, or
:abbr:`WebDAV (Web Distributed Authoring and Versioning)` allow direct file
uploads—commonly into :file:`fileadmin/`.

Such access can lead to:

-   Upload of malicious scripts
-   TYPO3 Core files being overwritten
-   Abuse via leaked credentials

Recommended actions:

-   **Disable FTP/SFTP/SSH access** to the document root for users.
-   **Use the TYPO3 backend** for file uploads.
-   **Enforce secure upload policies** in the TYPO3 file storage configuration.

..  warning::
    The TYPO3 Security Team considers FTP to be insecure due to the lack of encryption.
    **Do not use FTP under any circumstances.**
