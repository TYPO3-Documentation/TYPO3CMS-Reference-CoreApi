.. include:: /Includes.rst.txt
.. index:: Extension development; File name conventions
.. _extension-files-locations:
.. _extension-reserved-folders-legacy:

==============
File structure
==============

Lists reserved file and directory names within an extension. Also
lists file names that are used in a certain way by convention.

This chapter should also help you to find your way around in
extensions and sitepackages that where automatically generated or
that you downloaded as an example.

.. _extension-files:

Files
=====

An extension consists of:

1. A directory named by the *extension key* (which is a worldwide unique
   identification string for the extension), usually located in :file:`typo3conf/ext`
   for local extensions, or :file:`typo3/sysext` for system extensions.

2. Standard files with reserved names for configuration related to TYPO3
   (of which most are optional, see list below)

3. Any number of additional files for the extension functionality itself.

.. index:: Extension development; Reserved file names
.. _extension-reserved-filenames:

Reserved file names
===================

Most of these files are not required, except of :file:`ext_emconf.php`
in :ref:`legacy installations not based on Composer <t3start:legacyinstallation>`
and :file:`composer.json <extension-composer-json>` in :ref:`Composer installations <t3start:install>`
installations.

.. note::
   It is recommended to keep :file:`ext_emconf.php` and :file:`composer.json <extension-composer-json>` in
   any public extension that is published to TYPO3 Extension Repository (TER), and
   to ensure optimal compatibility with Composer installations and legacy
   installations.

Do not introduce your own files in the root directory of
extensions with the name prefix :file:`ext_`, because that is reserved.

.. _extension-reserved-folders:

Reserved Folders
================

In the early days, every extension author baked his own bread when it came to
file locations of PHP classes, public web resources and templates.

With the rise of Extbase, a generally accepted structure for file
locations inside of extensions has been established. If extension authors
stick to this and the other Coding Guidelines, the system helps in various ways. For instance, if putting
PHP classes into the :file:`Classes/` folder and using appropriate namespaces for the classes,
the system will be able to autoload these files.

Extension kickstarters like the :t3ext:`extension_builder`
will create the correct structure for you.

.. toctree::
   :titlesonly:
   :glob:

   *
   */Index
