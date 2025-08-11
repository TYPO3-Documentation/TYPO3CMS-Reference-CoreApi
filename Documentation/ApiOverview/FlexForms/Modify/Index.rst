:navigation-title: Modify

..  include:: /Includes.rst.txt
..  _modify-flexforms:

======================
Modify FlexForm fields
======================

FlexForms can be used to store data within an XML structure inside a single DB
column.

..  contents::

..  _modify-flexforms-php:

How to modify FlexForms from PHP
================================

Sometimes it is necessary to modify FlexForms via PHP.

In order to convert a FlexForm to a PHP array while preserving the structure,
use the :php:`xml2array` method in :php:`GeneralUtility` to read
the FlexForm data, then :php:`FlexFormTools` to write back the
changes.

..  versionchanged:: 13.0
    :php:`\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools` is now a stateless
    service and can be injected via :ref:`DependencyInjection`.
    :php:`FlexFormTools::flexArray2Xml()` is now marked as internal.

..  literalinclude:: _FlexformModificationService.php
    :caption: EXT:my_extension/Classes/Service/FlexformModificationService.php

..  note::
    The method FlexFormTools::flexArray2Xml() is marked as internal and subject
    to unannounced changes. Use at your own risk.
