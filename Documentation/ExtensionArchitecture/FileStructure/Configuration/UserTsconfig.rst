..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/user.tsconfig
    Path; EXT:{extkey}/Configuration/user.tsconfig
..  _extension-configuration-user_tsconfig:

=====================
:file:`user.tsconfig`
=====================

..  versionadded:: 13.0
    Starting with TYPO3 version 13.0 user TSconfig from
    :file:`Configuration/user.tsconfig` is automatically included.

In this file global :ref:`user TSconfig <usertsconfig>` can be stored. It will
be automatically included for the whole TYPO3 installation during build time.

For details see
:ref:`Setting the user TSconfig globally <t3tsconfig:usersettingdefaultusertsconfig>`.


..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    page.TCEMAIN.table.pages.disablePrependAtCopy = 1
