..  include:: /Includes.rst.txt
..  index:: Crowdin; FAQ
..  _crowdin-faq:

================================
Frequently asked questions (FAQ)
================================

..  contents::
    :local:
    :depth: 2

..  note::
    If you miss a question, please share it in the Slack channel
    `#typo3-localization-team <https://typo3.slack.com/app_redirect?channel=CR75200FL>`__.


General questions
=================

.. _crowdin-faq-extension-missing:

My favorite extension is not available on Crowdin
-------------------------------------------------
If you miss an extension on Crowdin, contact the extension owner to create a
project on Crowdin.

It is important that they follow the description on the page
:ref:`Extension integration <crowdin-extension-integration>`.
The setup is a simple process and done within minutes.


..  _crowdin-faq-extension-language-missing:

My favorite language is not available for an extension
------------------------------------------------------

If you are missing the support for a specific language in an extension on
Crowdin please contact either the maintainer of the extension or the
`Localization Team`_.

..  seealso::
    The language needs to be supported by TYPO3 itself as well, see
    :ref:`i18n_languages` for a list of all languages.

..  _Localization Team: https://typo3.org/community/teams/localization


..  _crowdin-faq-pootle:

Will the old translation server be disabled?
--------------------------------------------

The old translation server under :samp:`https://translation.typo3.org/` has been
turned off in July 2023.

The existing and exported translations which are downloaded within the Install
Tool will be available for longer time.


..  _crowdin-faq-language-xlf-format:

How to convert to the new language XLIFF file format
----------------------------------------------------

If you have :ref:`downloaded an XLIFF file <migrate-from-pootle>` from the
deactivated Pootle language server or an old version of an extension, then it
does not have the correct format. You need to remove some attributes. And you
need to add the :xml:`resname` attribute. For this you can use a Linux tool or a
sophisticated editor to copy the :xml:`id` attribute into the :xml:`resname` of
the :ref:`XLIFF <xliff>` file based on regular expressions.

In most editors you can use regular expressions, for example, in PhpStorm:

#.  Open the XLIFF file in the editor.
#.  Press :kbd:`Ctrl` + :kbd:`R` to open the search and replace pane
#.  Find: `id="(.+?)"` / Replace: `id="$1" resname="$1"`
#.  Click the regex icon (:guilabel:`.*`) to enable regular expressions.
#.  Click on button :guilabel:`Replace All`


Questions about extension integration
=====================================

.. _crowdin-faq-duplicated-labels:

Why does Crowdin show me translations in source language?
---------------------------------------------------------

If you have just set up Crowdin and ship translated XLIFF files in your
extension, they will also show up as files to be translated.

You need to exclude them in your :file:`.crowdin.yml` configuration, which is
located in the extension root directory.

..  code-block:: yaml
    :caption: EXT:my_extension/.crowdin.yml

    files:
      - source: /Resources/Private/Language/
        translation: /Resources/Private/Language/%two_letters_code%.%original_file_name%
        ignore:
          - /Resources/Private/Language/de.*

..  attention::
    You should remove the translations from your extension as those will be
    provided by the translation server.

..  seealso::
    `Crowdin configuration file <https://support.crowdin.com/configuration-file/>`__


..  index:: Crowdin; Upload XLIFF files
..  _crowdin-faq-upload-xliff-files:

Can I upload translated XLIFF files?
------------------------------------

Yes, you can! Switch to the settings area of your project (you need to have the
proper permissions for that) and you can upload XLIFF files or even ZIP files
containing the XLIFF files.

..  figure:: /Images/ExternalImages/Crowdin/Upload.png
    :alt: Upload translations
    :class: with-shadow

    Upload translations

After triggering the upload, Crowdin tries to find the matching source files and
target languages. You may have to accept both if they are not found
automatically.

..  index:: Crowdin; Disable pushing of changes
..  _crowdin-faq-disable-push-changes:

How can I disable the pushing of changes?
-----------------------------------------

By default, Crowdin pushes changes made in translations back to the
repository. This is not necessary, as the translation server provided by TYPO3
handles the distribution of translations, so your extension does not need to
ship the translations.

You can disable the pushing of changes back into your repository in the
Crowdin configuration. Navigate in your Crowdin project to
:guilabel:`Integrations` and select your integration (for example, GitHub). Then
click on the :guilabel:`Edit` button and disable the :guilabel:`Push Sources`
checkbox.


..  index:: Crowdin; Migration from Pootle
..  _migrate-from-pootle:

How can I migrate translations from Pootle?
-------------------------------------------

If there were already translations on the old, discontinues translation server
powered by Pootle, you do not need to translate everything again on Crowdin -
you can import them.

#.  **Fetch translations:**
    Download the translations you need. You will need to download them directly
    from the :abbr:`TER (TYPO3 Extension Repository)` with the following URL
    pattern:

    :samp:`https://extensions.typo3.org/fileadmin/ter/<e>/<x>/<extension_key>-l10n/<extension_key>-l10n-<lang>.zip`

    `<extension_key>`
        The full extension key.

    `<e>`
        The first letter of that extension key.

    `<x>`
        The second letter of that extension key.

    `<lang>`
        The `ISO 639-1 code`_ of the language, for example, `de` for German.

    For example, to download the German translations of the *news* extension:

    ..  code-block:: bash

        wget https://extensions.typo3.org/fileadmin/l10n/n/e/news-l10n/news-l10n-de.zip

    ..  _ISO 639-1 code: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes


#.  **Open and Cleanup:**
    Unzip the translations and switch to, for example,
    :file:`Resources/Private/Language/` which is the typical directory
    of translations. Remove the :file:`.xml` files as only the :file:`.xlf`
    files are important.

#.  **Match the files**
    The attribute :xml:`original` of the translations must match the ones of the
    default translations.

    **Example**: The file :file:`Resources/Private/Language/locallang.xlf`
    starts with the following snippet:

    ..  code-block:: xml

        <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
            <xliff version="1.0">
                <file source-language="en" datatype="plaintext" original="EXT:news/Resources/Private/Language/locallang.xlf">

    The file :file:`de.locallang.xlf` must be modified and
    :xml:`original="messages"` must be changed to
    :xml:`original="EXT:news/Resources/Private/Language/locallang.xlf"`

#.  **Upload the Translations**
    Have a look at :ref:`crowdin-faq-upload-xliff-files`.


crowdin.yml, .crowdin.yml or crowdin.yaml?
------------------------------------------

All three filenames are valid names for for Crowdin CLI to detect the configuration file.
We recommend using `.crowdin.yml` to make it more obvious that it's a configuration file.

Questions about TYPO3 Core integration
======================================

The Core Team added a new system extension. Why are language packs not available even though it has already been translated into language XY?
---------------------------------------------------------------------------------------------------------------------------------------------

The new system extension needs to be added to the configuration of
https://github.com/TYPO3/crowdin-bridge/. You can speed up the change by
creating a pull request like this one:
https://github.com/TYPO3/crowdin-bridge/pull/6/commits.
