.. include:: ../../Includes.txt






.. _csrf:

====================
Form Protection Tool
====================

Since TYPO3 4.5, the TYPO3 Core provides a generic way of protecting
forms against Cross-Site Request Forgery (CSRF).


.. _csrf-backend:

Usage in the Backend
====================

For each form in the BE (or link that changes some data), create a token and insert is as a hidden form element.
The name of the form element does not matter; you only need it to get the form token for verifying it.

.. code-block:: php

   $formToken = TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()
      ->generateToken('BE user setup', 'edit')
   );
   $this->content .= '<input type="hidden" name="formToken" value="' . $formToken . '" />';

The three parameters :code:`$formName`, :code:`$action` and :code:`$formInstanceName` can be arbitrary strings,
but they should make the form token as specific as possible. For different forms
(e.g. BE user setup and editing a tt_content record) or different records (with different UIDs)
from the same table, those values should be different.

For editing a tt_content record, the call could look like this:

.. code-block:: php

   $formToken = TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->generateToken('tt_content', 'edit', $uid);

At the end of the form, you need to persist the tokens. This makes sure that generated tokens get saved,
and also that removed tokens stay removed:

.. code-block:: php

   TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->persistTokens();

In BE lists, it might be necessary to generate hundreds of tokens.
So the tokens do not get automatically persisted after creation for performance reasons.

When processing the data that has been submitted by the form,
you can check that the form token is valid like this:

.. code-block:: php

   if ($dataHasBeenSubmitted &&
      TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->validateToken(
         (string) \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('formToken'),
         'BE user setup', 'edit'
      ) ) {
      // processes the data
   } else {
      // no need to do anything here as the BE form protection will create a
      // flash message for an invalid token
 }

Note that :code:`validateToken` invalidates the token with the token ID.
So calling the validation with the same parameters twice in a row
will always return :code:`FALSE` for the second call.

It is important that the tokens get validated **before** the tokens are persisted.
This makes sure that the tokens that get invalidated by :code:`validateToken`
cannot be used again.


.. _csrf-install:

Usage in the Install Tool
=========================

For each form in the Install Tool (or link that changes some data),
create a token and insert is as a hidden form element.
The name of the form element does not matter;
you only need it to get the form token for verifying it.

.. code-block:: php

   $formToken = $this->formProtection->generateToken('installToolPassword', 'change');
   // then puts the generated form token in a hidden field in the template

The three parameters :code:`$formName`, :code:`$action` and :code:`$formInstanceName`
can be arbitrary strings, but they should make the form token as specific as possible.
For different forms (e.g. the password change and editing a the configuration),
those values should be different.

At the end of the form, you need to persist the tokens.
This makes sure that generated tokens get saved, and also that removed tokens stay removed:

.. code-block:: php

   $this->formProtection()->persistTokens();

When processing the data that has been submitted by the form, you can check that the form token is valid like this:

.. code-block:: php

   if ($dataHasBeenSubmitted &&
      $this->formProtection()->validateToken(
         (string) $_POST['formToken'],
         'installToolPassword',
         'change')
   ) {
      // processes the data
   } else {
      // no need to do anything here as the Install Tool form protection will
      // create an error message for an invalid token
   }

Note that :code:`validateToken` invalidates the token with the token ID.
So calling the validation with the same parameters twice in a row
will always return :code:`FALSE` for the second call.

It is important that the tokens get validated **before** the tokens are persisted.
This makes sure that the tokens that get invalidated by :code:`validateToken`
cannot be used again.

Usage in the Frontend
=====================

.. versionadded:: 7.6

:doc:`t3core:Changelog/7.6/Feature-56633-FormProtectionAPIForFrontEndUsage` introduced a new
class to allow usage of the FormProtection (CSRF protection) API in the frontend.

Usage is the same as in backend context:

.. code-block:: php

	$formToken = \TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()
		->getFormProtection()->generateToken('news', 'edit', $uid);


	if ($dataHasBeenSubmitted
		&& \TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->validateToken(
			\TYPO3\CMS\Core\Utility\GeneralUtility::_POST('formToken'),
			'User setup',
			'edit'
		)
	) {
		// Processes the data.
	} else {
		// Create a flash message for the invalid token or just discard this request.
	}


Note that :code:`validateToken` invalidates the token with the token ID.
So calling the validation with the same parameters twice in a row
will always return :code:`FALSE` for the second call.

It is important that the tokens get validated **before** the tokens are persisted.
This makes sure that the tokens that get invalidated by :code:`validateToken`
cannot be used again.
