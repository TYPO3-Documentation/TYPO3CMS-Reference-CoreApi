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

By default, if you click on a module that has third-level modules, the first
third-level module is opened. Setting the `showSubmoduleOverview` module option
to `true` will display an overview instead, as can be seen in the
:guilabel:`Content > Status` module. Third-level modules that the current
user has access to are shown as cards with an
icon, a title, adescription, and a button to open the module. If the user does
not have permission to access any modules, a message will be displayed instead.

The following example registers a *Conference* module which has *Talks* and
*Speakers* third-level modules. The text on the cards is set in the
`description` `labels`:

..  literalinclude:: _ModuleConfiguration/_SubmoduleOverview.php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php
    :emphasize-lines: 28, 43
