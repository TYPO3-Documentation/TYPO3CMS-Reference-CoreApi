:navigation-title: URI builder

..  include:: /Includes.rst.txt
..  index:: Extbase; URI builder
..  _extbase-uri-builder:

=====================
URI builder (Extbase)
=====================

The URI builder offers a convenient way to create links in an Extbase context.

..  _extbase-uri-builder-controller:

Usage in an Extbase controller
==============================

The URI builder is available as a property in a controller class which extends
the :ref:`extbase-action-controller` class. The request context is automatically
available to the UriBuilder.

Example:

..  literalinclude:: _UriBuilder/_MyController.php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

Have a look into the :ref:`API <uri-builder-api>` for the available methods of
the URI builder.

..  attention::
    As the URI builder holds state, you have to call :php:`reset()` before
    creating a URL.

..  _extbase-uri-builder-other:

Usage in another context
========================

The class :php:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder` can be injected
via constructor in a class:

..  literalinclude:: _UriBuilder/_MyClass.php
    :caption: EXT:my_extension/Classes/MyClass.php

Setting the request object before first usage is mandatory.

..  note::
    In the above example, the :ref:`PSR-7 request object <typo3-request>` is
    retrieved from the global variable :php:`TYPO3_REQUEST`. This is not
    recommended and is only a fallback. See the section
    :ref:`getting-typo3-request-object` to learn how to retrieve the request
    PSR-7 object depending on the context.

..  attention::
    When using the URI builder to build frontend URLs, the current content
    object is required. It is initialized from the handed in local request
    object. In case extensions set the request object without the request attribute
    :ref:`currentContentObject <typo3-request-attribute-current-content-object>`,
    an automatic fallback is applied in TYPO3 v12, triggering a PHP deprecation
    warning. The fallback has been removed in TYPO3 v13.

..  _extbase-uri-builder-viewhelper:

Example in Fluid ViewHelper
---------------------------

..  literalinclude:: _UriBuilder/_MyLinkViewHelper.php
    :caption: EXT:my_extension/Classes/ViewHelper/MyLinkViewHelper.php

..  note::
    This example was taken from :php:`TYPO3\CMS\Fluid\ViewHelpers\Uri\ActionViewHelper`
    of the TYPO3 Core. These ViewHelpers are always a useful example to see the best practice on how
    to retrieve request context.

..  attention::
    This example uses the :php:`TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper` to be extended from,
    which does not have its own constructor, making constructor-based dependency injection straight forward.
    However, if you use :php:`TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper` as a base, which already
    provides a constructor, be sure to call :php:`parent::_construct()` in your custom constructor.
    Alternatively (though less recommendable), you can use :php:`GeneralUtility::makeInstance()` to retrieve
    the UriBuilder instance, or use method-based injection (:php:`injectUriBuilder(UriBuilder $uriBuilder)`).
    Note, always flush the TYPO3 cache after adding/modifying ViewHelpers with new injected dependencies.
    See :ref:`Dependency injection <t3coreapi:Dependency-Injection>` for more details.


..  _uri-builder-api:

API
===

..  include:: /CodeSnippets/Extbase/UriBuilder.rst.txt
