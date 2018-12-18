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

The TYPO3 core ships three icon providers which can be used:

* :php:`BitmapIconProvider` – For all kinds of bitmap icons (GIF, PNG, JPEG, etc.)
* :php:`SvgIconProvider` – For SVG icons
* :php:`FontawesomeIconProvider` – For all icons which can be found in the fontawesome.io icon font

In case you need a custom icon provider, you can add your own by writing a
class which implements the :php:`IconProviderInterface`.

.. _icon-usage:

Use Icons in Your Code
======================

You can use the Icon API to receive icons in your PHP
code or directly in Fluid.

The PHP Way
-----------

You can use the :php:`IconFactory` to request an icon:

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

You can also use the Fluid ViewHelper to render an icon in your view:

.. code-block:: html

   {namespace core = TYPO3\CMS\Core\ViewHelpers}
   <core:icon identifier="my-icon-identifier" size="small" overlay="overlay-identifier" />

.. _available-icons:

Available Icons
===============

The TYPO3 Core comes with a number of icons that may be used in your extensions.

To search for available icons, you can use one of these possibilities:

Install Styleguide Extension
----------------------------

Install the extension *styleguide* as described in the Readme in the `installation
<https://github.com/TYPO3/styleguide#installation>`__ section.

Once, installed, you can view available icons by selecting help (?) on the top in the
TYPO3 Backend, then *Styleguide* and then *Icons*, *All Icons*.

There, browse through existing icons. Use the name under the icon (for example
:code:`actions-add`) as first parameter for :php:`IconFactory::getIcon()` in PHP or as value for
the argument :code:`identifier` in Fluid (see code examples above).


.. image:: Images/styleguide.png
   :class: with-shadow

Use TYPO3.Icons
---------------

An alternative way to look for existing icons is to browse through https://typo3.github.io/TYPO3.Icons/.
