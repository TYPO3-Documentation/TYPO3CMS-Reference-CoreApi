.. include:: ../../Includes.txt


.. _backend-routing:

===============
Backend Routing
===============

.. note::

   This section was moved from :ref:`http`.

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

