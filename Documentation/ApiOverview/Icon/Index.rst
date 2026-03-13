..  include:: /Includes.rst.txt
..  index::
    Backend; Icon API
    Icon API
..  _icon:

========
Icon API
========

TYPO3 provides an icon API for all icons in the TYPO3 backend.

..  contents::
    :local:

..  index:: IconRegistry; registerIcon
..  _icon-registration:

Registration
============

All icons must be registered in the icon registry.
To register icons for your own extension, create a file called
:file:`Configuration/Icons.php` in your extension - for example:
:file:`EXT:my_extension/Configuration/Icons.php`.

..  versionchanged:: 14.0
    It is not possible anymore to register icons in the
    :file:`ext_localconf.php` file.

    :ref:`Migrate the icon registration <icon_migration>` to
    new format. There is also a Rector rule.

The file needs to return a PHP configuration array with the following keys:

..  literalinclude:: _Icons.php
    :language: php
    :caption: EXT:my_extension/Configuration/Icons.php

Minimal SVG sprite structure
----------------------------

When registering an icon with the :php:`SvgSpriteIconProvider`, the referenced
SVG file must expose icons via the :html:`<symbol>` element. A minimal SVG sprite
may look like this:

..  literalinclude:: _SvgSpriteMinimal.svg
    :language: xml
    :caption: Minimal SVG sprite example

The fragment identifier (``#tx-myextension``) is used to reference the symbol
from the SVG sprite when registering the icon.

..  index:: Icon API; IconProviderInterface

Icon provider
-------------

The TYPO3 Core ships three icon providers which can be used straight away:

*   :php:`\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider` – For all
    kinds of bitmap icons (GIF, PNG, JPEG, etc.)
*   :php:`\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider` – For SVG icons
*   :php:`\TYPO3\CMS\Core\Imaging\IconProvider\SvgSpriteIconProvider` – For SVG
    icons bundled in an SVG sprite

If you need a custom icon provider, you can add your own by writing a
class which implements the
:t3src:`core/Classes/Imaging/IconProviderInterface.php`.

.. _icon-usage:

Using icons in your code
========================

You can use the Icon API to receive icons in your PHP
code or directly in Fluid.

..  note::
    The icons are cached in the local storage of the client to reduce the workload off the server.
    During development, it might be necessary to clear the local storage in addition to the usual
    TYPO3 caches.


.. index:: Icon API; IconFactory

The PHP way
-----------

You can use the :php:`\TYPO3\CMS\Core\Imaging\IconFactory` to request an icon:

..  literalinclude:: _IconFactoryExample.php
    :caption: EXT:my_extension/Classes/MyClass.php

..  versionchanged:: 13.0

The following icon sizes are available as enum values:

*   :php:`\TYPO3\CMS\Core\Imaging\IconSize::DEFAULT`: 1em, to scale with font
    size
*   :php:`\TYPO3\CMS\Core\Imaging\IconSize::SMALL`: fixed to 16px
*   :php:`\TYPO3\CMS\Core\Imaging\IconSize::MEDIUM`: fixed to 32px
    (used as default value in API parameters)
*   :php:`\TYPO3\CMS\Core\Imaging\IconSize::LARGE`: fixed to 48px
*   :php:`\TYPO3\CMS\Core\Imaging\IconSize::MEGA`: fixed to 64px

..  versionchanged:: 14.0
    The icon size class constants :php:`\TYPO3\CMS\Core\Imaging\Icon::SIZE_*`
    deprecated in v13.0 have been removed. Use the enum values described above.


..  index::
    Fluid; Core icon
    pair: Icon API; Fluid

The Fluid ViewHelper
--------------------

You can also use the :ref:`Fluid core:icon ViewHelper <t3viewhelper:typo3-core-icon>`
to render an icon in your view:

..  code-block:: html

    {namespace core = TYPO3\CMS\Core\ViewHelpers}
    <core:icon identifier="tx-myextension-svgicon" size="small" />

This will render the desired icon using an :html:`img` tag. If you prefer having
the SVG inlined into your HTML (for example, for being able to change colors
with CSS), you can set the optional :html:`alternativeMarkupIdentifier`
attribute to :html:`inline`. By default, the icon will pick up the font color of
its surrounding element if you use this option.

..  code-block:: html

    {namespace core = TYPO3\CMS\Core\ViewHelpers}
    <core:icon
        identifier="tx-myextension-svgicon"
        size="small"
        alternativeMarkupIdentifier="inline"
    />

The following icon sizes are available:

*   :html:`default`: 1em, to scale with font size
*   :html:`small`: fixed to 16px (used as default value when not passed)
*   :html:`medium`: fixed to 32px
*   :html:`large`: fixed to 48px
*   :html:`mega`: fixed to 64px


..  index:: JavaScript; getIcon

The JavaScript way
------------------

In JavaScript, icons can be only fetched from the Icon Registry. To achieve this,
add the following dependency to your :ref:`ES6 module <backend-javascript-es6>`:
:js:`@typo3/backend/icons`. In this section, the module is known as :js:`Icons`.

The module has a single public method :js:`getIcon()` which accepts up to five arguments:

.. rst-class:: dl-parameters

identifier
    :sep:`|` :aspect:`Condition:` required
    :sep:`|` :aspect:`Type:` string
    :sep:`|`

    Identifier of the icon as registered in the Icon Registry.

size
    :sep:`|` :aspect:`Condition:` required
    :sep:`|` :aspect:`Type:` Sizes
    :sep:`|` :aspect:`Default:` medium
    :sep:`|`

    Desired size of the icon. All values of the :js:`Sizes` enum from
    :js:`@typo3/backend/enum/icon-types` are allowed,
    these are:

    -   :js:`default`:  1em, to scale with font size
    -   :js:`small`: fixed to 16px
    -   :js:`medium`: fixed to 32px (default)
    -   :js:`large`: fixed to 48px
    -   :js:`mega`: fixed to 64px

overlayIdentifier
    :sep:`|` :aspect:`Condition:` optional
    :sep:`|` :aspect:`Type:` string
    :sep:`|`

    Identifier of an overlay icon as registered in the Icon Registry.

state
    :sep:`|` :aspect:`Condition:` optional
    :sep:`|` :aspect:`Type:` string
    :sep:`|`

    Sets the state of the icon. All values of the :js:`States` enum from
    :js:`@typo3/backend/enum/icon-types` are
    allowed, these are: `default` and `disabled`.

markupIdentifier
    :sep:`|` :aspect:`Condition:` optional
    :sep:`|` :aspect:`Type:` string
    :sep:`|`

    Defines how the markup is returned. All values of the
    :js:`MarkupIdentifiers` enum from :js:`@typo3/backend/enum/icon-types` are
    allowed, these are: `default` and `inline`. Please note that
    `inline` is only meaningful for SVG icons.

The method :js:`getIcon()` returns a AjaxResponse Promise object, as internally
an Ajax request is done.

Here is an example code how a usage of the JavaScript Icon API may look like:

..  todo: move the example to examples extension
    https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/2299

..  code-block:: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/my-es6-module.js

    import Icons from '@typo3/backend/icons.js';

    class MyEs6Module {
        constructor() {
            // Get a single icon
            Icons.getIcon('spinner-circle-light', Icons.sizes.small, null, 'disabled').then((icon: string): void => {
                console.log(icon);
            });
        }
    }

    export default new MyEs6Module();


.. index:: Icon Api; Available icons
.. _available-icons:

Available icons
===============

The TYPO3 Core comes with a number of icons that may be used in your extensions.

To search for available icons, you can browse through
`TYPO3.Icons <https://typo3.github.io/TYPO3.Icons/>`__.


..  _icon_migration:

Migration
=========

The Rector rule `\Ssch\TYPO3Rector\TYPO311\v4\RegisterIconToIconFileRector`_
can be used for automatic migration.

For manual migration remove all calls
to :php:`\TYPO3\CMS\Core\Imaging\IconRegistry::registerIcon()` from
your :file:`EXT:my_extension/ext_localconf.php` and move the content to
:file:`Configuration/Icons.php` instead.


..  _\Ssch\TYPO3Rector\TYPO311\v4\RegisterIconToIconFileRector: https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#registericontoiconfilerector
