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

..  seealso::
    `PSR-7: HTTP message interfaces <https://www.php-fig.org/psr/psr-7/>`__

.. contents::
   :local:

..  _getting-typo3-request-object:

Getting the PSR-7 request object
================================

The PSR-7 based request object is available in most contexts. In some scenarios,
like :ref:`PSR-15 middlewares <request-handling>` or backend module controllers,
the PSR-7 base request object is given as argument to the called method.

..  _typo3-request-extbase-controller:

Extbase controller
------------------

The request object compatible with the PSR-7
:php:`\Psr\Http\Message\ServerRequestInterface` is available in an
:ref:`Extbase controller <extbase-action-controller>` via the class property
:php:`$this->request`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    final class MyController extends ActionController
    {
        // ...

        public function myAction(): ResponseInterface
        {
            // ...

            // Retrieve the language attribute via the request object
            $language = $this->request->getAttribute('language');

            // ...
        }
    }

..  note::
    Prior to TYPO3 v11.3, a custom Extbase request object is available that does
    not adhere to the PSR-7 standard. If you want to stay compatible with
    TYPO3 v10 and TYPO3 v11 you have to use the :ref:`global variable
    <typo3-request-global-variable>`.

..  _typo3-request-extbase-validator:

Extbase validator
-----------------

..  versionadded:: 13.2
    Extbase :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`
    provides a getter and a setter for the PSR-7 Request object.

In Extbase validators the current request is available with
`$this->getRequest()` if they extend the :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`:

..  literalinclude:: /ExtensionArchitecture/Extbase/Reference/Validation/CustomValidator/_RequestValidator.php
    :caption: EXT:my_extension/Classes/Domain/Validators/MyCustomValidator.php

..  _typo3-request-viewhelper:

ViewHelper
----------

..  deprecated:: 13.3
    The following methods have been marked as deprecated in TYPO3 v13.3 and will
    be removed with TYPO3 v14:

    * :php:`TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->setRequest()`
    * :php:`TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->getRequest()`


In a ViewHelper you can get the rendering request from the rendering context if
it is set.

..  literalinclude:: _CodeSnippets/_ViewHelper.php
    :caption: EXT:my_extension/Classes/ViewHelpers/MyViewHelper.php

To stay compatible to previous TYPO3 versions while avoiding deprecation notices,
the following code can be used:

..  literalinclude:: _CodeSnippets/_ViewHelperV12.php
    :caption: EXT:my_extension/Classes/ViewHelpers/MyViewHelper.php

..  _typo3-request-user-function:

User function
-------------

In a :ref:`TypoScript user function <t3tsref:cobj-user>` the request object
is available as third parameter of the called class method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/UserFunction/MyUserFunction.php

    use Psr\Http\Message\ServerRequestInterface;

    final class MyUserFunction
    {
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
    }

..  _typo3-request-data-processor:

Data processor
--------------

A :ref:`data processor <content-elements-custom-data-processor>` receives a
reference to the :php:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer`
as first argument for the :php:`process()` method. This object provides a
:php:`getRequest()` method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/DataProcessing/MyProcessor.php

    use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
    use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

    final class MyProcessor implements DataProcessorInterface
    {
        public function process(
            ContentObjectRenderer $cObj,
            array $contentObjectConfiguration,
            array $processorConfiguration,
            array $processedData
        ): array {
            $request = $cObj->getRequest();

            // ...
        }
    }

..  _typo3-request-console-command:

Console command
---------------

Within a `Console command (CLI) <https://docs.typo3.org/permalink/t3coreapi:symfony-console-commands>`_
there is no request available. See also https://forge.typo3.org/issues/105554

If a request is needed initialize one as described in
`Initialize a frontend request in a console command <https://docs.typo3.org/permalink/t3coreapi:console-command-tutorial-fe-request>`_.

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
        return $GLOBALS['TYPO3_REQUEST'];
    }

This way, it is only referenced once. It can be cleaned up later easily when
the request object is made available in that context in a future TYPO3 version.


..  _typo3-request-attributes:

Attributes
==========

Attributes enriches the request with further information. TYPO3 provides
attributes which can be used in custom implementations.

The attributes can be retrieved via

..  code-block:: php

    // Get all available attributes
    $allAttributes = $request->getAttributes();

    // Get only a specific attribute, here the site entity in frontend context
    $site = $request->getAttribute('site');

The request object is also available as a global variable in
:php:`$GLOBALS['TYPO3_REQUEST']`. This is a workaround for the Core which has to
access the server parameters at places where :php:`$request` is not available.
So, while this object is globally available during any HTTP request, it is
considered bad practice to use this global object, if the request is accessible
in another, official way. The global object is scheduled to vanish at a later
point once the code has been refactored enough to not rely on it anymore.


The following attributes are available in **frontend** context:

*    :doc:`RequestAttributes/ApplicationType`
*    :doc:`RequestAttributes/CurrentContentObject`
*    :doc:`RequestAttributes/FrontendCacheCollector`
*    :doc:`RequestAttributes/FrontendCacheInstruction`
*    :doc:`RequestAttributes/FrontendController`
*    :doc:`RequestAttributes/FrontendPageInformation`
*    :doc:`RequestAttributes/FrontendTyposcript`
*    :doc:`RequestAttributes/FrontendUser`
*    :doc:`RequestAttributes/Language`
*    :doc:`RequestAttributes/Nonce`
*    :doc:`RequestAttributes/NormalizedParams`
*    :doc:`RequestAttributes/Routing`
*    :doc:`RequestAttributes/Site`

The following attributes are available in **backend** context:

*   :doc:`RequestAttributes/ApplicationType`
*   :doc:`RequestAttributes/Module`
*   :doc:`RequestAttributes/ModuleData`
*   :doc:`RequestAttributes/Nonce`
*   :doc:`RequestAttributes/NormalizedParams`
*   :doc:`RequestAttributes/Route`
*   :doc:`RequestAttributes/Site`
*   :doc:`RequestAttributes/Target`
