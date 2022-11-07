.. include:: /Includes.rst.txt
.. index::
   Backend; Icon API
   Icon API
.. _icon:

========
Icon API
========

TYPO3 provides an icon API for all icons in the TYPO3 backend.

.. index:: IconRegistry; registerIcon
.. _icon-registration:

Registration
============

All icons must be registered in the :php:`IconRegistry`.
To register icons for your own extension, create a file called
:file:`Configuration/Icons.php` in your extension - for example:
:file:`EXT:my_extension/Configuration/Icons.php`.

.. note::

   In versions below TYPO3 v11.4 the configuration was done in the :file:`ext_localconf.php`,
   please use the version selector to look-up the syntax in the corresponding
   documentation version.

The file needs to return a flat PHP configuration array with the following keys:

.. include:: /CodeSnippets/Manual/Extension/Configuration/IconsPhp.rst.txt


.. index:: Icon API; IconProviderInterface

IconProvider
------------

The TYPO3 Core ships two icon providers which can be used straight away:

* :php:`BitmapIconProvider` – For all kinds of bitmap icons (GIF, PNG, JPEG, etc.)
* :php:`SvgIconProvider` – For SVG icons

.. versionchanged:: 12.0
   The :php:`FontawesomeIconProvider`
   was removed from the Core in 12.0. You can use the polyfill extension from
   :t3ext:`fontawesome_provider` which is also compatible with TYPO3 v11 LTS.

If require need a custom icon provider, you can add your own by writing a
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

.. versionchanged:: 12.0

   The TYPO3 Icon Api previously defaulted to :php:`Icon::SIZE_DEFAULT` and was
   adapted to now use :php:`Icon::SIZE_MEDIUM` instead. :php:`Icon::SIZE_MEDIUM`
   is displayed at a fixed size of 32x32 px while :php:`Icon::SIZE_DEFAULT`
   now scales with the text.

   In cases where the size :php:`Icon::SIZE_DEFAULT` was explicitly set this
   might result in changed behavior. Switch to :php:`Icon::SIZE_MEDIUM` then.

.. index::
   Fluid; Core icon
   pair: Icon API; Fluid

The Fluid Viewhelper
--------------------

You can also use the :ref:`Fluid core:icon Viewhelper <t3viewhelper:typo3-core-icon>` to render an icon in your view:

.. code-block:: html

   {namespace core = TYPO3\CMS\Core\ViewHelpers}
   <core:icon identifier="my-icon-identifier" size="small" />

This will render the desired icon using an `img`-tag. If you prefer having the SVG inlined into your HTML (e.g. for being able to change colors with CSS), you can set the optional `alternativeMarkupIdentifier` attribute to `inline`. By default, the icon will pick up the font-color of its surrounding element if you use this option.

.. code-block:: html

   {namespace core = TYPO3\CMS\Core\ViewHelpers}
   <core:icon identifier="my-icon-identifier" size="small" alternativeMarkupIdentifier="inline" />


.. index:: JavaScript; getIcon

The JavaScript way
------------------

..  versionchanged:: 12.0
    The JavaScript icon provider has been moved from the RequireJS module
    :js:`TYPO3/CMS/Backend/Icons` to the ES6 module :js:`@typo3/backend/icons`.
    See also :ref:`backend-javascript-es6`.

In JavaScript, icons can be only fetched from the Icon Registry. To achieve this,
add the following dependency to your :ref:`ES6 module <backend-javascript-es6>`: :js:`@typo3/backend/icons`.
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
    :sep:`|` :aspect:`Type:` Sizes
    :sep:`|` :aspect:`Default:` medium
    :sep:`|`

    Desired size of the icon. All values of the :js:`Sizes` enum from
    :js:`@typo3/backend/enum/icon-types` are allowed,
    these are:

    -   :js:`default`:  1em, to scale with font size
    -   :js:`small`: fixed to 16px
    -   :js:`medium`: fixed to 32px (default)
    -   :js:`large`: fixed to 64px
    -   :js:`mega`:
    -   :js:`overlay`:

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
    :js:`@typo3/backend/enum/icon-types' are
    allowed, these are: `default` and `disabled`.

markupIdentifier
    :sep:`|` :aspect:`Condition:` optional
    :sep:`|` :aspect:`Type:` string
    :sep:`|`

    Defines how the markup is returned. All values of the
    :js:`MarkupIdentifiers` enum from :js:`@typo3/backend/enum/icon-types' are
    allowed, these are: `default` and `inline`. Please note that
    `inline` is only meaningful for SVG icons.

The method :js:`getIcon()` returns a AjaxResponse Promise object, as internally
an Ajax request is done.

The icons are cached in the local storage of the client to reduce the workload off the server.
Here is an example code how a usage of the JavaScript Icon API may look like:

..  todo: move the example to examples extension
    https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/2299

..  code-block:: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/my-es6-module.js

    import Icons from '@typo3/backend/icons';

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

To search for available icons, you can use one of these possibilities:


Install the styleguide extension
--------------------------------

Install the extension *styleguide* as described in the Readme in the `installation
<https://github.com/TYPO3/styleguide#installation>`__ section.

Once installed, you can view available icons by selecting help (?) on the top in the
TYPO3 backend, then *Styleguide* and then *Icons*, *All Icons*.

There, browse through existing icons. Use the name under the icon (for example
:code:`actions-add`) as first parameter for :php:`IconFactory::getIcon()` in PHP or as value for
the argument :code:`identifier` in Fluid (see code examples above).


.. include:: /Images/AutomaticScreenshots/Icon/IconProviders.rst.txt

Use TYPO3.Icons
---------------

An alternative way to look for existing icons is to browse through `TYPO3.Icons <https://typo3.github.io/TYPO3.Icons/>`__.
