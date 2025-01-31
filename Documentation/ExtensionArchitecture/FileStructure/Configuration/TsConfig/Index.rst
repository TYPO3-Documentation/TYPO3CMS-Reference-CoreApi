.. include:: /Includes.rst.txt
.. _extension-configuration-tsconfig:
.. index:: Path; EXT:{extkey}/Configuration/TsConfig

================
:file:`TsConfig`
================

..  versionadded:: 13.1

    Page TSconfig can be set using
    `the site et as Page TSconfig provider <https://docs.typo3.org/permalink/t3tsref:include-static-page-tsconfig-per-site>`_

    Default user TSconfig can be provided in file
    :ref:`extension-configuration-user_tsconfig`.

..  typo3:file:: something.tsconfig
    :scope: extension
    :path: /Configuration/TsConfig/Page
    :regex: /^.*Configuration\/TsConfig\/Page\/.*\.tsconfig$/
    :shortDescription: Contains page TSconfig files. The path is convention, the files must end on .tsconfig.

    page TSconfig, see chapter :ref:`'page TSconfig' in the TSconfig Reference
    <t3tsref:PageTSconfig>`. Files should have the file extension
    :file:`.tsconfig`.

..  typo3:file:: something.tsconfig
    :scope: extension
    :path: /Configuration/TsConfig/User
    :regex: /^.*Configuration\/TsConfig\/User\/.*\.tsconfig$/
    :shortDescription: Contains page TSconfig files. The path is convention, the files must end on .tsconfig.

    User TSconfig, see chapter :ref:`'user TSconfig' in the TSconfig Reference
    <t3tsref:UserTSconfig>`. Files should have the file extension
    :file:`.tsconfig`.
