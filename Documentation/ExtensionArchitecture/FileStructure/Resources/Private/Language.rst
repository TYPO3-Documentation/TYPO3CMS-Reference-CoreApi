.. include:: /Includes.rst.txt
.. index::
   Folder; Resources/Private/Language
   Resources; Language
   Resources; XLF
   Resources; locallang
.. _extension-Resources-Private-Language:

================
:file:`Language`
================

Contains Language resources.

..  seealso::

    *   Read more about localizing extensions: :ref:`extension_localization`
    *   Read more about the XLIFF format in the following chapter:
        :ref:`xliff`.
    *   Read more about applying localised labels in the following chapter:
        :ref:`xliff_api`.

In the folder :file:`EXT:my_extension/Resources/Private/Languages/` language
files are stored in format :file:`.xlf`.

This folder contains all language labels supplied by the extension in the
default language English.

If the extension should provide additional translations into
custom languages, they can be stored in language files of the same name with a
language prefix. The German translation of the file :file:`locallang.xlf`
must be stored in the same folder in a file called :file:`de.locallang.xlf`,
the French translation in :file:`fr.locallang.xlf`. If the translations are
stored in a different file name they will not be found.

Any arbitrary file name with ending :file:`.xlf` can be used.
The following file names are commonly used:

..  typo3:file:: locallang.xlf
    :scope: extension
    :path: /Resources/Private/Language/
    :regex: /^.*\/Resources\/Private\/Language\/.*locallang\.xlf$/
    :shortDescription: This file commonly contains translated labels to be used in the frontend.

    This file commonly contains translated labels to be used in the frontend.

    In the templates of Extbase plugins all labels in the file
    :file:`EXT:my_extension/Resources/Private/Language/locallang.xlf` can
    be accessed without using the complete path:

    ..  code-block:: html
        :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.html

        <f:translate key="key1" extensionName="MyExtension"/>

    From other template contexts the labels can be used by using the complete
    :html:`LLL:EXT` path:

    ..  code-block:: html
        :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.html

        <f:translate key="LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:key1" />

    The documentation for the ViewHelper can be found at
    :ref:`t3viewhelper:typo3-fluid-translate`.

    Language labels to be used in PHP, TypoScript etc. must also be prefixed with
    the complete path.

..  typo3:file:: locallang_db.xlf
    :scope: extension
    :path: /Resources/Private/Language/
    :regex: /^.*\/Resources\/Private\/Language\/.*locallang\.xlf$/
    :shortDescription: contains all localized labels used for the TCA labels, descriptions etc. by convention

    By convention, this file should contain
    all localized labels used for the TCA labels, descriptions etc.

    These labels need to be always accessed by their complete path in the TCA
    configuration:

    ..  code-block:: php
        :caption: EXT:examples/Configuration/TCA/tx_examples_dummy.php

        return [
           'ctrl' => [
               'title' => 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tx_examples_dummy',
               // ...
           ],
           // ...
        ];
