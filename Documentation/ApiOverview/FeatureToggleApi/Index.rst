..  include:: /Includes.rst.txt
..  index::
    Feature toggles
    TYPO3_CONF_VARS; SYS features
..  _feature-toggles:

==================
Feature toggle API
==================

TYPO3 provides an API class for creating so-called "feature toggles". Feature
toggles provide an easy way to add new implementations of features next to their
legacy version. By using a feature toggle, the integrator or site administrator
can decide when to switch to the new feature.

The API checks against a system-wide option array within
:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']` which an integrator or
admininistrator can set in the :file:`config/system/settings.php` file. Both
TYPO3 Core and extensions can provide alternative functionality for a certain
feature.

Examples for features are:

-   Throw exceptions in new code instead of just returning a string message as
    error message.
-   Disable obsolete functionality which might still be used, but slows down the
    system.
-   Enable alternative "page not found" handling for an installation.


.. contents:: **Table of Contents**
   :depth: 1
   :local:


Naming of feature toggles
=========================

Feature names should NEVER be named "enable" or have a negation, or contain
versions or years. It is recommended to use "lowerCamelCase" notation for the
feature names.

Bad examples:

-   `enableFeatureXyz`
-   `disableOverlays`
-   `schedulerRevamped2018`
-   `useDoctrineQueries`
-   `disablePreparedStatements`
-   `disableHooksInFE`

Good examples:

-   `extendedRichtextFormat`
-   `nativeYamlParser`
-   `inlinePageTranslations`
-   `typoScriptParserIncludesAsXml`
-   `nativeDoctrineQueries`

..  _feature-toggles-api:

Using the API as extension author
=================================

For extension authors, the API can be used for any custom feature provided by an
extension.

To register a feature and set the default state, add the following to the
:file:`ext_localconf.php` file of your extension:

..  code-block:: php
    :caption: EXT:some_extension/ext_localconf.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['myFeatureName'] ??= true; // or false;

To check if a feature is enabled, use this code:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Configuration\Features;

    final class SomeClass {
        public function __construct(
            private readonly Features $features,
        ) {
        }

        public function doSomething(): void
        {
            if ($this->features->isFeatureEnabled('myFeatureName') {
                // do custom processing
            }

            // ...
        }
    }

..  attention::
    Currently, only the Core features can be (de-)activated in the Install Tool.

    To change the setting for your extension feature either use
    :file:`config/system/settings.php` or :file:`config/system/additional.php`
    files like:

    .. code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['myFeatureName'] = true;

The name can be any arbitrary string, but an extension author should prefix the
feature with the extension name as the features are global switches which
otherwise might lead to naming conflicts.

.. _feature-toggles-core:

Core feature toggles
====================

Some examples of feature toggles in the TYPO3 Core:

-   `redirects.hitCount`: Enables hit statistics in the redirects backend module
-   `security.backend.enforceReferrer`: If on, HTTP referrer headers are enforced
    for backend and install tool requests to mitigate potential same-site
    request forgery attacks.
..  versionadded:: 14.2
-   `extbase.enableHistoryTracking`: Enables tracking of history for Extbase
    domain entities by listening to Extbase persistence events and storing them
    in the :sql:`sys_history` table. If enabled, it is enabled for all extbase
    entities but can be disabled for individual extbase storage tables in the
    their TCA:

..  code-block:: php
    :emphasize-lines: 11-13
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_blog.php

    <?php
    declare(strict_types=1);
    return [
        'ctrl' => [
            'title' => 'my_extension.messages:my_title',
            'label' => 'uid',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'delete' => 'deleted',
            // ...
            'extbase' => [
                'enableHistoryTracking' => false
            ],
        ],
        'columns' => [
            // ...
        ],
    ];

..  note::

    Enabling history tracking can create many history entries
    for extbase entities. They will also be mixed with regular editorial
    changes to extbase entities performed in the TYPO3 backend (FormEngine).

..  important::

    All differences to data in extbase entities are now logged, and the initial
    logging will contain all properties. Take note that this can affect
    GDPR / DSGVO / security-related data storage precautions, and data might need to be
    regularly pruned. It might be advisable to turn off history tracking for
    tables with "private" data. Because of this, the feature toggle
    is set to "false" by default, so an instance-wide opt-in for this is required.

..  _feature-toggles-enable:

Enable / disable feature toggle
===============================

Features can be toggled in the :guilabel:`System > Settings` module via
:guilabel:`Feature Toggles`:

..  figure:: /Images/ManualScreenshots/AdminTools/FeatureToggles.png
    :alt: Feature toggles in module System > Settings

Internally, the changes are written to :file:`config/system/settings.php`:

..  code-block:: php
    :caption: config/system/settings.php

    'SYS' => [
        'features' => [
            'redirects.hitCount' => true,
        ],
    ]

..  note::
    If the :file:`config/system/settings.php` file is write-protected an info
    box is rendered. In that case, all input fields are disabled and the save
    button is not available.

Feature toggles in TypoScript
=============================

One can check whether a feature is enabled in TypoScript with the function
:typoscript:`feature()`:

..  code-block:: typoscript
    :caption: EXT:some_extension/Configuration/TypoScript/setup.typoscript

    [feature("unifiedPageTranslationHandling")]
        # This condition matches if the feature toggle "unifiedPageTranslationHandling" is true
    [END]

..  _feature-toggles-viewhelper:

Feature toggles in Fluid
========================

..  versionadded:: 13.2
    A new condition-based Fluid ViewHelper was added. It allows
    integrators to check for feature flags from within Fluid templates.

The :ref:`t3viewhelper:typo3-fluid-feature` can be used to check for a feature in a Fluid
template:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:feature name="unifiedPageTranslationHandling">
       This is being shown if the flag is enabled
    </f:feature>
