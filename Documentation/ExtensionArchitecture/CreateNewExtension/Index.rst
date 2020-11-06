.. include:: /Includes.rst.txt


.. _extension-create-new:

========================
Creating a new Extension
========================

This chapter is not a tutorial about how to create an Extension.
It only aims to be a list of steps to perform and key information
to remember.

First you have to :ref:`register an extension key <extension-key>`.
This is the unique identifier for your extension.

.. _extension-builder:

Kickstarting the Extension
==========================

Although it is possible to write every single line of an extension from
scratch, there is a tool which makes it easier to start. It is called
"Extension builder" (key: "extension_builder") and can be installed from
TER.

.. hint::

   The extension builder in TER is usually not up to date. If you can't
   find a version supporting the latest TYPO3 version in TER, you can
   take a look into the
   `official github repository <https://github.com/FriendsOfTYPO3/extension_builder>`__.

The `Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_
comes with its own BE module:

.. figure:: ../../Images/ExtensionBuilder.png
   :alt: A view from the Extension Builder

   The Domain Modeller screen of the Extension Builder. The comfort of building
   your model with drag and drop.

Note that this tool is not a complete editor. It helps you creating the scaffolding
of your extension, generating the necessary files. It's then up to you to fill these
with the relevant code.

.. warning::
   The Extension Builder has some possibility to
   preserve code, but it should still be used with care.


After the extension is written to your computer's disk you will be able to install
it locally and start using it.

Please refer to the `Extension Builder's manual <https://docs.typo3.org/typo3cms/extensions/extension_builder/>`__ for more information.
