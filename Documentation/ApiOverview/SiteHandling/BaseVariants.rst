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

..  confval:: typo3.version

    :type: string
    :Example: `11.5.24`

    The current TYPO3 version.

..  confval:: typo3.branch

    :type: string
    :Example: `11.5`

    The current TYPO3 branch.

..  confval:: typo3.devIpMask

    :type: string
    :Example: `203.0.113.*`

    The configured devIpMask taken from
    :ref:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] <typo3ConfVars_sys_devIPmask>`.

..  confval:: applicationContext

    :type: string
    :Example: `Development`

    The current :ref:`application context <application-context>`.


.. index::
   Site handling; Base variant functions
   DefaultFunctionsProvider

Functions
=========

All functions from
:t3src:`core/Classes/ExpressionLanguage/FunctionsProvider/DefaultFunctionsProvider.php`
are available:

..  confval:: ip

    :type: string
    :Example: `ip("203.0.113.*")`

    Match an IP address, value or regex, wildcards possible.
    Special value: `devIp` for matching `devIpMask`.

..  confval:: compatVersion

    :type: string
    :Example: `compatVersion("11.5.24")`, `compatVersion("11.5")`

    Match a TYPO3 version.

..  confval:: like

    :type: string
    :Example: `like("foobarbaz", "*bar*")`

    A comparison function to compare two strings. The first parameter is the
    "haystack", the second the "needle". Wildcards are allowed.

..  confval:: getenv

    :type: string
    :Example: `getenv("TYPO3_BASE_URL")`

    A wrapper for PHPs `getenv()`_ function. It allows accessing environment
    variables.

    ..  _getenv(): https://www.php.net/manual/en/function.getenv.php

..  confval:: date

    :type: string
    :Example: checking the current month: `date("j") == 7`

    Get the current date in given format.

..  confval:: feature

    :type: string
    :Example: `feature("redirects.hitCount")`

    Check whether a feature (":ref:`feature toggle <feature-toggles>`") is
    enabled in TYPO3.

..  confval:: traverse

    :type: array|string
    :Example: `traverse(request.getQueryParams(), 'tx_news_pi1/news') > 0`

    This function has two parameters:

    *   first parameter is the array to traverse
    *   second parameter is the path to traverse
