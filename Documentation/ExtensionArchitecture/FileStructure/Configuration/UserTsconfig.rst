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

..  typo3:file:: user.tsconfig
    :scope: extension
    :path: /Configuration/
    :regex: /^.*Configuration\/user\.tsconfig$/
    :shortDescription: Global user TSconfig

This file stores global :ref:`user TSconfig <t3tsref:usertsconfig>`. It is
automatically included for the whole TYPO3 installation during build time.

For details, see
:ref:`Setting user TSconfig globally <t3tsref:usersettingdefaultusertsconfig>`.


..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    page.TCEMAIN.table.pages.disablePrependAtCopy = 1
