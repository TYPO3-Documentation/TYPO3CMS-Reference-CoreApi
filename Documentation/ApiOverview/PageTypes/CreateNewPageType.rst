..  include:: /Includes.rst.txt
..  index:: Page types; Custom
..  _page-types-example:

====================
Create new Page Type
====================

The following example adds a new page type called "Archive".

..  include:: /Images/AutomaticScreenshots/PageTypes/NewPageType.rst.txt

The whole code to add a page type is shown below with the according file names above.

..  versionchanged:: 12.0
    Starting with 12.0 a new PageDoktypeRegistry was introduced replacing the
    :php:`$GLOBALS['PAGES_TYPES']` array. Use the version selector to look up
    the syntax in the corresponding documentation version.

The first step is to add the new page type to the PageDoktypeRegistry described above. Then you need to add
the icon chosen for the new page type and allow users to drag and drop the new page type to the page
tree.

The new page type is added to the :php:`PageDoktypeRegistry::class` in
:file:`ext_tables.php`:

..  literalinclude:: _ext_tables.php
    :language: php
    :caption: EXT:example/ext_tables.php

We need to add the following user tsconfig
to all users so that the new page type is displayed in the wizard:

..  literalinclude:: _UserConfiguration.tsconfig
    :language: typoscript
    :caption: EXT:example/Configuration/TsConfig/User/UserConfiguration.tsconfig

You can load the file like this:

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:example/ext_localconf.php

The icon is registered in :file:`Configuration/Icons.php`:

..  literalinclude:: _Icons.php
    :language: php
    :caption: EXT:example/Configuration/Icons.php

Furthermore we need to modify the configuration of "pages" records. As one can modify the pages, we
need to add the new doktype as select item and associate it with the configured icon. That's done in
:file:`Configuration/TCA/Overrides/pages.php`:


..  literalinclude:: _pages.php
    :language: php
    :caption: EXT:example/Configuration/TCA/Overrides/pages.php

As you can see from the example, to make sure you get the correct icons, you can utilize :php:`typeicon_classes`.

For the following cases you need to configure icons explicitly, otherwise they will automatically fall back to the
variant for regular page doktypes.

*   Page contains content from another page (`<doktype>-contentFromPid`)
*   Page is hidden in navigation (`<doktype>-hideinmenu`)
*   Page is site-root (`<doktype>-root`)

..  note::

    Make sure to add the additional icons using the icon registry!


Further Information
-------------------

..  rst-class:: compact-list

*   :doc:`ext_core:Changelog/11.4/Feature-94692-RegisteringIconsViaServiceContainer`

*   :doc:`ext_core:Changelog/12.0/Breaking-98487-GLOBALSPAGES_TYPESRemoved`

*   :doc:`ext_core:Changelog/12.3/Feature-99739-AssociativeArrayKeysForTCAItems`
