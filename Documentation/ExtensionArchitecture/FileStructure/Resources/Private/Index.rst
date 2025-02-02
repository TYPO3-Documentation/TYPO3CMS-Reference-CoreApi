.. include:: /Includes.rst.txt
.. index::
   Extension development; Resources/Private
   Folder; Resources/Private
   Resources; Private
.. _extension-resources-private:

=========
`Private`
=========

This folder contains resources that are needed when rendering a page
but are not needed directly by the browser. This includes:

*   Fluid templates
*   :ref:`Language files <extension-Resources-Private-Language>`
*   Files for the compilation of assets like SCSS or TypeScript

..  contents:: Table of contents

.. _extension-resources-private-fluid:

Fluid templates in the folder Resources/Private
===============================================

Fluid templates are commonly stored in a folder called
:path:`Resources/Private/Templates`. The concrete location of templates is
configurable via:

*   TypoScript for `PAGEVIEW <https://docs.typo3.org/permalink/t3tsref:cobj-pageview>`_:
    :ref:`paths.[priority] <t3tsref:confval-pageview-paths>`
*   TypoScript for `FLUIDTEMPLATE <https://docs.typo3.org/permalink/t3tsref:cobj-template>`_:
    :ref:`templateRootPaths <t3tsref:confval-fluidtemplate-templaterootpaths>` etc.
*   Mails via global configuration:
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'] <t3coreapi:confval-globals-typo3-conf-vars-mail-templaterootpaths>`
*   Settings of diverse system or third party extensions like

    *   Fluid-Styled Content: :confval:`styles.templates.templateRootPath <typo3/cms-fluid-styled-content:fluid-styled-content-styles-templates-templaterootpath>`
    *   Frontend Login: :ref:`felogin.email.templateRootPath <typo3/cms-felogin:confval-felogin-felogin-email-templaterootpath>`

*   In some special cases paths might be set in PHP as well, for example when a
    ViewFactory is used: `Using the generic view factory (ViewFactoryInterface) <https://docs.typo3.org/permalink/t3coreapi:generic-view-factory>`_.

.. _extension-resources-private-fluid-plugin:

Common locations for Fluid templates in TYPO3 extensions with plugins:
======================================================================

..  typo3:file:: [ActionName].html
    :scope: extension
    :path: /Resources/Private/Templates/[ControllerName]/
    :regex: /^.*\/Resources\/Private\/Templates(\/[A-Za-z0-9]+)?\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Template for an extension

    Folder `Templates` often contains the Fluid templates for a TYPO3 extensions
    plugins. In Extbase they are stored in a folder with the name of the controller
    class (without Controller ending), for example the `NewsController.php` has
    it the template for action "view" in
    :file:`/Resources/Private/Templates/News/View.html`. Non-Extbase controllers
    can decide on how to use this folder.

..  typo3:file:: SomePartials.html
    :scope: extension
    :path: /Resources/Private/Partials/
    :regex: /^.*\/Resources\/Private\/Partials(\/[A-Za-z0-9]+)*\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Partials for an extension

    Folder `Partials` often contains the Fluid partials for a TYPO3 extension.
    These can be included via the `Render ViewHelper <f:render> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-render>`_
    into the main Fluid template.

..  typo3:file:: SomeLayout.html
    :scope: extension
    :path: /Resources/Private/Layouts/
    :regex: /^.*\/Resources\/Private\/Layouts\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Layouts for an extension

    Folder `Layouts` often contains the Fluid layouts for a TYPO3 extension.
    These can be included via the `Layout ViewHelper <f:layout> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-layout>`_
    into the main Fluid template.

.. _extension-resources-private-fluid-site-packages:

Common Fluid template locations for the page view in site packages
==================================================================

Commonly site package in TYPO3 v13 and above use the `PAGEVIEW <https://docs.typo3.org/permalink/t3tsref:cobj-pageview>`_
TypoScript object to display the HTML page output. They have one folder, commonly
`PageView` or `Templates` in folder `Resources/Private` with the subfolders
`Pages`, `Partials` and `Layouts` (they cannot be renamed).

..  typo3:file:: MyPageLayout.html
    :scope: extension
    :path: /Resources/Private/PageView/Pages/
    :regex: /^.*\/Resources\/Private\/PageView\/Pages\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Templates for different page layouts

    This folder contains one Fluid template for each page layout defined in the
    site package. See `Site package Tutorial, the page view <https://docs.typo3.org/permalink/t3sitepackage:pageview>`_.

..  typo3:file:: SomePartials.html
    :scope: extension
    :path: /Resources/Private/PageView/Partials/
    :regex: /^.*\/Resources\/Private\/PageView\/Partials\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Partials for the page view

    Folder `Partials` contains the Fluid partials used by the page view.
    These can be included via the `Render ViewHelper <f:render> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-render>`_
    into the page view template.

..  typo3:file:: SomeLayout.html
    :scope: extension
    :path: /Resources/Private/PageView/Layouts/
    :regex: /^.*\/Resources\/Private\/PageView\/Layouts\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Layouts for the page view

    Folder `Layouts` often contains the Fluid layout(s) used by the page view.
    These can be included via the `Layout ViewHelper <f:layout> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-layout>`_
    into the page view template.

.. _extension-resources-private-fluid-site-fsc:

Common locations to override Fluid-Styled content elements
==========================================================

Templates to override or extend Fluid-Styled Content based content objects are
typically stored in a folder called `/Resources/Private/ContentElements`. This
needs to be configured via setting
:confval:`styles.templates.templateRootPath <typo3/cms-fluid-styled-content:fluid-styled-content-styles-templates-templaterootpath>`
etc. to work. See also `Site Package Tutorial: Overriding the default templates of content elements <https://docs.typo3.org/permalink/t3sitepackage:content-element-rendering>`_.

..  typo3:file:: SomeContentElement.html
    :scope: extension
    :path: /Resources/Private/ContentElements/Pages/
    :regex: /^.*\/Resources\/Private\/ContentElements\/Pages\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Templates for different content elements

    This folder contains one Fluid template for each content element type defined in the
    site package.

..  typo3:file:: SomePartials.html
    :scope: extension
    :path: /Resources/Private/ContentElements/Partials/
    :regex: /^.*\/Resources\/Private\/ContentElements\/Partials\/[A-Za-z0-9]+\.html$/
    :shortDescription: Fluid Partials for content elements

    Typically overrides the Fluid-Styled Content partials.

..  typo3:file:: Default.html
    :scope: extension
    :path: /Resources/Private/ContentElements/Layouts/
    :regex: /^.*\/Resources\/Private\/ContentElements\/Layouts\/Default\.html$/
    :shortDescription: Overrides the default layout for Fluid-styled content elements

    Overrides the default layout originally defined in
    `vendor/typo3/cms-fluid-styled-content/Resources/Private/Layouts/Default.html`.
    It is possible to define additional custom layouts that can be
    included via the `Layout ViewHelper <f:layout> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-layout>`_
    into content element templates.


.. toctree::
   :titlesonly:
   :glob:

   *
