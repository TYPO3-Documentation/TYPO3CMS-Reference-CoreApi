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
essential settings can be changed. You do not necessarily need a TYPO3
backend account to access the Install Tool, so it is clear that the
Install Tool requires some special attention (and protection).

TYPO3 already comes with a two step mechanism out-of-the-box to
protect the Install Tool against unauthorized access: the first
measure is a file called :file:`ENABLE_INSTALL_TOOL` which must exist if
the Install Tool should be accessible. The second mechanism is a
password protection, which is independent of all backend user
passwords.

The Install Tool can be found as a stand alone application via :samp:`https://example.org/typo3/install.php`.
It also integrates with the backend, but is only available for logged in users with administrator privileges.

The :file:`ENABLE_INSTALL_TOOL` flag file can be created by placing an empty
file in one of the following file paths:

..  versionchanged:: 12.2

..  include:: /_includes/_EnableInstallTool.rst.txt
    :show-buttons:

You usually need write access to this directory on a server level (for example,
via SSH, SFTP, etc.) or you can create this file as a backend user with
administrator privileges.

..  tip::
    Add the :file:`ENABLE_INSTALL_TOOL` file to your project's :php:`.gitignore`
    file to avoid accidentally committing and deploying it to production
    environments.

..  include:: /Images/AutomaticScreenshots/AdminTools/EnableInstallTool.rst.txt

..  include:: /_includes/_EnableInstallToolWarning.rst.txt
    :show-buttons:

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

The role of system maintainer allows for selected
backend users to access the :guilabel:`Admin Tools` components from within the backend without further
security measures.
The number of system maintainers should be as small as possible to mitigate the risks of corrupted accounts.

The role can be provided in the Settings Section of the Install Tool -> Manage System Maintainers. It is also
possible to manually modify the list by adding or removing the be_users.uid of the user in :file:`config/system/settings.php`:

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
definitely discuss your intention with the team.


TYPO3 Core updates
==================

In legacy installations the Install Tool allows integrators to update the
TYPO3 Core with a click on a button. This feature can be found under
"Important actions" and it checks/installs revision updates only (e.g.
bug fixes and security updates).

.. figure:: /Images/ManualScreenshots/Security/CoreUpdates.png
    :class: with-border with-shadow
    :alt: Install Tool function to update the TYPO3 Core

It should be noted that this feature can be disabled by an environment
variable:

.. code-block:: none

   TYPO3_DISABLE_CORE_UPDATER=1


.. index:: Security guidelines; Encryption key
.. _security-encryption-key:

Encryption key
==============

The `encryptionKey` can be found in the Install Tool (module
*Settings > Configure Installation-Wide Options*). This string, usually a
hexadecimal hash value of 96 characters, is used as the "salt" for
various kinds of encryption, check sums and validations (e.g. for
the `cHash`). Therefore, a change of this value invalidates temporary
information, cache content, etc. and you should clear all caches after
you changed this value in order to force the rebuild of this data with
the new encryption key.

..  attention::
    Keep in mind that this string is security-related and you should keep
    it in a safe place.

The encryption key should be a random hexadecimal key of length 96. You can
for example create it with OpenSSL:

..  code-block:: bash

    openssl rand -hex 48

From within TYPO3 it is possible to generate it via API:


..  code-block:: php

    use  \TYPO3\CMS\Core\Crypto\Random;

    $this->random->generateRandomHexString(96);
