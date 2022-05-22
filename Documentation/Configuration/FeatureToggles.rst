.. include:: /Includes.rst.txt
.. index::
   Feature toggles
   TYPO3_CONF_VARS; SYS features
.. _feature-toggles:

===============
Feature toggles
===============

TYPO3 provides an API class for creating so-called 'feature toggles'. Feature toggles provide an easy way to add
new implementations of features next to their legacy version. By using a feature toggle, the integrator or site admin
can decide when to switch to the new feature.

The API checks against a system-wide option array within :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']` which an integrator
or admin can set in the :file:`LocalConfiguration.php` file.
Both TYPO3 Core and Extensions can provide alternative functionality for a certain feature.

Examples for features are:

- Throw exceptions in new code instead of just returning a string message as error message.
- Disable obsolete functionality which might still be used, but slows down the system.
- Enable alternative PageNotFound handling for an installation.

Naming of feature toggles
=========================

Feature names should NEVER be named "enable" or have a negation, or contain versions or years.
It is recommended to use `lowerCamelCase` notation for the feature names.

Bad examples:

- `enableFeatureXyz`
- `disableOverlays`
- `schedulerRevamped2018`
- `useDoctrineQueries`
- `disablePreparedStatements`
- `disableHooksInFE`

Good examples:

- `extendedRichtextFormat`
- `nativeYamlParser`
- `inlinePageTranslations`
- `typoScriptParserIncludesAsXml`
- `nativeDoctrineQueries`

.. _feature-toggles-api:

Using the API as extension author
=================================

For extension authors, the API can be used for any custom feature provided by an extension.

To register a feature and set the default state, add the following to the
:file:`ext_localconf.php`: of your extension:

.. code-block:: php
   :caption: EXT:some_extension/ext_localconf.php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['myFeatureName'] ??= true; // or false;

To check if a feature is enabled use this code:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Configuration\Features;

   if (GeneralUtility::makeInstance(Features::class)->isFeatureEnabled('myFeatureName')) {
      // do custom processing
   }

.. attention::

   Currently, only the Core features can be (de-)activated in the Install Tool.

   To change the setting for your extension feature either use :file:`Localconfiguration.php`:
   or :file:`AdditionalConfiguration.php`: like

   .. code-block:: php
      :caption: typo3conf/AdditionalConfiguration.php

      $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['myFeatureName'] = true;

The name can be any arbitrary string, but an extension author should prefix the feature with the
extension name as the features are global switches which otherwise might lead to naming conflicts.

.. _feature-toggles-core:

Core feature toggles
====================

Some examples for feature toggles in the TYPO3 Core:

- `redirects.hitCount`: Enables hit statistics in the redirects backend module
- `typoScript.strictSyntax`: If on, TypoScript is parsed in strict syntax modes.
  Enabling this feature means old condition syntax (which is deprecated) will
  trigger deprecation messages.

.. _feature-toggles-enable:

Enable / disable feature toggle
===============================

Features can be toggled in the *Settings* module via *Feature Toggles*:

.. include:: /Images/AutomaticScreenshots/AdminTools/FeatureToggles.rst.txt

Internally, the changes are written to :file:`LocalConfiguration.php`:

.. code-block:: php
   :caption: typo3conf/LocalConfiguration.php

   'SYS' => [
      'features' => [
         'redirects.hitCount' => true,
      ],
   ]

Feature toggles in TypoScript
===============================

To check whether a feature is enabled in TypoScript was introduced in v9.5 in :issue:`86881`

Support for feature toggle check in the symfony expression language DefaultFunctionProvider is provided.
With the new function :typoscript:`feature()` the feature toggle can be checked.


.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

   [feature("unifiedPageTranslationHandling")]
   # This condition matches if the feature toggle "unifiedPageTranslationHandling" is true
   [END]

   [feature("unifiedPageTranslationHandling") === false]
   # This condition matches if the feature toggle "unifiedPageTranslationHandling" is false
   [END]

