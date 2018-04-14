.. include:: ../../Includes.txt


.. _icon:

========
Icon API
========

Since version 7.5 TYPO3 CMS provides an Icon API for all icons in the TYPO3 backend.


.. _icon-registration:

Registration
============

All icons must be registered in the :php:`IconRegistry`.
To register icons for your own extension use the following
code in your :php:`ext_tables.php` file:

.. code-block:: php

   $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Core\Imaging\IconRegistry::class
   );
   $iconRegistry->registerIcon(
      $identifier, // Icon-Identifier, z.B. tx-myext-action-preview
      \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
      ['source' => 'EXT:myext/Resources/Public/Icons/action-preview.svg']
   );


IconProvider
------------

The TYPO3 core ships three IconProvider which can be used:

* :php:`BitmapIconProvider` – For all kind of bitmap icons (format like: gif, png, jpeg, etc)
* :php:`SvgIconProvider` – For all SVG icons
* :php:`FontawesomeIconProvider` – For all icons which can be found in fontawesome.io

In case you need special IconProvider you can implement your own,
your class has to implement the :php:`IconProviderInterface`.

.. _icon-usage:

Use icons in your code
======================

You can use the Icon API to receive icons with in your PHP
code or directly in fluid.

The PHP way
-----------

Your can use the :php:`IconFactory` to request an icon:

.. code-block:: php

   $iconFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Core\Imaging\IconFactory::class
   );
   $icon = $iconFactory->getIcon(
      'tx-myext-action-preview',
      \TYPO3\CMS\Core\Imaging\Icon::SIZE_SMALL,
      'overlay-identifier'
   );
   $this->view->assign('icon', $icon);


The Fluid ViewHelper
--------------------

You can also simple use the Fluid ViewHelper to render an icon in your view:

.. code-block:: html

   {namespace core = TYPO3\CMS\Core\ViewHelpers}
   <core:icon identifier="my-icon-identifier" size="small" overlay="overlay-identifier" />

