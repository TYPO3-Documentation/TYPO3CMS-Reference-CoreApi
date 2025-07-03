:navigation-title: From Scratch

..  include:: /Includes.rst.txt
..  _extension-create-new:

=====================================
Creating a new extension from scratch
=====================================

First choose a unique `Composer name <https://getcomposer.org/doc/04-schema.md#name>`__
and an extension key for your extension.

If you plan to publish your extension in the TYPO3 Extension Repository
(TER), :ref:`register an extension key <extension-key>`.

..  seealso::

    There are different ways to kickstart an extension.
    See `Extension kickstarters <https://docs.typo3.org/permalink/t3coreapi:extension-kickstart>`_.

*   Create a directory with the extension name
*   Create the :ref:`files-composer-json` file
*   Create the :ref:`ext_emconf-php` file for Classic mode installations and
    extensions what will be uploaded to TER

Installing the newly created extension
=======================================

Since TYPO3 v11 extensions can only be installed
using Composer as part of a Composer-based installation.

However, during development you should test your extension locally
before publishing it. Create the extension directory in the
:file:`packages` directory inside the TYPO3 project root directory.

Then edit your project's :file:`composer.json <extension-composer-json>` (The one in the TYPO3 root
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

After that install your extension via Composer:

..  code-block:: bash

    composer req my-vendor/my-extension:"@dev"

..  hint::
    In Classic mode installations put the extension in the
    :file:`typo3conf/ext` directory and then **activate** it in
    :guilabel:`Admin Tools > Extensions`.
