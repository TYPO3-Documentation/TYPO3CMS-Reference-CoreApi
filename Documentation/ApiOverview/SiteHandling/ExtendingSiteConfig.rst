..  include:: /Includes.rst.txt
..  index:: Site handling; Extending
..  _sitehandling-extendingSiteConfiguration:

============================
Extending site configuration
============================


..  index:: Site handling; Custom options

Adding custom / project-specific options to site configuration
==============================================================

The site configuration is stored as YAML and provides per definition a
context-independent configuration of a site. Especially when it comes to
things like storage PIDs or general site-specific settings, it makes sense to
add them to the site configuration.

..  note::
    In "the old days" these kind of options were commonly stored in TypoScript,
    page TSconfig or :php:`LocalConfiguration.php`, all three being in some
    ways a bit unfortunate - parsing TypoScript while on CLI or using TSconfig
    made for the backend in frontend was no fun.

The :ref:`site entity <sitehandling-site-object>` automatically provides the
complete configuration via the :php:`getConfiguration()` method, therefore
extending that means "just add whatever you want to the YAML file". The GUI is
built in a way that toplevel options that are unknown or not available in the
form are left alone and will not get overwritten when saved.

Example:

..  literalinclude:: _extending-site-config.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

Access it via the API:

..  code-block:: php

    $site->getConfiguration()['myProject']['recordStorage']


.. index:: Site handling; Extending the Form

Extending the form / GUI
========================

Extending the GUI is a bit more tricky.

The backend module relies on :ref:`form engine <FormEngine>` to render the edit
interface. Since the form data is not stored in database records but in
YAML files, a couple of details have been extended of the default form engine
code.

The render configuration is stored in :t3src:`backend/Configuration/SiteConfiguration/`
in a format syntactically identical to TCA. However, this is **not** loaded into
:php:`$GLOBALS['TCA']` scope, and only a small subset of TCA features is
supported.

..  attention::
    **Extending site configuration is experimental** and may change any time.

In practice, the configuration can be extended, but only with very simple fields
like the basic config type :php:`input`, and even for this one not all features
are possible, for example the :php:`eval` options are limited. The code throws
exceptions or just ignores settings it does not support. While some of the
limits may be relaxed a bit over time, many will be kept. The goal is to allow
developers to extend the site configuration with a couple of simple things like
an input field for a Google API key. However it is **not possible to extend with
complex TCA** like inline relations, database driven select fields, FlexForm
handling and similar.

The example below shows the experimental feature adding a field to site in an
extension's :file:`Configuration/SiteConfiguration/Overrides/sites.php` file.
Note the helper methods of class
:php:`TYPO3\CMS\core\Utility\ExtensionManagementUtility` can not be used.

..  literalinclude:: _extending-site-config.php
    :caption: EXT:my_extension/Configuration/SiteConfiguration/Overrides/sites.php

The field will be shown in the edit form of the configuration module and its
value stored in the :file:`config.yaml` file. Using the site object
:php:`\TYPO3\CMS\core\Site\Entity\Site`, the value can be fetched using
:php:`->getConfiguration()['myNewField']`.
