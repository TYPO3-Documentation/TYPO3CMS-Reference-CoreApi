:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Configuration
..  _extbase-configuration:

=====================================
Configure Extbase plugins and modules
=====================================

To configure Extbase plugins and backend modules there are several things that
need to be taken into account. Several distinct "surfaces" exist, each owned by a
different role and each suited to a different kind of value. These include: the framework
settings that tell Extbase where to find templates and records, the
application settings you read in your own controllers and templates, the values
an editor sets for each content element, and a few installation-wide behaviour
switches.

This chapter explains each surface, what belongs in it, and how the surfaces
are combined into the final configuration that your code sees.

..  _extbase-configuration-surfaces:

The configuration "surfaces" of an Extbase extension
====================================================

:ref:`TypoScript <extbase-configuration-typoscript-scopes>`
    The primary surface. Both the framework settings Extbase reads
    (template paths, storage pages, error handling) and your own
    application-specific :typoscript:`settings` are contained in
    :typoscript:`plugin.tx_<extensionkey>` for plugins and
    :typoscript:`module.tx_<extensionkey>` for
    :ref:`backend modules <extbase-registration-backend-module>`. This is where
    most configuration work happens — see the
    :ref:`configuration reference <extbase-configuration-reference>`.

:ref:`FlexForm <t3coreapi:flexforms>`
    Content element configuration that an editor sets in the backend. A
    FlexForm field named :samp:`settings.<name>` is merged straight into
    :php:`$this->settings`, meaning editors can override individual TypoScript
    settings in a single content element without having to touch any code. See
    :ref:`extbase-configuration-typoscript-settings` for how it is merged into
    :php:`$this->settings`.

:ref:`Site settings <sitehandling-settings>`
    Installation- and site-wide values, defined by a
    :ref:`site set <t3coreapi:site-sets>` and editable for each site in the backend.
    Site settings are the recommended way to ship configuration that can easily
    be modified by integrators without having to edit TypoScript; they are
    referenced from TypoScript through
    :ref:`settings placeholders <sitehandling-settings-access-typoscript>`
    and so feed into the same :typoscript:`plugin.tx_<extensionkey>` tree.

:ref:`Feature toggles <feature-toggles>`
    Some Extbase functionality can be switched on installation-wide rather
    than per plugin — for example consistent :php:`\DateTime` handling and
    record-history tracking. This is not done by TypoScript; it is set in
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']`. See
    :ref:`extbase-configuration-feature-toggles`.

:file:`Configuration/Extbase/Persistence/Classes.php`
    The class-mapping surface. A domain model maps to a table or columns
    that do not follow Extbase's naming conventions — for example reusing an
    existing table such as :sql:`fe_users` — this PHP file maps the class and
    its properties to the real names. It configures persistence rather than
    runtime behaviour, so it is covered by the domain model: see
    :ref:`extbase-domain-model-mapping`.

..  _extbase-configuration-how-they-combine:

How the surfaces combine
========================

The first three surfaces are merged in a fixed
order before your controller runs, so the same setting can be
declared in more than one place and the most specific value will take precedence.
The lowest to the highest precedence is as follows:

#.  Extension-wide TypoScript (:typoscript:`plugin.tx_<extensionkey>`), into
    which site settings feed through placeholders
#.  Plugin-specific TypoScript (:typoscript:`plugin.tx_<extensionkey>_<pluginname>`)
#.  FlexForm values set by the editor in a content element

The full rules — including how to stop an empty FlexForm field from overriding
a TypoScript default — are explained in
:ref:`extbase-configuration-typoscript-scopes`.

Feature toggles sit outside this chain: they change framework behaviour for the
whole installation and are not part of the per-plugin merge.

..  tip::

    To inspect the *resolved* result, open the :guilabel:`Sites > TypoScript`
    backend module and go to
    the :guilabel:`Active TypoScript` submodule. Browse to
    :typoscript:`plugin.tx_<extensionkey>` to see the final, merged
    configuration that your plugin actually receives — TypoScript and site-settings
    placeholders included. FlexForm values, which are merged per content element
    at request time, are not visible here.

..  seealso::

    *   :ref:`extbase-configuration-reference` — the reference guide for
        all the configuration blocks that are used in Extbase extensions.

    *   `Site settings <https://docs.typo3.org/permalink/t3coreapi:sitehandling-settings>`_ —
        defining and reading site-wide configuration values.

    *   `Feature toggles <https://docs.typo3.org/permalink/t3coreapi:feature-toggles>`_
        — how installation-wide behaviour switches work.

Now we have looked at configuration surfaces, continue to the
:ref:`configuration reference <extbase-configuration-reference>` to see how each
block is used in practice. Then move on to :ref:`extbase-persistence-overview` and
:ref:`extbase-view-overview`, where these settings are converted into queries and
rendered output.

..  toctree::
    :titlesonly:
    :hidden:

    Reference
