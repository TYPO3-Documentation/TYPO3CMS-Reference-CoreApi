:navigation-title: System Administrators

..  include:: /Includes.rst.txt
..  index:: Security guidelines; Administrators
..  _security-administrators:

=============================================
Security guidelines for system administrators
=============================================

#.  Follow the `TYPO3 Security Advisories <http://typo3.org/help/security-advisories>`_.
    Subscribe to the advisories via mailing list or RSS feed.

#.  Update the TYPO3 Core or any affected
    third-party extensions as soon as possible after security fixes are released.

#.  Use individual account names. Do not share accounts. For example,
    administrator and system maintainer account names should be something like
    `john.doe`. Do not use general usernames like "admin".

#.  Use different passwords for the
    `Install Tool <https://docs.typo3.org/permalink/t3coreapi:security-install-tool-password>`_
    and your personal backend login. Do not reuse passwords across multiple
    TYPO3 installations.

#.  Follow the guidelines for
    `secure passwords <https://docs.typo3.org/permalink/t3coreapi:security-secure-passwords>`_
    in this document. Implement secure
    `password policies <https://docs.typo3.org/permalink/t3coreapi:password-policies>`_.

#.  Never use the same password for a TYPO3 installation and other
    services such as FTP, SSH, etc.

#.  If you are responsible for the setup and configuration of TYPO3,
    carefully follow the
    `Guidelines for TYPO3 integrators <https://docs.typo3.org/permalink/t3coreapi:security-integrators>`_
    which are documented in the next chapter.

Please refer to the chapters below for security-related topics of
interest to administrators:

..  toctree::
    :caption: Further topics
    :titlesonly:

    RoleDefinition
    IntegrityOfTypo3Packages
    FileDirectoryPermissions
    RestrictAccessToFiles
    DirectoryIndexing
    FileExtensionHandling
    ContentSecurityPolicy
    DatabaseAccess
    Backups
    EncryptedCommunication
    OtherServices
    FurtherActions
