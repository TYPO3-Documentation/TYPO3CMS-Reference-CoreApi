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

In the folder :file:`EXT:my_extension/Resources/Private/Language/` language
files are stored in the format :file:`.xlf`.

..  versionchanged:: 14.0
    TYPO3 v14 and newer support both **XLIFF 1.2** and **XLIFF 2.x** files.
    The loader automatically detects which version is used.

..  note::
    If your extension still supports TYPO3 v13 LTS, continue using
    **XLIFF 1.2**. TYPO3 v13 does not support XLIFF 2.x.
    Before switching to 2.x, verify that all translation tools and services
    used by your team (for example, Crowdin or offline editors) are compatible
    with the newer format.

This folder contains all language labels supplied by the extension in the
default language English.

If the extension provides additional translations into
other languages, store them in language files of the same name with a
language prefix. For example, the German translation of
:file:`locallang.xlf` must be stored in the same folder as
:file:`de.locallang.xlf`, and the French translation as
:file:`fr.locallang.xlf`. If the translations are stored under a different
filename, they will not be found.

Any arbitrary filename ending with :file:`.xlf` can be used.

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
