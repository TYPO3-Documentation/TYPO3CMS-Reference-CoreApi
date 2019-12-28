.. include:: ../../Includes.txt


.. _backend-routing:

===============
Backend Routing
===============

Each request to the backend is eventually executed by a controller.
A list of routes is defined which maps a given request to a controller
and an action.

Routes are defined inside extensions, in file :file:`Configuration/Backend/Routes.php`
for general requests and in  :file:`Configuration/Backend/AjaxRoutes.php` for
AJAX calls.

Here is an extract of :file:`typo3/sysext/backend/Configuration/Backend/Routes.php`:

.. code-block:: php

	<?php
	use TYPO3\CMS\Backend\Controller;

	/**
	 * Definitions for routes provided by EXT:backend
	 * Contains all "regular" routes for entry points
	 *
	 * Please note that this setup is preliminary until all core use-cases are set up here.
	 * Especially some more properties regarding modules will be added until TYPO3 CMS 7 LTS, and might change.
	 *
	 * Currently the "access" property is only used so no token creation + validation is made,
	 * but will be extended further.
	 */
	return [
		// Login screen of the TYPO3 Backend
		'login' => [
			'path' => '/login',
			'access' => 'public',
			'target' => Controller\LoginController::class . '::formAction',
		],

		// Main backend rendering setup (previously called backend.php) for the TYPO3 Backend
		'main' => [
			'path' => '/main',
			'target' => Controller\BackendController::class . '::mainAction',
		],
		// ...
	];

So a routes file essentially returns an array containing routes mapping.
A route is defined by a key, a path and a target. The "public" :code:`access`
property indicates that no authentication is required for that action.

Default Route Parameters
========================

Routes definitions are extended by the possibility to define default parameters.
Those parameters can be overridden during the regular URI generation process.

Several AJAX routes inhibited the backend session update to not keep the session
alive by periodic polling. Those :php:`skipSessionUpdate` parameters have been removed
from the specific URI generation invocations and moved to the central route definitions.

Default route parameters are defined in an associative key-value-array using the
index :php:`parameters`. This definition can be used for both, plain routes and AJAX routes.

.. code-block:: php

    'systeminformation_render' => [
        'path' => '/system-information/render',
        'target' => \TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem::class . '::renderMenuAction',
        'parameters' => [
            'skipSessionUpdate' => 1
        ]
    ]

More Information
================

Please refer to the following external resources and look at how the TYPO3 source code
handles backend routing in your TYPO3 version.

* `Scripting-Base: "PSR-7 for backend modules" <https://scripting-base.de/blog/psr-7-for-backend-modules>`__
* `Scripting-Base: "AJAX with PSR-7" <https://scripting-base.de/blog/ajax-with-psr-7.html>`__
* `PSR-7 <https://www.php-fig.org/psr/psr-7/>`__
* TYPO3 core: `backend : AjaxRoutes.php <https://github.com/TYPO3/TYPO3.CMS/blob/9.5/typo3/sysext/backend/Configuration/Backend/AjaxRoutes.php>`__ (GitHub)
* TYPO3 core: `backend : Routes.php <https://github.com/TYPO3/TYPO3.CMS/blob/9.5/typo3/sysext/backend/Configuration/Backend/Routes.php>`__ (GitHub)