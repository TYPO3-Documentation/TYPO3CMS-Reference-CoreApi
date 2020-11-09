.. include:: /Includes.rst.txt

.. _ajax-backend:

=======
Backend
=======

An AJAX endpoint in the TYPO3 backend is usually implemented as a method in a regular controller. The method receives a
request object implementing the :php:`Psr\Http\Message\ServerRequestInterface`, which allows to access all aspects of
the requests and returns an appropriate response in a normalized way. This approach is standardized as `PSR-7`_.


Create a Controller
===================

By convention, a controller is placed within the extension's :file:`Controller` directory, optionally in a subdirectory.
To have such controller, create a new :php:`ExampleController` in :file:`Classes/Controller/ExampleController.php`
inside your extension.

The controller doesn't need that much logic right now. We'll create a method called :php:`doSomethingAction()` which
will be our AJAX endpoint.

.. code-block:: php

   <?php
   declare(strict_types = 1);

   namespace Vendor\MyExtension\Controller;

   use Psr\Http\Message\ServerRequestInterface;
   use TYPO3\CMS\Core\Http\Response;

   class ExampleController
   {
       public function doSomethingAction(ServerRequestInterface $request): Response
       {
       }
   }


In its current state, the method doesn't do anything yet. We can add a very generic handling that exponentiates an
incoming number by 2. The incoming value will be passed as a query string argument named `input`.

.. code-block:: php

   public function doSomethingAction(ServerRequestInterface $request): Response
   {
       $input = $request->getQueryParams()['input'] ?? null;
       if ($input === null) {
           throw new \InvalidArgumentException('Please provide a number', 1580585107);
       }

       $result = $input ** 2;
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

   public function doSomethingAction(ServerRequestInterface $request): Response
   {
       // our previous computation

       return new Response(json_encode(['result' => $result]), 200, ['Content-Type' => 'application/json; charset=utf-8']);
   }


Register the Endpoint
=====================

The endpoint must be registered as route. Create a file called :file:`Configuration/Backend/AjaxRoutes.php` in your
extension. The file basically just returns an array of route definitions. Every route in this file will be exposed to
JavaScript automatically. Let's register our endpoint now:

.. code-block:: php

   <?php

   return [
       'example_dosomething' => [
           'path' => '/example/do-something',
           'target' => \Vendor\MyExtension\Controller\ExampleController::class . '::doSomethingAction',
       ],
   ];


The naming of the key `example_dosomething` and path `/example/do-something` are up to you, but should contain the
controller name and action name to avoid potential conflicts with other existing routes.

For further reading, take a look at :ref:`backend-routing`.

.. important::
   Flushing caches is mandatory after modifying any route definition.


Use in AJAX
===========

Since the route is registered in :file:`AjaxRoutes.php` its exposed to JavaScript now and stored in the global
:js:`TYPO3.settings.ajaxUrls` object identified by the used key in the registration. In this example it's
:js:`TYPO3.settings.ajaxUrls.example_dosomething`.

You are now free to use the endpoint in any of your AJAX calls. To complete this example, we'll ask the server to
compute our input and write the result into the console.

.. code-block:: js

   require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
     // Generate a random number between 1 and 32
     const randomNumber = Math.ceil(Math.random() * 32);
     new AjaxRequest(TYPO3.settings.ajaxUrls.example_dosomething).withQueryArguments({input: randomNumber}).get().then(async function (response) {
       const resolved = await response.resolve();
       console.log(resolved.result);
     });
   });


.. _`PSR-7`: https://www.php-fig.org/psr/psr-7/
.. _`exponentiation operator`: https://www.php.net/manual/en/language.operators.arithmetic.php
