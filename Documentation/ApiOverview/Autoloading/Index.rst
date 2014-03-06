.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _autoload:

Autoloading
-----------

The autoloader takes care of finding classes in TYPO3. It is closely related to
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` which takes care of singleton
and :ref:`XCLASS <xclasses>` handling.

As a developer you should always instantiate classes either through
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` or with the Extbase
:ref:`ObjectManager <t3cmsapi:TYPO3\\CMS\\Extbase\\Object\\ObjectManager>`
(which internally uses :code:`makeInstance()` again).

.. important::

   Since TYPO3 CMS 6.0 and the introduction of namespaces, developers are strongly encouraged
   to use the namespaces. When using namespaces it is not necessary to explicitely declare
   classes in an autoloader files. All namespaced classes are automatically autoloaded.

   Please refer to the :ref:`namespaces` chapter for more information.


.. _autoload-autoloader:

Naming convention or autoloader file
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In TYPO3 every class must reside in its own file, i.e. there should be only
one class per PHP file. Extensions must not use :code:`require()` or :code:`include()`
to load class files, but instead use the TYPO3 core API to automatically require a file
upon request of the class.

A developer has two options to help the core find a specific class:

- Use the class naming convention and file location.

- Register a class name together with its location in an :code:`ext_autoload.php` file.

If this is not possible - for whatever reason - or if you don't want to use namespaces,
you can add a file to your extension called :file:`ext_autoload.php`, in the base directory.
Its goal is to inform the autoloader about the location of each class files. The autoloader
automatically searches for this file when a class is requested.

The :file:`ext_autoload.php` file must simply return a one-dimensional array
with the class name as key, and the file location as value. No other code is allowed in this file.


.. _autoload-examples:

Examples
^^^^^^^^

The examples below are related to non-namespaced classes. When using :ref:`namespaces <namespaces>`,
autoloading will happen without any extra effort on your part.


.. _autoload-examples-extbase:

Extbase conventions
"""""""""""""""""""

Consider the following:

- Extension name: :code:`my_extension`

- Extension location: :code:`typo3conf/ext/my_extension`

- Class name: :code:`Tx_MyExtension_Utility_FooBar`

- Required file location: :code:`typo3conf/ext/my_extension/Classes/Utility/FooBar.php`

which respects the following rules:

- The class name must start with :code:`Tx_`

- In the extension name underscores are converted to upper camel case, hence :code:`MyExtension`

- Every underscore after the extension name in the class name is resolved to a uppercases folder name
  below the :file:`Classes` directory, i.e. :code:`"_utility"` becomes folder :code:`"Utility"`

- The last part of the class name resolves to the file name with suffix :code:`.php`


.. _autoload-examples-no-conventions:

No conventions
""""""""""""""

For a file which doesn't follow any particular conventions, an entry must be
created in the extension's :file:`ext_autoload.php` file.

Example taken from an oldish version of extension "news"::

	<?php
	$extensionClassesPath = t3lib_extMgm::extPath('news') . 'Classes/';

	$default = array(
		'tx_news_domain_model_dto_emconfiguration' => $extensionClassesPath . 'Domain/Model/Dto/EmConfiguration.php',
		'tx_news_hooks_suggestreceiver' => $extensionClassesPath . 'Hooks/SuggestReceiver.php',
		'tx_news_hooks_suggestreceivercall' => $extensionClassesPath . 'Hooks/SuggestReceiverCall.php',
		'tx_news_utility_compatibility' => $extensionClassesPath . 'Utility/Compatibility.php',
		'tx_news_utility_importjob' => $extensionClassesPath . 'Utility/ImportJob.php',
		'tx_news_utility_emconfiguration' => $extensionClassesPath . 'Utility/EmConfiguration.php',
		'tx_news_service_cacheservice' => $extensionClassesPath . 'Service/CacheService.php',
	);
	return $default;
	?>

.. note::

   The class names used as keys in the array must be in lower case, until TYPO3 4.7.
   This limitation was removed in TYPO3 6.0.
