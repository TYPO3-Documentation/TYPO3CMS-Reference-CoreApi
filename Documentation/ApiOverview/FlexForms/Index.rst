:navigation-title: FlexForms

..  include:: /Includes.rst.txt
..  index:: FlexForms
..  _flexforms:

=========
FlexForms
=========

FlexForms can be used to store data within an XML structure inside a single DB
column.

..  attention::
    ..  versionchanged:: 13.0
        The superfluous tag :xml:`TCEforms` was removed and is not evaluated
        anymore. All :xml:`TCEforms` tags **must** be removed. Otherwise the
        FlexForm is displayed broken in the backend records.

..  contents::

..  toctree::
    :titlesonly:
    :glob:

    Definition/Index
    Reading/Index
    Modify/Index
    T3datastructure/Index

..  _flexforms-extbase-plugin:

Extbase plugin settings as FlexForm
===================================

FlexForms are commonly used to configure Extbase plugins:

..  literalinclude:: _codesnippets/_extbase_plugin.php
    :caption: packages/my_extension/Configuration/TCA/Overrides/tt_content.php

Within the FlexForm use `settings.` as prefix for the identifier of your
fields. Any field prefixed with `settings.` will be automatically available
in the controller's settings array (`$this->settings['someSetting']`) and
in the Fluid templates as variable `{settings.someSetting}`. For example:

..  literalinclude:: _codesnippets/_ExtbaseFlexForm.xml
    :caption: packages/my_extension/Configuration/FlexForm.xml

For an example see the plugin settings of the plugins in extension
:composer:`georgringer/news`.

Plain plugins configured by FlexForms
=====================================

Complex content elements or plain plugins not registered via Extbase can
use FlexForms for configuration as well. Plain plugins can be configured with
FlexForms in a similar fashion to Extbase plugins:

..  literalinclude:: _codesnippets/_plain_plugin.php
    :caption: packages/my_extension/Configuration/TCA/Overrides/tt_content.php

Plain plugins can use any name scheme for the identifiers that they desire.

When a content element containing a FlexForm is saved the settings are written
as XML to column `tt_content.pi_flexform` in the according database record.

See also: `Read FlexForms values in PHP <https://docs.typo3.org/permalink/t3coreapi:read-flexforms-php>`_.

For example the carousel of the extension :composer:`bk2k/bootstrap-package`
uses FlexForms for its configuration.
