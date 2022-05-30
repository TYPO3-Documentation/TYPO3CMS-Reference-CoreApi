.. include:: /Includes.rst.txt


.. _extension-create-new:

========================
Creating a new extension
========================

This chapter is not a tutorial about how to create an Extension.
It only aims to be a list of steps to perform and key information
to remember.

First you have to :ref:`register an extension key <extension-key>`.
This is the unique identifier for your extension.

.. index::
   Extension development; Builder
   Extension development; Kickstarter
.. _extension-builder:

Kickstarting the extension
==========================

Although it is possible to write every single line of an extension from
scratch, there is a tool which makes it easier to start: The
`Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_.

The Extension Builder comes with its own BE module and helps you to create the
scaffolding of your extension and to generate all necessary PHP files.
Then you can enhance these files with your own code.

After the extension has been written to the folder :file:`typo3conf/ext`,
you will be able to activate it locally and start using it.

With composer based extensions it is recommended that you to put the extension in a folder called
:file:`local_packages` in TYPO3s root directory, on the same level as the
:file:`vendor` directory. Only in legacy installations you can put it directly in the
:file:`typo3conf/ext` folder and symlink it there.

You can refer to the
`Extension Builder's manual <https://docs.typo3.org/p/friendsoftypo3/extension-builder/main/en-us/>`__
for more information.

Installing the newly created extension
=======================================

Starting with TYPO3 11 it is no longer possible to install extensions in TYPO3
without using Composer in Composer-based installations.

However during development it is likely that you will want to test your extension locally
before publishing it.

During development, place the extension in a directory called,
:file:`local_packages` in TYPO3s root directory. You can name is directory
however you choose.

Then edit your projects :file:`composer.json` (The one in the TYPO3 root
directory, **not the one in the extension**) and add the following repository:

.. code-block:: json
   :caption: composer.json

   {
      "repositories": [
         {
            "type": "path",
            "url": "local_packages/*"
         }
      ]
   }

After that you can install your extension via Composer:

.. code-block:: bash

   composer req vendor/my-extension:"@dev"

.. hint::
   Starting with TYPO3 11.5 all extensions installed via Composer are
   automatically activated when they are installed. If you use an older version of TYPO3 you will have to
   activate the extension in :guilabel:`Admin Tools > Extension Manager`.

For legacy installations you can put the extension directly in the directory
:file:`typo3conf/ext` and then **activate** it in
:guilabel:`Admin Tools > Extension Manager`.
