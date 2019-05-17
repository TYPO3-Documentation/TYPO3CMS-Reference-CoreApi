.. include:: ../../Includes.txt

.. _sitehandling-extendingSiteConfiguration:

============================
Extending Site Configuration
============================


Adding Custom / Project Specific Options to Site Configuration
==============================================================

Site configuration is stored as yaml and provides per definition context independent configuration of
a site. Especially when thinking about things like storage PIDs or general site specific settings, it
makes sense to add them to the site configuration.

.. note::
    In "the old days" these kind of options were commonly stored in TypoScript or TSConfig or LocalConfiguration,
    all three being in some ways a bit unfortunate - parsing TypoScript while on CLI or using TSConfig made for
    the backend in frontend was no fun.

Adding project configuration to site configuration is easy: The site entity will automatically provide the
complete configuration via `getConfiguration()`, extending that means therefor "just add whatever you want to
the yaml file". The GUI is built in a way that toplevel options unknown / not available in the form will be
left alone and do not get overwritten when saving.

Example:

.. code-block:: yaml

    rootPageId: 1
    base: https://example.com
    myProject:
        recordStorage: 15

Access it via the API:

.. code-block:: php

    $site->getConfiguration()['myProject']['recordStorage']


Extending the Form / GUI
========================

Extending the GUI is a bit more tricky.

The backend module relies on FormEngine to render the edit interface. Since the form data is not stored in
database records but in :file:`.yml` files, a couple of details have been extended of the default FormEngine code.

The render configuration is stored in :file:`typo3/sysext/backend/Configuration/SiteConfiguration/` in a format
syntactically identical to TCA. However, this is **not** loaded into :php:`$GLOBALS['TCA']` scope, and only a small
subset of TCA features is supported.

**Extending site configuration is experimental** and may change any time.

In practice the configuration can be extended, but only with very simple fields like the basic config type :php:`input`,
and even for this one not all features are possible, for example the :php:`eval` options are limited. The code throws
exceptions or just ignores settings it does not support. While some of the limits may be relaxed a bit over time, many
will be kept. The goal is to allow developers to extend the site configuration with a couple of simple things like
an input field for a Google API key. However it is **not possible to extend with complex TCA** like inline relations,
database driven select fields, Flex Form handling and similar.

The example below shows the experimental feature adding a field to site in an extensions file
:file:`Configuration/SiteConfiguration/Overrides/sites.php`. Note the helper methods of class
:php:`TYPO3\CMS\core\Utility\ExtensionManagementUtility` can not be used.

.. code-block:: php

    <?php
    // Experimental example to add a new field to the site configuration

    // Configure a new simple required input field to site
    $GLOBALS['SiteConfiguration']['site']['columns']['myNewField'] = [
        'label' => 'A new custom field',
        'config' => [
            'type' => 'input',
            'eval' => 'required',
        ],
    ];
    // And add it to showitem
    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] = str_replace(
        'base,',
        'base, myNewField, ',
        $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem']
    );

The field will be shown in the edit form of the configuration module and it's value stored in the :file:`.yml`
file. Using the site object :php:`TYPO3\CMS\core\Site\Entity\Site`, the value can be fetched using
:php:`->getConfiguration()['myNewField']`.
