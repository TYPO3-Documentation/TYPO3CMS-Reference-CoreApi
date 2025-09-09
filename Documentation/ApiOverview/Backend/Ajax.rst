:navigation-title: Ajax

..  include:: /Includes.rst.txt
..  index:: pair: Ajax; Backend
..  _ajax-backend:

===================
Ajax in the backend
===================

An Ajax endpoint in the TYPO3 backend is usually implemented as a method in a
regular controller. The method receives a request object implementing the
:php:`\Psr\Http\Message\ServerRequestInterface`, which allows to access all
aspects of the requests and returns an appropriate response in a normalized way.
This approach is standardized as `PSR-7`_.

..  index:: pair: Ajax; Controller

Create a controller
===================

By convention, a controller is placed within the extension's :file:`Controller/`
directory, optionally in a subdirectory. To have such controller, create a new
:php:`ExampleController` in :file:`Classes/Controller/ExampleController.php`
inside your extension.

The controller needs not that much logic right now. We create a method called
:php:`doSomethingAction()` which will be our Ajax endpoint.

..  literalinclude:: _Ajax/_ExampleController1.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php

In its current state, the method does nothing yet. We can add a very generic
handling that exponentiates an incoming number by 2. The incoming value will be
passed as a query string argument named `input`.

..  literalinclude:: _Ajax/_ExampleController2.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php

..  note::
    This is a really simple example. Something like this should not be used in
    production, as such a feature is available via JavaScript as well.


We have computed our result by using the `exponentiation operator`_, but we
do nothing with it yet. It is time to build a proper response:

..  literalinclude:: _Ajax/_ExampleController3.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php


..  index:: Ajax; Endpoint
..  index:: Ajax; Routes
..  index:: File; EXT:{extkey}/Configuration/Backend/AjaxRoutes.php

Register the endpoint
=====================

The endpoint must be registered as :ref:`route <backend-routing>`. Create a
file called :file:`Configuration/Backend/AjaxRoutes.php` in your extension. The
file basically just returns an array of route definitions. Every route in this
file will be exposed to JavaScript automatically. Let us register our endpoint
now:

..  literalinclude:: _Ajax/_AjaxRoutes.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/AjaxRoutes.php

The naming of the key `myextension_example_dosomething` and path
`/my-extension/example/do-something` are up to you, but should contain the
extension name, controller name and action name to avoid potential conflicts
with other existing routes.

..  attention::
    Flushing caches is mandatory after modifying any route definition.

..  _protect-ajax-endpoint:

Protect the endpoint
====================

..  important::
    AJAX routes are **accessible to all authenticated backend users** by default
    and need proper permission checks in order to **avoid unauthorized access**.

Make sure to protect your endpoint against unauthorized access, if it performs
actions which are limited to authorized backend users only.

Inherit access from backend module
----------------------------------

..  versionadded:: 12.4.37 / 13.4.18
    This functionality was introduced in response to security advisory
    `TYPO3-CORE-SA-2025-021 <https://typo3.org/security/advisory/typo3-core-sa-2025-021>`_
    to mitigate broken access control in backend AJAX routes.

If your endpoint is part of a :ref:`backend module <backend-modules>`, you can
configure your endpoint to inherit access rights from this specific module by
using the configuration option `inheritAccessFromModule`:

..  literalinclude:: _Ajax/_AjaxRoutesProtected.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/AjaxRoutes.php

Use permission checks on standalone endpoints
---------------------------------------------

In case you're providing a standalone endpoint (that is, the endpoint is not
bound to a specific backend module), make sure to perform proper permission
checks on your own. You can use the
:ref:`backend user object <t3coreapi:be-user-check>` to perform various
authorization and permission checks on incoming requests.


Use in Ajax
===========

Since the route is registered in :file:`AjaxRoutes.php` it is exposed to
JavaScript now and stored in the global :js:`TYPO3.settings.ajaxUrls` object
identified by the used key in the registration. In this example it is
:js:`TYPO3.settings.ajaxUrls.myextension_example_dosomething`.

Now you are free to use the endpoint in any of your Ajax calls. To complete this
example, we will ask the server to compute our input and write the result into
the console.

..  literalinclude:: _Ajax/_Calculate.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/Calculate.js

..  seealso::
    :ref:`ajax-request`

..  _`PSR-7`: https://www.php-fig.org/psr/psr-7/
..  _`exponentiation operator`: https://www.php.net/manual/en/language.operators.arithmetic.php
