.. include:: /Includes.rst.txt
.. index:: pair: Ajax; Backend
.. _ajax-backend:

===================
Ajax in the Backend
===================

An Ajax endpoint in the TYPO3 backend is usually implemented as a method in a regular controller. The method receives a
request object implementing the :php:`Psr\Http\Message\ServerRequestInterface`, which allows to access all aspects of
the requests and returns an appropriate response in a normalized way. This approach is standardized as `PSR-7`_.

..  seealso::
    You can find information on how to handle Ajax requests in the frontend
    in the chapter :ref:`Ajax in the Extension Development section <ajax-client-side>`.

.. index:: pair: Ajax; Controller

Create a controller
===================

By convention, a controller is placed within the extension's :file:`Controller` directory, optionally in a subdirectory.
To have such controller, create a new :php:`ExampleController` in :file:`Classes/Controller/ExampleController.php`
inside your extension.

The controller doesn't need that much logic right now. We'll create a method called :php:`doSomethingAction()` which
will be our Ajax endpoint.

.. code-block:: php

   <?php
   declare(strict_types = 1);

   namespace MyVendor\MyExtension\Controller;

   use Psr\Http\Message\ResponseFactoryInterface;
   use Psr\Http\Message\ResponseInterface;
   use Psr\Http\Message\ServerRequestInterface;

   class ExampleController
   {
      /** @var ResponseFactoryInterface */
      private $responseFactory;

      public function __construct(ResponseFactoryInterface $responseFactory)
      {
         $this->responseFactory = $responseFactory;
      }

      public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
      {
           // TODO: return ResponseInterface
      }
   }


In its current state, the method doesn't do anything yet. We can add a very generic handling that exponentiates an
incoming number by 2. The incoming value will be passed as a query string argument named `input`.

.. code-block:: php

   public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
   {
       $input = $request->getQueryParams()['input'] ?? null;
       if ($input === null) {
           throw new \InvalidArgumentException('Please provide a number', 1580585107);
       }

       $result = $input ** 2;
       // TODO: return ResponseInterface
   }


.. note::
   This is a really simple example. Something like this should not be used in production, as such feature is available
   in JavaScript as well.


We have computed our result by using the `exponentiation operator`_, but we don't do anything with it yet. It's time to
build a proper response. A response implements the :php:`Psr\Http\Message\ResponseInterface` and its constructor
accepts the following arguments:

.. rst-class:: dl-parameters

$body
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   The content of the response.

$statusCode
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` int
   :sep:`|` :aspect:`Default:` 200
   :sep:`|`

   The HTTP status code of the response. The default of `200` means `OK`.

$headers
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` array
   :sep:`|` :aspect:`Default:` '[]'
   :sep:`|`

   Headers to be sent with the response.

$reasonPhrase
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` string
   :sep:`|` :aspect:`Default:` ''
   :sep:`|`

   A reason for the given status code. If omitted, the default for the used status code will be used.

.. code-block:: php

   use Psr\Http\Message\ResponseFactoryInterface;
   
   public function __construct(
       private readonly ResponseFactoryInterface $responseFactory
   )
   {}

   public function doSomethingAction(ServerRequestInterface $request): ResponseInterface
   {
       // our previous computation
       $response = $this->responseFactory->createResponse()
           ->withHeader('Content-Type', 'application/json; charset=utf-8');
       $response->getBody()->write(json_encode(['result' => $result], JSON_THROW_ON_ERROR));
       return $response;
   }

.. index:: Ajax; Endpoint
.. index:: Ajax; Routes
.. index:: File; EXT:{extkey}/Configuration/Backend/AjaxRoutes.php

Register the endpoint
=====================

The endpoint must be registered as route. Create a file called :file:`Configuration/Backend/AjaxRoutes.php` in your
extension. The file basically just returns an array of route definitions. Every route in this file will be exposed to
JavaScript automatically. Let's register our endpoint now:

.. include:: /CodeSnippets/Manual/Extension/Configuration/BackendAjaxRoutes.rst.txt


The naming of the key `example_dosomething` and path `/example/do-something` are up to you, but should contain the
controller name and action name to avoid potential conflicts with other existing routes.

For further reading, take a look at :ref:`backend-routing`.

.. important::
   Flushing caches is mandatory after modifying any route definition.


Use in Ajax
===========

Since the route is registered in :file:`AjaxRoutes.php` its exposed to JavaScript now and stored in the global
:js:`TYPO3.settings.ajaxUrls` object identified by the used key in the registration. In this example it's
:js:`TYPO3.settings.ajaxUrls.example_dosomething`.

You are now free to use the endpoint in any of your Ajax calls. To complete this example, we'll ask the server to
compute our input and write the result into the console.

.. code-block:: js

   require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
     // Generate a random number between 1 and 32
     const randomNumber = Math.ceil(Math.random() * 32);
     new AjaxRequest(TYPO3.settings.ajaxUrls.example_dosomething)
       .withQueryArguments({input: randomNumber})
       .get()
       .then(async function (response) {
       const resolved = await response.resolve();
       console.log(resolved.result);
     });
   });


.. _`PSR-7`: https://www.php-fig.org/psr/psr-7/
.. _`exponentiation operator`: https://www.php.net/manual/en/language.operators.arithmetic.php
