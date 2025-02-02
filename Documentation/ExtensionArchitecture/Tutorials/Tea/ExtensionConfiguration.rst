..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Extension configuration
..  _extbase_tutorial_tea_extension_configuration:

===================
Create an extension
===================

For an extension to be installable in TYPO3 it needs a file called
:file:`composer.json <extension-composer-json>`. You can read more about this file here:
:ref:`files-composer-json`.

A minimal :file:`composer.json <extension-composer-json>` to get the extension up and running
could look like this:

..  tabs::

    ..  group-tab:: Composer

        ..  include:: /CodeSnippets/Tutorials/Tea/ComposerJsonSimplified.rst.txt

    ..  group-tab:: Legacy

        ..  include:: /CodeSnippets/Tutorials/Tea/ExtEmconf.rst.txt


..  hint::
    If the extension should also be available for legacy installations it
    also needs a file called :file:`ext_emconf.php`. This file
    contains roughly the same information in a different format. Have a look
    at the tab "Legacy" above.

With just the :file:`composer.json <extension-composer-json>` present (and for legacy installations additionally
:file:`ext_emconf.php`) you would be able to install the extension
but it would not do anything.

Though not required it is considered best practice for an extension to have an
icon. This icon should have the format :file:`.svg` or :file:`.png` and has
to be located at :file:`EXT:tea/Resources/Public/Icons/Extension.svg`.

Install the extension locally
=============================

See :ref:`Extension installation <t3start:install-extension-with-composer>`.
