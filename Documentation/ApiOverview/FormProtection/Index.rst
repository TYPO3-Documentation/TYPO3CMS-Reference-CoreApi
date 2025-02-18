..  include:: /Includes.rst.txt
..  index::
    Form protection tool
    Cross-site request forgery
    CSRF
..  _csrf:
..  _csrf-backend:

====================
Form protection tool
====================

The TYPO3 Core provides a generic way of protecting forms against cross-site
request forgery (CSRF).

..  attention::
    This **requires a logged-in user** whether in frontend or backend. CSRF
    protection is not supported for anonymous users. Without a logged-in user
    the token will always be :php:`dummyToken`. See :forge:`77403` for details.

For each form in the backend/frontend (or link that changes some data), create a
token and insert it as a hidden form element. The name of the form element does
not matter; you only need it to get the form token for verifying it.

Examples
========

..  literalinclude:: _FormProtectionExample.php
    :caption: EXT:my_extension/Classes/Controller/FormProtectionExample.php

The three parameters of the :php:`generateToken()` method:

-   :php:`$formName`
-   :php:`$action` (optional)
-   :php:`$formInstanceName` (optional)

can be arbitrary strings, but they should make the form token as specific as
possible. For different forms (for example, BE user setup and editing a
:sql:`tt_content` record) or different records (with different UIDs) from the
same table, those values should be different.

For editing a :sql:`tt_content` record, the call could look like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/FormProtectionExample.php (Excerpt)

    $formToken = $formProtection->generateToken('tt_content', 'edit', (string)$uid);

When processing the data that has been submitted by the form, you can check that
the form token is valid like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/FormProtectionExample.php (Excerpt)

    if ($dataHasBeenSubmitted &&
        $formProtection->validateToken(
            $request->getParsedBody()['formToken'] ?? '',
            'BE user setup',
            'edit'
        ) ) {
        // process the data
    } else {
        // No need to do anything here, as the backend form protection will
        // create a flash message for an invalid token
    }

As it is recommended to use :php:`FormProtectionFactory->createForRequest()`
to auto-detect which type is needed, one can also create a specific type
directly:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/FormProtectionExample.php (Excerpt)

    // For backend
    $formProtection = $this->formProtectionFactory->createFromType('backend');

    // For frontend
    $formProtection = $this->formProtectionFactory->createFromType('frontend');
