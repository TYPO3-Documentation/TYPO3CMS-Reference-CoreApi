.. include:: ../../../../Includes.txt


.. _crowdin-faq:

================================
Frequently Asked Questions (FAQ)
================================

.. only:: html

.. contents::
        :local:
        :depth: 2

.. note::

   If you miss a question, please share it in the slack channel `cig-crowdin-localization`.

General Questions
=================

.. _crowdin-faq-pootle:

Will the old Translation Server be Disabled?
--------------------------------------------
The existing translation server will be turned off some time after Crowdin has been announced stable.

The existing and exported translations which are downloaded within the Install Tool will be available for longer time.

.. _crowdin-faq-support-87:

Will TYPO3 8.7 Be Supported?
----------------------------
Short answer: **No**!
Long answer: A lot of work has been done for version 9.5 by moving translations to proper places. TYPO3 8.7 will be end of life in April 2020 and you should really upgrade to 9 or 10 - not only because of better translations!

.. _crowdin-faq-extension-missing:

My Favorite Extension Is not Available on Crowdin
-------------------------------------------------
If you miss an extension on Crowdin, contact the extension owner to create a project on Crowdin.
It is a simple process and done within minutes.

.. _crowdin-faq-extension-language-missing:

My Favorite Language Is not Available for an Extension
------------------------------------------------------
If you are missing the support for a specific language in an extension on Crowdin please contact either the maintainer
of the extension or the :ref:`crowdin-initiative`.

.. seealso::

   The language needs to be supported by TYPO3 itself as well, see :ref:`i18n_languages` for a list of all languages.

Questions About Extension Integration
=====================================

.. _crowdin-faq-duplicated-labels:

Why does Crowdin show me translations in source language?
---------------------------------------------------------
If you just have setup Crowdin and you ship translated xlf files within your extension, those will be shown as well as to be translated.

You need to exlude those in your `.crowdin.yaml` configuration which can be found in the extension root directory.

.. code-block:: yaml

    files:
      - source: /Resources/Private/Language/
        translation: /%original_path%/%two_letters_code%.%original_file_name%
        ignore:
          - /Resources/Private/Language/de.*

.. important::

   In the long run, you should remove the translations from your extension as those will be provided by the translation server.

More information can be found in the documtation on crowdin: https://support.crowdin.com/configuration-file/

Can I upload Translated xlf Files?
----------------------------------
Yes, you can! Switch to the settings area of your project (you need to have the proper permissions for that) and you can upload xlf files or even zip files containg the xlf files.

.. figure:: /Images/I18n/Crowdin/crowdin-upload.png
   :alt: Upload translations
   :width: 600px

   Upload translations

After triggering the upload Crowdin tries to find the matching source files and the target languages.
It might be that you need to adopt both if not found automatically.
