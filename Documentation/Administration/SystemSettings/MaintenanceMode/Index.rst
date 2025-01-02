:navigation-title: Maintenance Mode
..  include:: /Includes.rst.txt
..  _maintenance-mode:

=======================================================
Maintenance mode: Prevent backend logins during upgrade
=======================================================

Set the backend into maintenance mode to prevent editors or even all
administrators and CLI tools to access the TYPO3 backend.

The maintenance mode is useful to prevent changes to the content during
`Patch/Bugfix update <https://docs.typo3.org/permalink/t3coreapi:minor>`_
and `Major upgrade <https://docs.typo3.org/permalink/t3coreapi:major>`_,
database backups or in any other case where you want to prevent backend
users from accessing the backend.

..  note:: During maintenance mode the TYPO3 frontend works as usual. Depending
    on your sites functionality, frontend actions might continue to alter
    certain database tables or files in the file system.

..  _maintenance-mode-total:

Total shutdown for maintenance purposes
=======================================

A system maintainer can achieve total TYPO3 backend shutdown for maintenance
purposes in module
:guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`
by setting :ref:`[BE][adminOnly] <t3coreapi:confval-globals-typo3-conf-vars-be-adminonly>`
to `-1`.

It is also possible to add and remove this setting manually to the
`additional.php <https://docs.typo3.org/permalink/t3coreapi:configuration-files>`_:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    // Lock the backend for editors, admins and CLI are allowed
    $GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] = -1;

This setting excludes any user, including administrators like yourself from
accessing the TYPO3 backend or using any console command in `vendor/bin/typo3`.
Scheduler tasks will also not be triggered.

A similar effect can be achieved by creating a flag file,
:ref:`LOCK_BACKEND <t3coreapi:confval-flag-file-lock-backend>` via console
command:

..  code-block:: bash

    vendor/bin/typo3 backend:lock

The flag file prevents any backend access, even by an administrator, it does
however not disable the console command tool and can therefore be disabled
via command:

..  code-block:: bash

    vendor/bin/typo3 backend:unlock

..  tip::
    If you edit the :ref:`var/lock/LOCK_BACKEND <t3coreapi:confval-flag-file-lock-backend>`
    file and put a valid URL into this file, users trying to log into the backend
    are redirected to that URL instead of being shown an error message. You can
    use this feature to show a custom maintenance message.

..  _maintenance-mode-editors:

Lock the TYPO3 backend for editors
==================================

To prevent an installation's editors from logging into the TYPO3 backend during
maintenance, go to module
:guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`
and set :ref:`[BE][adminOnly] <t3coreapi:confval-globals-typo3-conf-vars-be-adminonly>`
to `2` if you additionally want to block console commands including scheduler
tasks, set it to `1`.

It is also possible to add and remove this setting manually to the
`additional.php <https://docs.typo3.org/permalink/t3coreapi:configuration-files>`_:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    // Lock the backend for editors, admins and CLI are allowed
    $GLOBALS['TYPO3_CONF_VARS']['BE']['adminOnly'] = 2;
