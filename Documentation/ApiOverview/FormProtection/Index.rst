..  include:: /Includes.rst.txt
..  index::
    Form protection tool
    Cross-site request forgery
    CSRF
..  _csrf:

====================
Form protection tool
====================

The TYPO3 Core provides a generic way of protecting forms against cross-site
request forgery (CSRF).

..  attention::
    This **requires a logged-in user** whether in frontend or backend. CSRF
    protection is not supported for anonymous users. Without a logged-in user
    the token will always be :php:`dummyToken`. See :forge:`77403` for details.


.. contents::
   :local:


..  index:: pair; Form protection tool; Backend
..  _csrf-backend:

Usage in the backend
====================

For each form in the BE (or link that changes some data), create a token and
insert it as a hidden form element. The name of the form element does not
matter; you only need it to get the form token for verifying it.

..  code-block:: php

    // use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

    $formToken = FormProtectionFactory::get()
        ->generateToken('BE user setup', 'edit')
    );
    $this->content .= '<input type="hidden" name="formToken" value="' . $formToken . '">';

The three parameters :php:`$formName`, :php:`$action` (optional) and
:php:`$formInstanceName` (optional) can be arbitrary strings, but they should
make the form token as specific as possible. For different forms (for example,
BE user setup and editing a :sql:`tt_content` record) or different records (with
different UIDs) from the same table, those values should be different.

For editing a :sql:`tt_content` record, the call could look like this:

..  code-block:: php

    // use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

    $formToken = FormProtectionFactory::get()
        ->generateToken('tt_content', 'edit', $uid);

Finally, you need to persist the tokens. This makes sure that
generated tokens get saved, and also that removed tokens stay removed:

..  code-block:: php

    // use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

    FormProtectionFactory::get()
        ->persistTokens();

In backend lists, it might be necessary to generate hundreds of tokens.
So, the tokens are not automatically persisted after creation for performance
reasons.

When processing the data that has been submitted by the form,
you can check that the form token is valid like this:

..  code-block:: php

    // use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
    // use TYPO3\CMS\Core\Utility\GeneralUtility;

    if ($dataHasBeenSubmitted &&
        FormProtectionFactory::get()->validateToken(
            (string) GeneralUtility::_POST('formToken'),
            'BE user setup',
            'edit'
        ) ) {
        // process the data
    } else {
        // No need to do anything here, as the backend form protection will
        // create a flash message for an invalid token
    }


..  note::
    The :php:`validateToken()` method invalidates the token with the token ID.
    So calling the validation with the same parameters twice in a row will
    always return :php:`false` for the second call.

..  attention::
    The tokens must be validated **before** the tokens are persisted. This
    makes sure that the tokens, that get invalidated by :php:`validateToken()`
    cannot be used again.


..  index:: pair: Form protection tool; Install tool
..  _csrf-install:

Usage in the install tool
=========================

For each form in the Install Tool (or link that changes some data),
create a token and insert it as a hidden form element.
The name of the form element does not matter;
you only need it to get the form token for verifying it.

..  code-block:: php

    $formToken = $this->formProtection
        ->generateToken('installToolPassword', 'change');
    // then puts the generated form token in a hidden field in the template

The three parameters :php:`$formName`, :php:`$action` (optional) and
:php:`$formInstanceName` (optional) can be arbitrary strings, but they should
make the form token as specific as possible. For different forms (for example,
the password change and editing the configuration), those values should be
different.

At the end of the form, you need to persist the tokens. This makes sure that
generated tokens get saved, and also that removed tokens stay removed:

..  code-block:: php

    $this->formProtection()->persistTokens();

When processing the data that has been submitted by the form, you can check that
the form token is valid like this:

..  code-block:: php

    if ($dataHasBeenSubmitted &&
        $this->formProtection()->validateToken(
            (string) $_POST['formToken'],
            'installToolPassword',
            'change'
        )
    ) {
        // processes the data
    } else {
        // No need to do anything here, as the Install Tool form protection will
        // create an error message for an invalid token
    }

..  note::
    The :php:`validateToken()` method invalidates the token with the token ID.
    So calling the validation with the same parameters twice in a row will
    always return :php:`false` for the second call.

..  attention::
    The tokens must be validated **before** the tokens are persisted. This makes
    sure that the tokens that get invalidated by :php:`validateToken()` cannot
    be used again.


..  index:: pair: Form protection tool; Frontend

Usage in the frontend
=====================

Usage is the same as in :ref:`backend context <csrf-backend>`:

..  code-block:: php

    // use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
    // use TYPO3\CMS\Core\Utility\GeneralUtility;

    $formToken = FormProtectionFactory::get()
        ->generateToken('news', 'edit', $uid);

	if ($dataHasBeenSubmitted
		&& FormProtectionFactory::get()->validateToken(
			GeneralUtility::_POST('formToken'),
			'news',
			'edit',
			$uid
		)
	) {
		// process the data
	} else {
		// Create a flash message for the invalid token
        // or just discard this request
	}


..  note::
    The :php:`validateToken()` invalidates the token with the token ID. So,
    calling the validation with the same parameters twice in a row will always
    return :php:`false` for the second call.

..  attention::
    The tokens must be validated **before** the tokens are persisted. This makes
    sure that the tokens that get invalidated by :php:`validateToken()` cannot
    be used again.
