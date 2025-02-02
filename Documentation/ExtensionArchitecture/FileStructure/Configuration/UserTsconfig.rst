..  include:: /Includes.rst.txt
..  index::
    Extension development; Configuration/user.tsconfig
    Path; EXT:{extkey}/Configuration/user.tsconfig
..  _extension-configuration-user_tsconfig:

=====================
:file:`user.tsconfig`
=====================

..  typo3:file:: user.tsconfig
    :scope: extension
    :path: /Configuration/
    :regex: /^.*Configuration\/user\.tsconfig$/
    :shortDescription: Global user TSconfig

In this file global :ref:`user TSconfig <t3tsref:usertsconfig>` can be stored. It will
be automatically included for the whole TYPO3 installation during build time.

For details see
:ref:`Setting the user TSconfig globally <t3tsref:usersettingdefaultusertsconfig>`.

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/user.tsconfig

    page.TCEMAIN.table.pages.disablePrependAtCopy = 1
