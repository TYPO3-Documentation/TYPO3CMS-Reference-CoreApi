..  include:: /Includes.rst.txt
..  index:: Site handling; Base variants
..  _sitehandling-baseVariants:

=============
Base variants
=============

In site handling, "base variants" represent different bases for a website
depending on a specified condition. For example, a "live" base URL might be
:samp:`https://example.org/`, but on a local machine it is
:samp:`https://example.localhost/` as a domain - that is when variants are used.

Base variants exist for languages, too. Currently, these can only be defined
through the respective :file:`*.yaml` file, there is no backend user interface
available yet.

Variants consist of two parts:

*   a base to use for this variant
*   a condition that decides when this variant shall be active

Conditions are based on `Symfony expression language`_ and allow flexible
conditions, for example:

..  code-block:: none

    applicationContext == "Development"

would define a base variant to use in "Development" context.

..  note::
    Environment variables can be used in the :yaml:`base` via ``%env(...)%``.
    :yaml:`condition` needs ``getenv(...)`` instead.

..  include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingBaseVariants-1.rst.txt

..  hint::
    For those coming from earlier TYPO3 versions: With site handling, there is
    no need for :sql:`sys_domain` records anymore!

..  seealso::
    *   Read :ref:`application-context` for more information on how to set the
        application context.
    *   Read :ref:`yaml-api` for more information on YAML parsing.

..  _Symfony expression language: https://symfony.com/doc/current/components/expression_language.html


The following variables and functions are available in addition to the default
Symfony functionality:

Example
=======

..  literalinclude:: _base-variants.yaml
    :language: yaml
    :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml


.. index:: Site handling; Base variant properties

Properties
==========

..  option:: typo3.version

    :type: string
    :Example: `13.4.0`

    The current TYPO3 version.

..  option:: typo3.branch

    :type: string
    :Example: `13.4`

    The current TYPO3 branch.

..  option:: typo3.devIpMask

    :type: string
    :Example: `203.0.113.*`

    The configured devIpMask taken from
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] <typo3ConfVars_sys_devIPmask>`.

..  option:: applicationContext

    :type: string
    :Example: `Development`

    The current :ref:`application context <application-context>`.


.. index::
   Site handling; Base variant functions
   DefaultFunctionsProvider

Functions
=========

Functions from
:t3src:`core/Classes/ExpressionLanguage/FunctionsProvider/DefaultFunctionsProvider.php`
are available, as long as they are request-independent (due to caching reasons). For
request-dependant conditions/functions, have a look at :composer:`b13/host-variants`
to see how to add custom condition/function providers to suit your needs.

That means, specifically you can **not** use the `ip()` or `traverse(request...)`
conditions in the handling of base variants.

Some examples:

..  option:: compatVersion

    :type: string
    :Example: `compatVersion("13.4.0")`, `compatVersion("12.4")`

    Match a TYPO3 version.

..  option:: like

    :type: string
    :Example: `like("foobarbaz", "*bar*")`

    A comparison function to compare two strings. The first parameter is the
    "haystack", the second the "needle". Wildcards are allowed.

..  option:: getenv

    :type: string
    :Example: `getenv("TYPO3_BASE_URL")`

    A wrapper for PHPs `getenv()`_ function. It allows accessing environment
    variables.

    ..  _getenv(): https://www.php.net/manual/en/function.getenv.php

..  option:: date

    :type: string
    :Example: checking the current month: `date("j") == 7`

    Get the current date in given format.

..  option:: feature

    :type: string
    :Example: `feature("redirects.hitCount")`

    Check whether a feature (":ref:`feature toggle <feature-toggles>`") is
    enabled in TYPO3.
