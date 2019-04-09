.. include:: ../../../Includes.txt


.. _storing-changes:

===================
Storing the changes
===================

There are various ways to store changes to :php:`$GLOBALS['TCA']`. They
depend - partly - on what you are trying to achieve and - a lot -
on the version of TYPO3 CMS which you are targeting.

There are two main ways to store your changes to the TCA: inside an extension
or straight in the :file:`typo3conf` folder. Both are described below in
more details.


.. _storing-changes-extension:

Storing in extensions
=====================

The advantage of putting your changes inside an extension is that they
are nicely packaged in a self-contained entity which can be easily
deployed on multiple servers.

The drawback is that the extension loading order must be
finely controlled. Indeed if your extension modifies another extension,
your extension must be loaded *after* the extension you are modifying.
This can be achieved by registering that other extension as
a dependency of yours. See the
:ref:`description of constraints in Core APIs <extension-declaration>`.

For more information about an extension's structure, please refer to the
:ref:`extension architecture <extension-architecture>` chapter in
Core APIs.


.. _storing-changes-extension-overrides:

Storing in the Overrides folder
-------------------------------

Since TYPO3 CMS 6.2 (6.2.1 to be precise) changes to :php:`$GLOBALS['TCA']`
must be stored inside a folder called :file:`Configuration/TCA/Overrides`
with one file per modified table. These files are named along the pattern
:file:`<tablename>.php`.

Thus if you want to customize the TCA of :code:`tx_foo_domain_model_bar`,
you'd create the file :file:`Configuration/TCA/Overrides/tx_foo_domain_model_bar.php`.

The advantage of this method is that all such changes are incorporated into
:php:`$GLOBALS['TCA']` **before** it is cached. This is thus far more efficient.

.. important::

   Be aware that you cannot extend the TCA of extensions if it was configured within
   its :file:`ext_tables.php` file, usually containing the "ctrl" section
   referencing a "dynamicConfigFile". Please ask the extension author to switch
   to the :file:`Configuration/TCA/<tablename>.php` setup.

.. important::

   Only TCA-related changes should go into :file:`Configuration/TCA/Overrides`
   files. Some API calls may be okay as long as they also manipulate only
   :php:`$GLOBALS['TCA']`. For example, it is fine to register a plugin with
   :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin()` in
   :file:`Configuration/TCA/Overrides/tt_content.php` because that API call only
   modifies :php:`$GLOBALS['TCA']` for table "tt\_content".


.. _storing-changes-extension-exttables:

Storing in ext_tables.php files
-------------------------------

Until TYPO3 CMS 6.1 (still supported for 6.2) changes to :php:`$GLOBALS['TCA']` are packaged
into an extension's :file:`ext_tables.php` file. This is strongly discouraged in more recent
versions of TYPO3 CMS.

Nowadays the only usecase for TCA changes in :file:`ext_tables.php` is to override TCA definitions
done in the :file:`ext_tables.php` of a legacy extension. TCA overrides cannot be used in this case
until the author of the legacy extension migrates his code.


.. _storing-changes-on-the-fly:

Changing the TCA "on the fly"
=============================

It is also possible to perform some special manipulations on
:php:`$GLOBALS['TCA']` right before it is stored into cache, thanks to the
:code:`tcaIsBeingBuilt` signal. This signal was introduced in
TYPO3 CMS 6.2.1.
