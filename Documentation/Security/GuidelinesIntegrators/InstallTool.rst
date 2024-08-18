.. include:: /Includes.rst.txt
.. index::
   Security guidelines; Install tool
   File; typo3conf/ENABLE_INSTALL_TOOL
.. _security-install-tool:

============
Install tool
============

The Install Tool allows you to configure the TYPO3 system on a very
low level, which means, not only the basic settings but also the most
essential settings can be changed.

.. _security-install-tool-access:

Enabling and accessing the Install Tool
=======================================

.. _security-install-tool-access-intro:

Introduction
------------

A TYPO3 backend account is not required in order to access the Install
Tool, so it is clear that the Install Tool requires some special attention
(and protection).

TYPO3 comes with a two-step mechanism out-of-the-box to protect the
Install Tool against unauthorized access:

1.  The :file:`ENABLE_INSTALL_TOOL` file must exist in order for the Install
    Tool to be accessible.
2.  An Install Tool password is required. This password is independent of
    all backend user passwords.

The Install Tool can be found as a stand-alone application via :samp:`https://example.org/typo3/install.php`.
It is also :ref:`accessible in the backend <security-install-tool-backend-access>`,
but only for logged-in users with administrator and maintainer privileges.

.. _security-install-tool-access-enable-file:

The :file:`ENABLE_INSTALL_TOOL` file
------------------------------------

The :file:`ENABLE_INSTALL_TOOL` file can be created by placing an empty
file in one of the following file paths:

..  versionchanged:: 12.2

..  tabs::

    ..  group-tab:: Composer-based installation

        *   :file:`var/transient/ENABLE_INSTALL_TOOL`
        *   :file:`config/ENABLE_INSTALL_TOOL`

    ..  group-tab:: Legacy installation

        *   :file:`typo3temp/var/transient/ENABLE_INSTALL_TOOL`
        *   :file:`typo3conf/ENABLE_INSTALL_TOOL`

You usually need write access to this directory on the server level (for example,
via SSH, SFTP, etc.) or you can create this file as a backend user with
administrator privileges.

..  tip::
    Add the :file:`ENABLE_INSTALL_TOOL` file to your project's :php:`.gitignore`
    file to avoid accidentally committing and deploying it to production
    environments.

.. include:: /Images/AutomaticScreenshots/AdminTools/EnableInstallTool.rst.txt

Conversely, this also means, you should delete this file as soon as
you do not need to access the Install Tool any more. TYPO3 automatically
deletes the :file:`ENABLE_INSTALL_TOOL` file when you log out of the Install
Tool or if the file is older than 60 minutes (expiry time).

Both features can be deactivated if the content of this file is `KEEP_FILE`.
This is strongly discouraged.

.. _security-install-tool-password:

The Install Tool password
-------------------------

The password for accessing the Install Tool is stored using the
:ref:`configured password hash mechanism <password-hashing>` set for the backend
in the global configuration file :file:`config/system/settings.php`:

.. code-block:: php
   :caption: config/system/settings.php

   <?php
   return [
       'BE' => [
           'installToolPassword' => '$P$CnawBtpk.D22VwoB2RsN0jCocLuQFp.',
           // ...
       ],
   ];

The Install Tool password is set during the
installation process. This means, in the case that a system administrator
hands over the TYPO3 instance to you, it should also provide you
with the appropriate password.

The first thing you should do, after taking over a new TYPO3 system from
a system administrator, is to change the password to a new and secure one.
Log-in to the Install Tool and change it there.

.. include:: /Images/AutomaticScreenshots/AdminTools/ChangeInstallToolPassword.rst.txt

.. _security-install-tool-backend-access:

Accessing the Install Tool in the backend
-----------------------------------------

The System Maintainer role allows for selected backend users to access the
:guilabel:`Admin Tools` components from within the backend without further
security measures.

The number of system maintainers should be as low as possible to mitigate
the risks of corrupted accounts.

Users can be assigned the role in the :guilabel:`Settings` section of
:guilabel:`Install Tool` -> :guilabel:`Manage System Maintainers`.
It is also possible to manually modify the list by adding or removing the
user's UID (:sql:`be_users.uid`) in :file:`config/system/settings.php`:

.. code-block:: php
   :caption: config/system/settings.php

   <?php
   return [
       // ...
       'SYS' => [
           'systemMaintainers' => [1, 7, 36],
           // ...
       ],
   ];


For additional security, the folders :file:`typo3/install` and :file:`typo3/sysext/install`
can be deleted, or password protected on a server level (e.g. by a web
server's user authentication mechanism). Please keep in mind that
these measures have an impact on the usability of the system. If you
are not the only person who uses the Install Tool, you should
discuss the best approach with the team.

.. _security-install-tool-core-updates:

TYPO3 Core updates
==================

In legacy installations the Install Tool allows integrators to update the
TYPO3 Core with a click on a button. This feature can be found under
:guilabel:`Important actions`, and it checks/installs revision updates only
(that is, bug fixes and security updates).

.. figure:: /Images/ManualScreenshots/Security/CoreUpdates.png
    :class: with-border with-shadow
    :alt: Install Tool function to update the TYPO3 Core

This feature can be disabled by an environment variable:

.. code-block:: none

   TYPO3_DISABLE_CORE_UPDATER=1


.. index:: Security guidelines; Encryption key
.. _security-encryption-key:

Encryption key
==============

The `encryptionKey` can be found in the Install Tool (module
:guilabel:`Settings` > :guilabel:`Configure Installation-Wide Options`).
This string, usually a hexadecimal hash value of 96 characters, is used
as the salt for various kinds of encryptions, checksums and validations
(for example for the :ref:`cHash <t3coreapi:chash>`). Therefore, a change
of this value invalidates temporary information, cache content, etc.
and you should clear all caches after you changed this value in order
to force the rebuild of this data with the new encryption key.

..  attention::
    Keep in mind that this string is security-related and you should keep
    it in a safe place.

.. _security-encryption-key-generate:

Generating the encryption key
-----------------------------

The encryption key should be a random 96 characters long hexadecimal string.
You can for example create it with OpenSSL:

..  code-block:: bash

    openssl rand -hex 48

It is possible to generate the encryption key via an API within TYPO3:

..  code-block:: php

    use \TYPO3\CMS\Core\Crypto\Random;
    use \TYPO3\CMS\Core\Utility\GeneralUtility;

    $encryptionKey = GeneralUtility::makeInstance(Random::class)->generateRandomHexString(96);
