.. include:: /Includes.rst.txt

.. _login-provider:

======================
Backend login form API
======================

Registering a login provider
============================

The concept of the backend login is based on "login providers".

A login provider can be registered within your :file:`config/system/settings.php`
or :file:`config/system/additional.php`  like this:

..  code-block:: php
    :caption: config/system/additional.php

	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416020] = [
		'provider' => \Vendor\MyExtension\LoginProvider\CustomLoginProvider::class,
		'sorting' => 50,
		'iconIdentifier' => 'actions-key',
		'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang.xlf:login.link'
	];

..  versionadded:: 11.5
    The option :php:`iconIdentifier` has been introduced. As FontAwesome will
    be phased out developers are encouraged to use this option instead of
    :php:`icon-class`, which expects a FontAwesome class.

The settings are defined as:

:php:`provider`
    The login provider class name, which must implement
    :php:`TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface`.
:php:`sorting`
    The sorting is important for the ordering of the links to the possible
    login providers on the login screen.
:php:`iconIdentifier`
    Accepts any icon identifier that is available in the Icon Registry.
:php:`label`
    The label for the login provider link on the login screen.

For a new login provider you have to register a **new key** - by best practice
the current unix timestamp - in
:php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders']`.

If your login provider extends another one, you may only overwrite necessary
settings. An example would be to extend an existing provider and
replace its registered :php:`provider` class with your custom class.

..  code-block:: php
    :caption: config/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416020]['provider'] =
        \Vendor\MyExtension\LoginProvider\CustomProviderExtendingUsernamePasswordLoginProvider::class

LoginProviderInterface
======================

The LoginProviderInterface contains only one method:

..  include:: /CodeSnippets/Backend/LoginProviderInterface.rst.txt


The View
========

As mentioned above, the `render` method gets the Fluid StandaloneView as first parameter.
You have to set the template path and filename using the methods of this object.
The template file must only contain the form fields, not the form-tag.
Later on, the view renders the complete login screen.

View requirements:

*   The template must use the `Login`-layout provided by the Core `<f:layout name="Login">`.
*   Form fields must be provided within the section `<f:section name="loginFormFields">`.

..  code-block:: html
    :caption: EXT:my_sitepackage/Resources/Private/Templates/MyLoginForm.html

	<f:layout name="Login" />
	<f:section name="loginFormFields">
		<div class="form-group t3js-login-openid-section" id="t3-login-openid_url-section">
			<div class="input-group">
				<input type="text" id="openid_url" name="openid_url" value="{presetOpenId}" autofocus="autofocus" placeholder="{f:translate(key: 'openId', extensionName: 'openid')}" class="form-control input-login t3js-clearable t3js-login-openid-field" />
				<div class="input-group-addon">
					<span class="fa fa-openid"></span>
				</div>
			</div>
		</div>
	</f:section>


Examples
========

Within the Core you can find the standard implementation in the system extension
`backend`:

See class :php:`TYPO3\CMS\Backend\LoginProvider\UsernamePasswordLoginProvider`
with its template :file:`typo3/sysext/backend/Resources/Private/Templates/Login/UserPassLoginForm.html`.
