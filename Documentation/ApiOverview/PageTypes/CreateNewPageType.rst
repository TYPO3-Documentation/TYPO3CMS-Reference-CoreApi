..  include:: /Includes.rst.txt
..  index:: Page types; Custom
..  _page-types-example:

====================
Create new Page Type
====================

The following example adds a new page type called "Archive".

..  include:: /Images/AutomaticScreenshots/PageTypes/NewPageType.rst.txt

Changes need to be made in several files to create a new page type. Follow
the directions below to the end:

..  rst-class:: bignums

1.  Add new page type to :php:`PageDoktypeRegistry`

    The new page type has to be added to the
    :php:`\TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry`. TYPO3 uses this
    registry internally to only allow specific tables to be inserted on that
    page type. This registry will not add or modify any TCA. In example below
    all kind of tables (`*`) are allowed to be inserted on the new page type.

    The new page type is added to the :php:`PageDoktypeRegistry` in
    :file:`ext_tables.php`:

    ..  literalinclude:: _ext_tables.php
        :language: php
        :caption: EXT:examples/ext_tables.php

2.  Add an icon chosen for the new page type

    You need to add the icon chosen for the new page type and allow users to
    drag and drop the new page type to the page tree.

    We need to add the following :ref:`user TSconfig <t3tsref:usertsconfig>`
    to all users, so that the new page type is displayed in the wizard:

    ..  literalinclude:: _user.tsconfig
        :language: typoscript
        :caption: EXT:examples/Configuration/user.tsconfig

    The :ref:`icon <icon>` is registered in :file:`Configuration/Icons.php`:

    ..  literalinclude:: _Icons.php
        :language: php
        :caption: EXT:examples/Configuration/Icons.php

    It is possible to define additional type icons for special case pages:

    *   Page contains content from another page `<doktype>-contentFromPid`,
        For example: :php:`$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['116-contentFromPid']`.
    *   Page is hidden in navigation `<doktype>-hideinmenu`
        For example: :php:`$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['116-hideinmenu']`.
    *   Page is the root of the site `<doktype>-root`
        For example: :php:`$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['116-root']`.

    ..  note::

        Make sure to add the additional icons using the :ref:`Icon API <icon>`!

3.  Add new page type to doktype selector

    We need to modify the configuration of page records. As one can modify the
    pages, we need to add the new doktype as a select option and associate it
    with the configured icon. That is done in
    :file:`Configuration/TCA/Overrides/pages.php`:

    ..  literalinclude:: _pages.php
        :language: php
        :caption: EXT:examples/Configuration/TCA/Overrides/pages.php

    As you can see from the example, to make sure you get the correct icons,
    you can utilize :php:`typeicon_classes`.

4.  Define your own columns for new page type

    By default the new page type will render all columns of default
    page type (`DEFAULT (1)`). If you want to chose your own columns you have
    to copy over all columns from default page type:

    ..  literalinclude:: _pagesCopyDefaultPageType.php
        :language: php
        :caption: EXT:examples/Configuration/TCA/Overrides/pages.php

    Now you can modify TCA with Core API like
    :php:`ExtensionManagementUtility::addToAllTCAtypes();`

Further Information
-------------------

*   :doc:`ext_core:Changelog/11.4/Feature-94692-RegisteringIconsViaServiceContainer`

*   :doc:`ext_core:Changelog/12.0/Breaking-98487-GLOBALSPAGES_TYPESRemoved`

*   :doc:`ext_core:Changelog/12.3/Feature-99739-AssociativeArrayKeysForTCAItems`
