:navigation-title: LoginProvider

..  include:: /Includes.rst.txt

..  _login-provider:

======================
Backend login form API
======================

..  _login-provider-registration:

Registering a login provider
============================

The concept of the backend login is based on "login providers".

A login provider can be registered within your :file:`config/system/settings.php`
or :file:`config/system/additional.php`  like this:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416020] = [
        'provider' => \MyVendor\MyExtension\LoginProvider\CustomLoginProvider::class,
        'sorting' => 50,
        'iconIdentifier' => 'actions-key',
        'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang.xlf:login.link'
    ];

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
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416020]['provider'] =
        \MyVendor\MyExtension\LoginProvider\CustomProviderExtendingUsernamePasswordLoginProvider::class

..  _login-provider-interface:

LoginProviderInterface
======================

..  deprecated:: 13.3
    Method :php:`LoginProviderInterface->render()` has been marked as deprecated
    and is substituted by  :php:`LoginProviderInterface->modifyView()` that will
    be added to the interface in TYPO3 v14, removing :php:`render()` from the
    interface in v14. See section :ref:`login-provider-interface-migration`.

The :php-short:`TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface` contains
only the deprecated `render()` method in TYPO3 v13.

..  include:: /CodeSnippets/Backend/LoginProviderInterface.rst.txt

..  _login-provider-interface-migration:

Migration
---------

Consumers of :php-short:`\TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface`
should implement the :php:`modifyView()` method and and retain a stub for the
:php:`render()` method to satisfy the interface. See the example below.

The transition should be smooth. Consumers that need
:php:`\TYPO3\CMS\Core\Page\PageRenderer` for JavaScript magic, should use
:ref:`dependency injection <dependency-injection>` to receive an instance
of it.

An implementation of :php-short:`\TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface` could
look like this for TYPO3 v13:

..  literalinclude:: _LoginProvider/_MyLoginProvider.php
    :caption: EXT:my_extension/Classes/Login/MyLoginProvider.php
    :linenos:

The default implementation in :php-short:`\TYPO3\CMS\Backend\LoginProvider\UsernamePasswordLoginProvider`
is a good example. Extensions that need to configure additional template, layout or
partial lookup paths can extend them, see lines 23-28 in the example above.

Consumers of :php-short:`\TYPO3\CMS\Backend\LoginProvider\Event\ModifyPageLayoutOnLoginProviderSelectionEvent`
should use the request instead, and/or should get an instance of
:php-short:`\TYPO3\CMS\Core\Page\PageRenderer` injected as well.

..  _login-provider-view:

The view
========

..  deprecated:: 13.3
    Method :php:`LoginProviderInterface->render()` has been marked as deprecated
    and is substituted by  :php:`LoginProviderInterface->modifyView()` that will
    be added to the interface in TYPO3 v14, removing :php:`render()` from the
    interface in v14. See section :ref:`login-provider-interface-migration`.

The name of the template must be returned by the `modifyView()` method of the
login provider. Variables can be assigned to the view supplied as
second parameter.

The template file must only contain the form fields, not the form-tag.
Later on, the view renders the complete login screen.

View requirements:

*   The template must use the `Login`-layout provided by the
    Core `<f:layout name="Login">`.
*   Form fields must be provided within the section
    `<f:section name="loginFormFields">`.

..  literalinclude:: _LoginProvider/_MyLoginForm.html
    :caption: EXT:my_sitepackage/Resources/Private/Templates/MyLoginForm.html

..  _login-provider-examples:

Examples
========

Within the Core you can find the standard implementation in the system extension
`backend`:

See class :t3src:`backend/Classes/LoginProvider/UsernamePasswordLoginProvider.php`
with its template :t3src:`backend/Resources/Private/Templates/Login/UserPassLoginForm.html`.
