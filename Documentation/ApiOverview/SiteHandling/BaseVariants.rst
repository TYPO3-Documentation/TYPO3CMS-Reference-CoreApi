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

..  figure:: /Images/ManualScreenshots/SiteHandling/SiteHandlingBaseVariants-1.png
    :zoom: lightbox

    A configured base variant for development context.

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
    :Example: `14.3.0`

    The current TYPO3 version.

..  option:: typo3.branch

    :type: string
    :Example: `14.3`

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

The functions provided by
:php-short:`\TYPO3\CMS\Core\ExpressionLanguage\FunctionsProvider\DefaultFunctionsProvider`
can be used in base variant conditions, **as long as they do not depend on
the current request**.

Base variant conditions are evaluated while the site configuration is loaded
and the :php-short:`\TYPO3\CMS\Core\Site\Entity\Site` object is built. In that
``site`` context the expression language does not receive a request, so the
``request`` variable is unavailable. Among the built-in functions this affects
only ``ip()``, which reads the client IP from the request and fails with an
exception:

..  code-block:: none

    #1686745105 RuntimeException
    Using expression language function "ip(devIp)" in a context without request.

..  versionchanged:: 13.0
    Until TYPO3 v12, request-dependent functions such as ``ip()`` did work in
    base variant conditions: their implementation read the client address
    directly from the server environment, independent of a request object.
    This request-less fallback was deprecated in v12.3 and removed in v13.0,
    which is why such conditions now fail with the exception shown above. See
    `Breaking: #100963 <https://docs.typo3.org/permalink/changelog:breaking-100963-1686129084>`__.

..  note::
    For request-dependent base variants (for example matching the current
    host or request parameters), use a dedicated extension such as
    :composer:`b13/host-variants`, or register your own condition or function
    provider that injects the request into the expression language context.

The following request-independent functions are available:

..  option:: compatVersion

    :type: string
    :Example: `compatVersion("14.3.0")`, `compatVersion("13.4")`

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
