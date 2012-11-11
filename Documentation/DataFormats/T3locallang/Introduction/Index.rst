.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Introduction
^^^^^^^^^^^^

This XML format is used for "locallang-XML" (llXML) files, a format
TYPO3 uses for storage of interface labels and translations of them.
The format is parsed by t3lib\_div::xml2array() which means that tag-
names and "index" attribute values are inter-related in significance.
The content is always in utf-8.

llXML files must be used from inside extension directories
(system/global/local).

See `"Inside TYPO3" for more details about locallang-files
<#%22locallang%22%20files%7Coutline>`_ and the application of this
format.

llXML files from installed extensions are translated by a backend tool
(extension "llxmltranslate").

A "locallang-XML" file contains a set of labels in the default
language (must always English!). The translated labels are located in
systematically named external files in typo3conf/l10n/[language key]/.
Optionally the main files can contain the translations directly but
that should only be used in special cases since it constrains the
translation process too much. It is also possible with a specific file
reference to use other external files than the automated ones.


