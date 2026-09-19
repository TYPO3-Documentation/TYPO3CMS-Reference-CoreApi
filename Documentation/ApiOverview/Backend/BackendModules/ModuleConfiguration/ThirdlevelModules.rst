:navigation-title: 3rd level

..  include:: /Includes.rst.txt
..  index::
    Backend modules; Thirdlevel
    Backend modules; Module functions

..  _backend-modules-third-level-module:

======================================
Third-level modules / module functions
======================================

Third-level modules are registered in the
extension's :file:`Configuration/Backend/Modules.php` file, the
same way as :ref:`top-level <backend-modules-toplevel-module>`
and common :ref:`modules <backend-modules-configuration>`.

This allows administrators to define access permissions via the module
access logic for those modules individually. It also allows to influence the
position of the third-level module.

..  _backend-modules-third-level-module-example:

Example
=======

Registration of an additional third-level module for the
:guilabel:`Content > Status` module in the :file:`Configuration/Backend/Modules.php`
file of an extension:

..  literalinclude:: _ModuleConfiguration/_ThirdlevelModule.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

..  _backend-modules-third-level-module-overview:

Showing third-level backend modules as cards
============================================

..  versionadded:: 14.0
    See `Feature: #107712 - Introduce card-based sub module overview
    <https://docs.typo3.org/permalink/changelog:feature-107712-1760548718>`_.

By default, a click on a module with third-level modules opens the first of
them. Set the option `showSubmoduleOverview` of the module to `true` to show
an overview instead, as the :guilabel:`Content > Status` module does. Each
third-level module the current user has access to is shown as a card with its
icon, title and description, and a button to open it. If the user has access
to none of them, a message is shown instead of the cards.

The following example registers a *Conference* module with the third-level
modules *Talks* and *Speakers*. The `description` in their `labels` is the
text shown on the cards:

..  literalinclude:: _ModuleConfiguration/_SubmoduleOverview.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php
