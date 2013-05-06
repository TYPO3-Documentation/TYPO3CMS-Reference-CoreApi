.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _bootstrapping:

Bootstrapping
-------------

TYPO3 CMS has a clean bootstrapping process driven mostly
by class :code:`\TYPO3\CMS\Core\Core\Bootstrap`. This class
contains a host of methods each responsible for a little
step along the initialization of a full TYPO3 process,
be it the backend or other contexts.

Some contexts add their own bootstrap class (like the command
line, which additionally requires :code:`\TYPO3\CMS\Core\Core\CliBootstrap`.

.. note::

   The frontend's bootstrapping process is not yet fully encapsulated
   in a bootstrap class.

.. warning::

   This boostrapping API is still young and may change in the future.
   It's fine to use it in an extension if you absolutely need it,
   but please be aware that there may be breaking changes at some point.


One can see the bootstrapping process in action in file
:file:`typo3/init.php`::

	define('TYPO3_MODE', 'BE');

	require 'sysext/core/Classes/Core/Bootstrap.php';

	\TYPO3\CMS\Core\Core\Bootstrap::getInstance()
		->baseSetup('typo3/')
		->startOutputBuffering()
		->loadConfigurationAndInitialize()
		->loadTypo3LoadedExtAndExtLocalconf(TRUE)
		->applyAdditionalConfigurationSettings()
		->initializeTypo3DbGlobal(FALSE)
		->checkLockedBackendAndRedirectOrDie()
		->checkBackendIpOrDie()
		->checkSslBackendAndRedirectIfNeeded()
		->redirectToInstallToolIfDatabaseCredentialsAreMissing()
		->checkValidBrowserOrDie()
		->establishDatabaseConnection()
		->loadExtensionTables(TRUE)
		->initializeSpriteManager()
		->initializeBackendUser()
		->initializeBackendUserMounts()
		->initializeLanguageObject()
		->initializeModuleMenuObject()
		->initializeBackendTemplate()
		->endOutputBufferingAndCleanPreviousOutput()
		->initializeOutputCompression();


Note that most methods of the Bootstrap class must be called in a precise order.
It is perfectly possible to define one's own bootstrapping process, but care
should be taken about the call order.

Also note that all bootstrapping methods return the instance of the
Bootstrap class itself, allowing calls to be chained.
