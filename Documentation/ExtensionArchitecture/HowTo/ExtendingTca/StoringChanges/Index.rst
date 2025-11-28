..  include:: /Includes.rst.txt


..  _storing-changes:

=====================
Storing modifications
=====================

There are various ways to store modifications to :php:`$GLOBALS['TCA']`. They
depend on what you are trying to achieve and the version of TYPO3 CMS you are
targeting. The TCA can only be modified from inside an extension.

.. versionchanged:: 14.0
	There are two changes to :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin()`.
	The second argument :php:`$type` and the third argument :php:`$extensionKey`
	have been dropped.

..  _storing-changes-extension:

Storing in extensions
=====================

The advantage of putting modifications inside extensions is that the modifications
are packaged in a self-contained entity that can be easily deployed.

The drawback is that extension loading order must be finely controlled.
**If you are modifying Core TCA, you usually don't have to worry about
loading order**. Custom extensions are always loaded *after* the Core TCA, so
modifications from custom extensions should always take effect.

If your extension modifies another extension, make
sure your extension is loaded *after* the extension you are modifying. You can
do this by registering the other extension as a dependency (or suggestion)
of yours. See the :ref:`description of constraints in Core APIs <extension-declaration>`.

Loading order also matters if you have multiple extensions overriding the
same field or contradicting each other.

Files in :file:`Configuration/TCA/` are loaded inside a dedicated scope. This means
that variables defined in those files cannot leak into other files.

For more information about extension structure, please refer to the
:ref:`extension architecture <extension-architecture>` chapter.

..  index::
    TCA; Overrides folder
    Extension development; TCA overrides folder
    Path; EXT:{extkey}/Configuration/TCA/Overrides
..  _storing-changes-extension-overrides:

Storing in the :file:`Overrides/` folder
----------------------------------------

Modifications to :php:`$GLOBALS['TCA']`
must be stored in :file:`Configuration/TCA/Overrides/`. For clarity, files should
be named :file:`<tablename>.php`.

For example, if you want to modify the TCA of :sql:`tx_foo_domain_model_bar`,
create file :file:`Configuration/TCA/Overrides/tx_foo_domain_model_bar.php`.

The advantage of this method is that changes will be incorporated into
:php:`$GLOBALS['TCA']` **before** it is cached (which is very efficient).

..  note::
    All files in :file:`Configuration/TCA/Overrides/` will be loaded, so you can
    divide up long files such as for table "tt\_content" rather than
    having one long file. Otherwise, if you have custom
    content elements this file can reach 1000+ lines very quickly, affecting
    maintainability.

    Also, names don't matter in this folder, at least not to TYPO3. They only influence
    loading order. Proper naming is only relevant for the table definitions one
    folder up in :file:`Configuration/TCA/`

..  attention::
    You cannot extend the TCA of an extension if the modifications
    are in its :file:`ext_tables.php` file (usually a "ctrl" section
    referencing a "dynamicConfigFile"). Please ask the extension author to switch
    to the :file:`Configuration/TCA/<tablename>.php` setup.

..  attention::
    Only TCA-related modifications should go in :file:`Configuration/TCA/Overrides`
    files. Some API calls may be okay if all they do is manipulate
    :php:`$GLOBALS['TCA']`. For example, a plugin can be registered with
    :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin()` in
    :file:`Configuration/TCA/Overrides/tt_content.php` because the API call only
    modifies :php:`$GLOBALS['TCA']` for table :sql:`tt_content`.

..  index::triple:PSR-14 event; TCA; AfterTcaCompilationEvent;
..  _storing-changes-on-the-fly:

Changing the TCA "on the fly"
=============================

It is possible to manipulate
:php:`$GLOBALS['TCA']` just before it is stored in the cache. Use the
:ref:`PSR-14 event <EventDispatcher>` :ref:`AfterTcaCompilationEvent <AfterTcaCompilationEvent>`.
