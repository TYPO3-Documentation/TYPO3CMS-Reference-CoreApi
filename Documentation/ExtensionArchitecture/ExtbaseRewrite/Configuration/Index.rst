:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Configuration
..  _extbase-configuration:

=====================================
Configure Extbase plugins and modules
=====================================

To configure Extbase plugins or backend modules several points can play into the final result.
Several distinct surfaces exists, each owned by a
different role and each suited to a different kind of value: the framework
settings that tell Extbase where to find templates and records, the
application settings you read in your own controllers and templates, the values
an editor sets per content element, and a few installation-wide behaviour
switches.

This chapter explains each surface, what belongs in it, and how the surfaces
combine into the final configuration your code sees.

..  _extbase-configuration-surfaces:

The configuration surfaces of an Extbase extension
==================================================

:ref:`TypoScript <extbase-configuration-typoscript-scopes>`
    The primary surface. Both the framework settings Extbase reads itself
    (template paths, storage pages, error handling) and your own
    application-specific :typoscript:`settings` live below
    :typoscript:`plugin.tx_<extensionkey>` for plugins and
    :typoscript:`module.tx_<extensionkey>` for
    :ref:`backend modules <extbase-registration-backend-module>`. This is where
    most configuration work happens — see the
    :ref:`configuration reference <extbase-configuration-reference>`.

:ref:`FlexForm <t3coreapi:flexforms>`
    Per-content-element configuration that an editor sets in the backend. A
    FlexForm field named :samp:`settings.<name>` is merged straight into
    :php:`$this->settings`, so editors can override individual TypoScript
    settings on a single content element without touching code. See
    :ref:`extbase-configuration-typoscript-settings` for the merge into
    :php:`$this->settings`.

:ref:`Site settings <sitehandling-settings>`
    Installation- or site-wide values, defined by a
    :ref:`site set <t3coreapi:site-sets>` and editable per site in the backend.
    Site settings are the recommended way to ship configuration that an
    integrator should be able to adjust without editing TypoScript; they are
    referenced from TypoScript through
    :ref:`settings placeholders <sitehandling-settings-access-typoscript>`
    and so feed into the same :typoscript:`plugin.tx_<extensionkey>` tree.

:ref:`Feature toggles <feature-toggles>`
    A small number of Extbase behaviours are switched installation-wide rather
    than per plugin — for example consistent :php:`\DateTime` handling and
    record-history tracking. These are not TypoScript; they live in
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']`. See
    :ref:`extbase-configuration-feature-toggles`.

:file:`Configuration/Extbase/Persistence/Classes.php`
    The class-mapping surface. A domain model maps to a table or columns
    that do not follow Extbase's naming conventions — for example reusing an
    existing table such as :sql:`fe_users` — this PHP file maps the class and
    its properties to the real names. It configures persistence rather than
    runtime behaviour, so it is covered with the domain model: see
    :ref:`extbase-domain-model-mapping`.

..  _extbase-configuration-how-they-combine:

How the surfaces combine
========================

The first three surfaces are merged in a fixed
precedence order before your controller runs, so the same setting can be
declared in more than one place and the most specific value wins. From lowest
to highest precedence:

#.  Extension-wide TypoScript (:typoscript:`plugin.tx_<extensionkey>`), into
    which site settings feed through placeholders
#.  Plugin-specific TypoScript (:typoscript:`plugin.tx_<extensionkey>_<pluginname>`)
#.  FlexForm values set by the editor on the content element

The full rules — including how to stop an empty FlexForm field from wiping out
a TypoScript default — are explained in
:ref:`extbase-configuration-typoscript-scopes`.

Feature toggles sit outside this chain: they change framework behaviour for the
whole installation and are not part of the per-plugin merge.

..  tip::

    To inspect the *resolved* result rather than reasoning about the merge in
    your head, open the :guilabel:`Sites > TypoScript` backend module and use
    the :guilabel:`Active TypoScript` submodule. Browsing to
    :typoscript:`plugin.tx_<extensionkey>` there shows the final, merged
    configuration your plugin actually receives — TypoScript and site-settings
    placeholders included. FlexForm values, which are merged per content element
    at request time, are not visible here.

..  seealso::

    *   :ref:`extbase-configuration-reference` — the working reference for
        every configuration block an Extbase extension uses.

    *   `Site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_ —
        defining and reading site-wide configuration values.

    *   `Feature toggles <https://docs.typo3.org/permalink/t3coreapi:feature-toggles>`_
        — how installation-wide behaviour switches work.

With the configuration surfaces in mind, continue to the
:ref:`configuration reference <extbase-configuration-reference>` to see each
block in practice, then move on to :ref:`extbase-persistence-overview` and
:ref:`extbase-view-overview`, where these settings turn into queries and
rendered output.

..  toctree::
    :titlesonly:
    :hidden:

    Reference
