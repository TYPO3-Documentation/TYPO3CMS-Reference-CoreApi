..  include:: /Includes.rst.txt
..  index:: Backend modules; DocHeaderComponent
..  _DocHeaderComponent:

==================
DocHeaderComponent
==================

The :php:`\TYPO3\CMS\Backend\Template\Components\DocHeaderComponent` can be
used to display a standardized header section in a backend module with buttons,
menus etc. It can also be used to hide the header section in case it is
not desired to display it.

..  figure:: /Images/ManualScreenshots/Backend/DocHeaderComponent.png
    :class: with-shadow

    The module header displayed by the DocHeaderComponent

You can get the :php:`DocHeaderComponent` with
:php:method:`\TYPO3\CMS\Backend\Template\ModuleTemplate::getDocHeaderComponent`
from your module template.

..  contents:: Table of contents

..  _DocHeaderComponent-api:

DocHeaderComponent API
======================

It has the following methods:

..  include:: _DocHeaderComponent.rst.txt

..  _DocHeaderComponent-example:

Example: Build a module header with buttons and a menu
=======================================================

..  include:: _AboutBlogExample.rst.txt

We use the DocHeaderComponent to register buttons and a menu to the module
header.

..  include:: _ModifyDocHeaderComponent.rst.txt
