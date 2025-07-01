:navigation-title: From the Scratch

..  include:: /Includes.rst.txt
..  _extension-create-new:

=====================================
Creating a new extension from scratch
=====================================

First choose a unique `Composer name <https://getcomposer.org/doc/04-schema.md#name>`__
for your extension. Additionally, an extension key is required.

If you plan to ever publish your extension in the TYPO3 Extension Repository
(TER), :ref:`register an extension key <extension-key>`.

..  seealso::

    There are different options to automatically kickstart an extension.
    See `Extension kickstarters <https://docs.typo3.org/permalink/t3coreapi:extension-kickstart>`_.

*   Create a directory with the extension name
*   Create the :ref:`files-composer-json` file
*   Create the :ref:`ext_emconf-php` file for Classic mode installations and extensions to be uploaded to TER

Installing the newly created extension
=======================================

Starting with TYPO3 v11 it is no longer possible to install extensions in TYPO3
without using Composer in Composer-based installations.

However during development it is necessary to test your extension locally
before publishing it. Place the extension directory into the directory called,
:file:`packages` inside of the TYPO3 project root directory.

Then edit your projects :file:`composer.json <extension-composer-json>` (The one in the TYPO3 root
directory, **not the one in the extension**) and add the following repository:

.. code-block:: json
   :caption: composer.json

   {
      "repositories": [
         {
            "type": "path",
            "url": "packages/*"
         }
      ]
   }

After that you can install your extension via Composer:

..  code-block:: bash

    composer req my-vendor/my-extension:"@dev"

..  hint::
    For Classic mode installations you can put the extension directly in the directory
    :file:`typo3conf/ext` and then **activate** it in
    :guilabel:`Admin Tools > Extensions`.
