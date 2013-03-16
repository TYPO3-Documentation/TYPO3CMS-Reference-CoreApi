.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _locallang:

<T3locallang>
-------------

This XML format is used for "locallang-XML" (llXML) files, a format
TYPO3 uses for storage of interface labels and translations of them.
The format is parsed by :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::xml2array()` which means that tag-
names and "index" attribute values are inter-related in significance.
The content is always in utf-8.

llXML files must be used from inside extension directories
(system/global/local).

See :ref:`Inside TYPO3 <t3inside:start>` for more details about these files
and the application of this format.

llXML files from installed extensions can be translated locally by a backend tool
(extension "llxmltranslate") and remotely on the TYPO3 translation server.

A "locallang-XML" file contains a set of labels in the default
language (must always English!). The translated labels are located in
systematically named external files in :file:`typo3conf/l10n/[language key]/`.
Optionally the main files can contain the translations directly but
that should only be used in special cases since it constrains the
translation process too much. It is also possible with a specific file
reference to use other external files than the automated ones.

.. important::
   Since TYPO3 CMS 4.6, a new format was introduced for managing internationalization.
   The XLIFF format is an open source standard. :ref:`See the related chapter <xliff>`
   for more information about, in particular how to migrate to it and how to ensure
   backwards-compatibility.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Elements/Index


