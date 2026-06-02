:navigation-title: Access Gates

.. include:: /Includes.rst.txt

.. _backend-module-access-gates:

===========================
Backend module access gates
===========================

..  versionadded:: 14.2
    Existing backend module registrations using the built-in access values continue
    to work without modification:

    * :php:`user`
    * :php:`admin`
    * :php:`systemMaintainer`

The TYPO3 backend module system supports configurable access control through
**module access gates**. Gates determine whether a backend user may access a
specific backend module.

TYPO3 provides built-in gates for common access strategies and allows extension
authors to register custom gates for project-specific requirements.

..  contents:: Table of contents

..  _backend-module-access-gates-built-in-gates:

Built-in access gates
=====================

TYPO3 ships the following built-in access gates:

*   :php:`\TYPO3\CMS\Backend\Module\AccessGate\UserGate`
    (`'access' => 'user'`)
*   :php:`\TYPO3\CMS\Backend\Module\AccessGate\AdminGate`
    (`'access' => 'admin'`)
*   :php:`\TYPO3\CMS\Backend\Module\AccessGate\SystemMaintainerGate`
    (`'access' => 'systemMaintainer'`)

These gates preserve the traditional backend module access behavior.

..  _backend-module-access-gates-user-gate:

UserGate
---------

The :php-short:`UserGate` grants access to:

* Backend administrators
* Backend users or groups with explicit module permissions configured in:

  * :sql:`be_users.userMods`
  * :sql:`be_groups.groupMods`

This corresponds to the module access value:

..  code-block:: php

    'access' => 'user',

..  _backend-module-access-gates-admin-gate:

AdminGate
----------

The :php-short:`AdminGate` grants access only to backend administrator users.

This corresponds to:

..  code-block:: php

    'access' => 'admin',

..  _backend-module-access-gates-system-maintainer-gate:

SystemMaintainerGate
--------------------

The :php-short:`SystemMaintainerGate` grants access only to system maintainers.

This corresponds to:

..  code-block:: php

    'access' => 'systemMaintainer',

..  _backend-module-access-gates-register-custom-gates:

Register a custom access gate
=============================

Extension authors can implement custom access strategies by creating a class
that implements
:php:`TYPO3\CMS\Backend\Module\ModuleAccessGateInterface`.

Custom gates are registered using the
:php:`#[AsModuleAccessGate]` PHP attribute.

The gate must return a
:php:`TYPO3\CMS\Backend\Module\ModuleAccessResult` value.

Possible results are:

* :php:`ModuleAccessResult::Granted`
* :php:`ModuleAccessResult::Denied`
* :php:`ModuleAccessResult::Abstain`

..  _backend-module-access-gates-example-editor-gate:

Example: Custom editor gate
---------------------------

..  include:: _AccessGate/_ExampleGate.rst.txt

The example above defines a custom access type called :php:`exampleUser`.

The gate only handles modules whose `access` option is set to
:php:`exampleUser`. For all other modules, it returns
:php:`ModuleAccessResult::Abstain`.

The gate accesses information about the currently authenticated backend user
through the
:php-short:`TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
object passed to the :php:`decide()` method.

This allows custom gates to implement project-specific permission logic based
on user groups, user TSconfig settings, workspace access, user preferences, or other
backend user properties.

After registering the gate, use its identifier in the module configuration.

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

    return [
        'my_module' => [
            'access' => 'exampleUser',
            'labels' => 'examples.module.content_examples_clipboard',
            // ...
        ],
    ];

..  _backend-module-access-gates-evaluation-order:

Gate evaluation order
=====================

Multiple gates can be registered simultaneously.

The `before` and `after` options of the
:php:`#[AsModuleAccessGate]` attribute define the evaluation order.

..  code-block:: php

    use TYPO3\CMS\Backend\Module\ModuleAccessGateInterface;
    use TYPO3\CMS\Core\Attribute\AsModuleAccessGate;

    #[AsModuleAccessGate(
        identifier: 'exampleUser',
        after: ['user'],
    )]
    final readonly class ExampleGate implements ModuleAccessGateInterface
    {
        // ...
    }
