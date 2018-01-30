.. include:: ../../Includes.txt



.. _feature-toggles:

Feature Toggles
===============

TYPO3 provides an API class for creating so-called `Feature Toggles`. Feature toggles provide an easy way to add
new implementations of features next to their legacy version. By using a feature toggle, the integrator or site admin
can decide when to switch to the new feature.

The API checks against a system-wide option array within :php:`$TYPO3_CONF_VARS['SYS']['features']` which an integrator
or admin can set in the :file:`LocalConfiguration.php` file.
Both TYPO3 Core and Extensions can provide alternative functionality for a certain feature.

Examples for features are:

 - Throw exceptions in new code instead of just returning a string message as error message.
 - Disable obsolete functionality which might still be used, but slows down the system.
 - Enable alternative PageNotFound handling for an installation.

Naming of Feature Toggles
-------------------------

Feature names should NEVER be named "enable" or have a negation, or contain versions or years.

Bad examples: 

 - `enableFeatureXyz`
 - `disableOverlays`
 - `schedulerRevamped2018`
 - `useDoctrineQueries`
 - `disablePreparedStatements`
 - `disableHooksInFE`

Good examples:

 - `ExtendedRichtextFormat`
 - `NativeYamlParser`
 - `InlinePageTranslations`
 - `TypoScriptParserIncludesAsXml`
 - `NativeDoctrineQueries`


Using the API as extension author
---------------------------------

For extension authors, the API can be used for any custom feature provided by an extension:

.. code-block:: php

	if (GeneralUtility::makeInstance(Features::class)->isFeatureEnabled('myFeatureName')) {
		// do custom processing
	}

The name can be any arbitrary string, but an extension author should prefix the feature with the
extension name as the features are global switches which otherwise might lead to naming conflicts.

Core Feature Toggles
--------------------

The following feature toggles currently exist in the TYPO3 Core:

 - `redirects.hitCount`: Enables hit statistics in the redirects backend module


Enable Feature Toggle - Example
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Add the following snippet in your :file:`LocalConfiguration.php`:

.. code-block:: php

	'SYS' => [
		'features' => [
			'redirects.hitCount' => true,
		],
	]

