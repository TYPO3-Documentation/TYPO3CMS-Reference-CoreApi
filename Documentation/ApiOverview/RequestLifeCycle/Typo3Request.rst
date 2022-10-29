..  include:: /Includes.rst.txt
..  index::
    Request handling; request object
    $GLOBALS; TYPO3_REQUEST
..  _typo3-request:

====================
TYPO3 request object
====================

The TYPO3 request object is an implementation of the PSR-7 based
`\Psr\Http\Message\ServerRequestInterface` containing TYPO3-specific attributes.

.. contents::
   :local:


..  _getting-typo3-request-object:

Getting the PSR-7 request object
================================

The PSR-7 based request object is available in most contexts. In some scenarios,
like :ref:`PSR-15 middlewares <request-handling>` or backend module controllers,
the PSR-7 base request object is given as argument to the called method.


Extbase controller
------------------

..  versionadded:: 11.3

The request object compatible with the PSR-7
:php:`\Psr\Http\Message\ServerRequestInterface` is available in an
:ref:`Extbase controller <extbase-action-controller>` via the class property
:php:`$this->request`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

    public function myAction(): ServerResponseInterface
    {
        // ...

        // Retrieve the language attribute via the request object
        $language = $this->request->getAttribute('language');

        // ...
    }

Prior to TYPO3 v11.3, a custom Extbase request object is available that does not
adhere to the PSR-7 standard. If you need the PSR-7 compatible request object
in an older version you have to use the :ref:`global variable
<typo3-request-global-variable>`.


User function
-------------

In a :ref:`TypoScript user function <t3tsref:cobj-user>` the request object
is available as third parameter of the called class method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/UserFunction/MyUserFunction.php

    public function doSomething(
        string $content,
        array $conf,
        ServerRequestInterface $request
    ): string {
        // ...

        // Retrieve the language attribute via the request object
        $language = $request->getAttribute('language');

        // ...
    }


Data processor
--------------

A :ref:`data processor <content-elements-custom-data-processor>` receives a
reference to the :php:`ContentObjectRenderer` as first argument for the
:php:`process()` method. This object provides a :php:`getRequest()` method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataProcessing/MyProcessor.php

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $request = $cObj->getRequest();

        // ...
    }


..  _typo3-request-global-variable:

Last resort: global variable
----------------------------

TYPO3 provides the request object also in the global variable
:php:`$GLOBALS['TYPO3_REQUEST']`. Whenever it is possible the request should be
retrieved within the contexts described above. But this is not always possible
by now.

When using the global variable, it should be wrapped into a getter method:

..  code-block:: php

    // use Psr\Http\Message\ServerRequestInterface;

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST']);
    }

This way, it is only referenced once. It can be cleaned up later easily when
the request object is made available in that context in a future TYPO3 version.


Attributes
==========

Attributes enriches the request with further information. TYPO3 provides
attributes which can be used in custom implementations.

The attributes can be retrieved via

..  code-block:: php

    // Get all available attributes
    $allAttributes = $request->getAttributes();

    // Get only a specific attribute, here about the site in frontend
    $site = $request->getAttribute('site');

The request object is also available as a global variable in
:php:`$GLOBALS['TYPO3_REQUEST']`. This is a workaround for the Core which has to
access the server parameters at places where :php:`$request` is not available.
So, while this object is globally available during any HTTP request, it is
considered bad practice to use this global object, if the request is accessible
in another, official way. The global object is scheduled to vanish at a later
point once the code has been refactored enough to not rely on it anymore.


The following attributes are available in **frontend** context:

..  toctree::
    :titlesonly:

    RequestAttributes/ApplicationType
    RequestAttributes/FrontendController
    RequestAttributes/FrontendUser
    RequestAttributes/Language
    RequestAttributes/NormalizedParams
    RequestAttributes/Routing
    RequestAttributes/Site

The following attributes are available in **backend** context:

..  toctree::
    :titlesonly:

    RequestAttributes/ApplicationType
    RequestAttributes/NormalizedParams
    RequestAttributes/Route
    RequestAttributes/Site
    RequestAttributes/Target
