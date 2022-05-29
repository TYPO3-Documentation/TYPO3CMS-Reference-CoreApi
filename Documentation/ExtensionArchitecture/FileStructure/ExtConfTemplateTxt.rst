.. include:: /Includes.rst.txt

.. index:: File; EXT:{extkey}/ext_conf_template.txt
.. _ext_conf_template.txt:

=======================================
:file:`ext_conf_template.txt`
=======================================

Extension Configuration template.

Configuration code in TypoScript syntax setting up a series of values
which can be configured for the extension in the Install Tool.
:ref:`Read more about the file format here <extension-options>`.

If this file is present 'Settings' of the Install Tool provides you with an
interface for editing the configuration values defined in the file. The result is
written as an array to :file:`LocalConfiguration.php`
in the variable :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][`:code:`*extension_key*` :php:`]`
