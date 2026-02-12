..  include:: /Includes.rst.txt
..  index:: Authentication, Request token
..  _authentication-request-token:

================================
CSRF-like request token handling
================================

..  versionadded:: 12.0

A CSRF-like request token handling is available to mitigate potential cross-site
requests on actions with side effects. This approach does not require an
existing server-side user session, but uses a `nonce`_ as a "pre-session". The
main scope is to ensure a user actually has visited a page, before submitting
data to the webserver.

This token can only be used for HTTP methods `POST`, `PUT` or `PATCH`, but
for instance not for `GET` request.

The :php:`\TYPO3\CMS\Core\Middleware\RequestTokenMiddleware` resolves
request tokens and nonce values from a request and enhances responses with
a nonce value in case the underlying application issues one. Both items are
serialized as a `JSON Web Token (JWT)`_ hash signed with `HS256`. Request tokens
use the provided nonce value during signing.

Session cookie names involved for providing the nonce value:

*   `typo3nonce_[hash]` in case request served with plain HTTP
*   `__Secure-typo3nonce_[hash]` in case request served with secured HTTPS

Submitting request token value to application:

*   HTTP body, for example in `<form>` via parameter `__RequestToken`
*   HTTP header, for example in XHR via header `X-TYPO3-RequestToken`

..  attention::
    When working with multiple browser tabs, an existing nonce value (stored as
    session cookie in the browser of the user) might be overridden.

..  note::
    The current concept uses the :php:`\TYPO3\CMS\Core\Security\NoncePool` which
    supports five different nonces in the same request. The pool purges nonces
    15 minutes (900 seconds) after they have been issued.

..  seealso::
    The event :ref:`BeforeRequestTokenProcessedEvent` is available to
    intercept/adjust the request token.

.. _JSON Web Token (JWT): https://jwt.io/
.. _nonce: https://en.wikipedia.org/wiki/Cryptographic_nonce

..  _authentication-request-token-workflow:

Workflow
========

The sequence looks like the following:

..  rst-class:: bignums-xxl

#.  Retrieve nonce and request token values

    This happens on the previous legitimate visit on a page that offers
    a corresponding form that shall be protected. The `RequestToken` and `Nonce`
    objects (later created implicitly in this example) are organized in the
    :php:`\TYPO3\CMS\Core\Context\SecurityAspect`.

    ..  literalinclude:: _CSRFlikeRequestTokenHandling/_MyController.php
        :caption: EXT:my_extension/Classes/Controller/MyController.php

    ..  code-block:: html
        :caption: EXT:my_extension/Resources/Private/Templates/ShowForm.html

        <!-- Assign request token object for ViewHelper -->
        <f:form action="process" requestToken="{requestToken}">
            ...
        </f:form>

    The HTTP response on calling the shown controller action above will be like
    this:

    ..  code-block:: text

        HTTP/1.1 200 OK
        Content-Type: text/html; charset=utf-8
        Set-Cookie: typo3nonce_[hash]=[nonce-as-jwt]; path=/; httponly; samesite=strict

        ...
        <form action="/my/process" method="post">
            ...
            <input type="hidden" name="__request_token" value="[request-token-as-jwt]">
            ...
        </form>

#.  Invoke action request and provide nonce and request token values

    When submitting the form and invoking the corresponding action, same-site
    cookies `typo3nonce_[hash]` and request-token value `__RequestToken` are
    sent back to the server. Without using a separate nonce in a scope that is
    protected by the client, the corresponding request token could be easily
    extracted from markup and used without having the possibility to verify the
    procedural integrity.

    The middleware :php:`\TYPO3\CMS\Core\Middleware\RequestTokenMiddleware`
    takes care of providing the received nonce and received request token values
    in :php:`\TYPO3\CMS\Core\Context\SecurityAspect`. The handling controller
    action needs to verify that the request token has the expected
    `'my/process'` scope.

    ..  literalinclude:: _CSRFlikeRequestTokenHandling/_MyProcessController.php
        :caption: EXT:my_extension/Classes/Controller/MyController.php
