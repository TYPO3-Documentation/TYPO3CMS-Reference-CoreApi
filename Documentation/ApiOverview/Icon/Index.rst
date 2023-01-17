..  include:: /Includes.rst.txt
..  index::
    Backend; Icon API
    Icon API
..  _icon:

========
Icon API
========

TYPO3 provides an icon API for all icons in the TYPO3 backend.

..  index:: IconRegistry; registerIcon
..  _icon-registration:

Registration
============

All icons must be registered in the icon registry.
To register icons for your own extension, create a file called
:file:`Configuration/Icons.php` in your extension - for example:
:file:`typo3conf/ext/my_extension/Configuration/Icons.php`.

..  note::
    In versions below TYPO3 v11.4 the configuration was done in the
    :file:`ext_localconf.php` file, please use the version selector to look up
    the syntax in the corresponding documentation version.

The file needs to return a PHP configuration array with the following keys:

.. include:: /CodeSnippets/Manual/Extension/Configuration/IconsPhp.rst.txt


.. index:: Icon API; IconProviderInterface

IconProvider
------------

The TYPO3 Core ships three icon providers which can be used:

* :php:`BitmapIconProvider` – For all kinds of bitmap icons (GIF, PNG, JPEG, etc.)
* :php:`SvgIconProvider` – For SVG icons
* :php:`FontawesomeIconProvider` – For all icons which can be found in the fontawesome.io icon font

In case you need a custom icon provider, you can add your own by writing a
class which implements the :php:`IconProviderInterface`.

.. _icon-usage:

Using icons in your code
========================

You can use the Icon API to receive icons in your PHP
code or directly in Fluid.


.. index:: Icon API; IconFactory

The PHP way
-----------

You can use the :php:`IconFactory` to request an icon:

..  literalinclude:: _IconFactoryExample.php
    :caption: EXT:my_extension/Classes/MyClass.php


..  index::
    Fluid; Core icon
    pair: Icon API; Fluid

The Fluid ViewHelper
--------------------

You can also use the :ref:`Fluid core:icon ViewHelper <t3viewhelper:typo3-core-icon>`
to render an icon in your view:

..  code-block:: html

    {namespace core = TYPO3\CMS\Core\ViewHelpers}
    <core:icon identifier="my-icon-identifier" size="small" />

This will render the desired icon using an :html:`img` tag. If you prefer having
the SVG inlined into your HTML (for example, for being able to change colors
with CSS), you can set the optional :html:`alternativeMarkupIdentifier`
attribute to :html:`inline`. By default, the icon will pick up the font color of
its surrounding element if you use this option.

..  code-block:: html

    {namespace core = TYPO3\CMS\Core\ViewHelpers}
    <core:icon
        identifier="my-icon-identifier"
        size="small"
        alternativeMarkupIdentifier="inline"
    />


..  index:: JavaScript; getIcon

The JavaScript way
------------------

In JavaScript, icons can be only fetched from the Icon Registry. To achieve this,
add the following dependency to your RequireJS module: :js:`TYPO3/CMS/Backend/Icons`.
In this section, the module is known as `Icons`.

The module has a single public method :js:`getIcon()` which accepts up to five arguments:

.. rst-class:: dl-parameters

identifier
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Identifier of the icon as registered in the Icon Registry.

size
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Desired size of the icon. All values of the :js:`Icons.sizes` enum are allowed, these are: `small`, `default`, `large` and `overlay`.

overlayIdentifier
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Identifier of an overlay icon as registered in the Icon Registry.

state
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Sets the state of the icon. All values of the :js:`Icons.states` enum are allowed, these are: `default` and `disabled`.

markupIdentifier
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Defines how the markup is returned. All values of the :js:`Icons.markupIdentifiers` enum are allowed, these are: `default` and `inline`. Please note that `inline` is only meaningful for SVG icons.

The method :js:`getIcon()` returns a jQuery Promise object, as internally an Ajax request is done.

The icons are cached in the local storage of the client to reduce the workload off the server.
Here is an example code how a usage of the JavaScript Icon API may look like:

Here's an example code how a usage of the JavaScript Icon API may look like:

.. code-block:: js

   define(['jquery', 'TYPO3/CMS/Backend/Icons'], function($, Icons) {
       // Get a single icon
       Icons.getIcon('spinner-circle-light', Icons.sizes.small).done(function(spinner) {
           console.log(spinner);
       });
   });


.. index:: Icon Api; Available icons
.. _available-icons:

Available icons
===============

The TYPO3 Core comes with a number of icons that may be used in your extensions.

To search for available icons, you can use one of these possibilities:


Install styleguide extension
----------------------------

Install the extension *styleguide* as described in the Readme in the `installation
<https://github.com/TYPO3/styleguide#installation>`__ section.

Once, installed, you can view available icons by selecting help (?) on the top in the
TYPO3 backend, then *Styleguide* and then *Icons*, *All Icons*.

There, browse through existing icons. Use the name under the icon (for example
:code:`actions-add`) as first parameter for :php:`IconFactory::getIcon()` in PHP or as value for
the argument :code:`identifier` in Fluid (see code examples above).


.. include:: /Images/AutomaticScreenshots/Icon/IconProviders.rst.txt

Use TYPO3.Icons
---------------

An alternative way to look for existing icons is to browse through
`TYPO3.Icons <https://typo3.github.io/TYPO3.Icons/>`__.
