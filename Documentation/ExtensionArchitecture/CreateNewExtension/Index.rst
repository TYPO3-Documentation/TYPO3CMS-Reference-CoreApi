.. include:: ../../Includes.txt


.. _extension-create-new:

Creating a new extension
^^^^^^^^^^^^^^^^^^^^^^^^

This chapter is not a tutorial about how to create an Extension.
It only aims to be a list of steps to perform and key information
to remember.

First you have to :ref:`register an extension key <extension-key>`.
This is the unique identifier for your extension.


Kickstarting the extension
""""""""""""""""""""""""""

Although it is possible to write every single line of an extension from
scratch, there is a tool which makes it easier to start: The
`Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_.

The Extension Builder comes with its own BE module and helps you to create the
scaffolding of your extension and to generate all necessary PHP files.
Then you can enhance these files with your own code.

After the extension has been written to the folder :file:`typo3conf/ext`,
you will be able to activate it locally and start using it.

Please refer to the
`Extension Builder's manual <https://docs.typo3.org/p/friendsoftypo3/extension-builder/7.10/en-us/>`__
for more information.
