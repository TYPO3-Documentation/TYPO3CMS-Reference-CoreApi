.. include:: /Includes.rst.txt

.. index::
   Extension development; Create an extension
.. _extension-builder:

.. _extension-create-new:

========================
Creating a new extension
========================

First choose a unique `Composer name <https://getcomposer.org/doc/04-schema.md#name>`__
for your extension. Additionally, an extension key is required.

If you plan to ever publish your extension in the TYPO3 Extension Repository
(TER), :ref:`register an extension key <extension-key>`.

Kickstarting the extension
==========================

There are different options to kickstart an extension. You can create it from
scratch or follow one of our :ref:`tutorials on kickstarting an
extension <extension-kickstart>`.

Installing the newly created extension
=======================================

Starting with TYPO3 v11 it is no longer possible to install extensions in TYPO3
without using Composer in Composer-based installations.

However during development it is likely that you will want to test your extension locally
before publishing it.

During development, place the extension in a directory called,
:file:`packages` in TYPO3s root directory. You can name is directory
however you choose.

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

    composer req vendor/my-extension:"@dev"

..  hint::
    Starting with TYPO3 v11.5 all extensions installed via Composer are
    automatically activated when they are installed. If you use an older
    version of TYPO3 you will have to
    activate the extension in :guilabel:`Admin Tools > Extension Manager`.

For legacy installations you can put the extension directly in the directory
:file:`typo3conf/ext` and then **activate** it in
:guilabel:`Admin Tools > Extension Manager`.
