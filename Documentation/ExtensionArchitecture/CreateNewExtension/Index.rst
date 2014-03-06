.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-create-new:

Creating a new extension
^^^^^^^^^^^^^^^^^^^^^^^^

This chapter is not a tutorial about how to create an Extension.
It only aims to be a list of steps to perform and key information
to remember.

.. _extension-key-registration:

Registering an extension key
""""""""""""""""""""""""""""

Before starting a new extension you should register an extension key
on typo3.org (unless you plan to make an implementation-specific
extension – of course – which it does not make sense to share).

Go to typo3.org, log in with your (pre-created) username / password
and go to Extensions > Extension Keys and click on the "Register keys"
tab. On that page you can enter the key name you want to register.

.. figure:: ../../Images/Typo3OrgRegistration.png
   :alt: The extension registration form

   The extension registration form on typo3.org.

See :ref:`extension-key`.


Kickstarting the extension
""""""""""""""""""""""""""

Although it is possible to write every single line of an extension from
scratch, there is tool which makes it easier to start. It is called
"Extension builder" (key: "extension_builder") and can be installed from
TER.


The `Extension Builder <http://typo3.org/extensions/repository/view/extension_builder>`_
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

Please refer to the Extension Builder's manual for more information.
