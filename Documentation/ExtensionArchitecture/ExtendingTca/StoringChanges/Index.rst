.. include:: /Includes.rst.txt


.. _storing-changes:

===================
Storing the Changes
===================

There are various ways to store changes to :php:`$GLOBALS['TCA']`. They
depend - partly - on what you are trying to achieve and - a lot -
on the version of TYPO3 CMS which you are targeting.

There are two main ways to store your changes to the TCA: inside an extension
or straight in the :file:`typo3conf` folder. Both are described below in
more details.


.. _storing-changes-extension:

Storing in Extensions
=====================

The advantage of putting your changes inside an extension is that they
are nicely packaged in a self-contained entity which can be easily
deployed on multiple servers.

The drawback is that the extension loading order must be finely controlled. However, **in
case you are modifying core TCA, you usually don't have to worry about that**. Since
custom extensions are always loaded *after* the core's TCA, changes from custom extensions
will usually take effect without any special measures.

.. important::

   If your extension modifies another extension, you actively need to make sure your
   extension is loaded *after* the extension you are modifying. This can be achieved
   by registering that other extension as a dependency (or suggestion) of yours. See
   the :ref:`description of constraints in Core APIs <extension-declaration>`.

   Loading order also matters if you have multiple extensions overriding the same field,
   probably even contradicting each other.


For more information about an extension's structure, please refer to the
:ref:`extension architecture <extension-architecture>` chapter in
Core APIs.


.. _storing-changes-extension-overrides:

Storing in the Overrides Folder
-------------------------------

Since TYPO3 CMS 6.2 (6.2.1 to be precise) changes to :php:`$GLOBALS['TCA']`
must be stored inside a folder called :file:`Configuration/TCA/Overrides`
with one file per modified table. These files are named along the pattern
:file:`<tablename>.php`.

Thus if you want to customize the TCA of :code:`tx_foo_domain_model_bar`,
you'd create the file :file:`Configuration/TCA/Overrides/tx_foo_domain_model_bar.php`.

The advantage of this method is that all such changes are incorporated into
:php:`$GLOBALS['TCA']` **before** it is cached. This is thus far more efficient.

.. note::

   All files within :file:`Configuration/TCA/Overrides` will be loaded, you are not forced
   to have a single file for table "tt\_content" for instance. When dealing with custom
   content elements this file can get 1000+ lines very quickly and maintainability can get
   hard quickly as well.
   Also names don't matter in that folder, at least not to TYPO3. They only might influence
   loading order. Proper naming is only relevant for the real definition of tables one
   folder up in :file:`Configuration/TCA`

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

Storing in ext_tables.php Files
-------------------------------

Until TYPO3 CMS 6.1 (still supported for 6.2) changes to :php:`$GLOBALS['TCA']` are packaged
into an extension's :file:`ext_tables.php` file. This is strongly discouraged in more recent
versions of TYPO3 CMS.

Nowadays the only usecase for TCA changes in :file:`ext_tables.php` is to override TCA definitions
done in the :file:`ext_tables.php` of a legacy extension. TCA overrides cannot be used in this case
until the author of the legacy extension migrates his code.


.. _storing-changes-on-the-fly:

Changing the TCA "on the Fly"
=============================

It is also possible to perform some special manipulations on
:php:`$GLOBALS['TCA']` right before it is stored into cache, thanks to the
:ref:`PSR-14 event <EventDispatcher>` :ref:`AfterTcaCompilationEvent <AfterTcaCompilationEvent>`.
