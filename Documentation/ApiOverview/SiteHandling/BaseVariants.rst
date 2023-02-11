.. include:: /Includes.rst.txt
.. index:: Site handling; Base variants
.. _sitehandling-baseVariants:

=============
Base variants
=============

In site handling "base variants" represent different bases for a web site depending on a specified
condition. For example a "live" base URL might be :samp:`https://example.org` but on local machine
it's :samp:`https://example.localhost` as a domain - that's when variants are used.

Base variants exist for languages, too. Currently these can only be defined
through the respective :file:`*.yml` file, there is no UI available yet.

Variants consist of two parts:

*  a base to use for this variant
*  a condition that decides when this variant shall be active

Conditions are based on Symfony expression language and allow flexible
conditions. For example:

.. code-block:: none

    applicationContext == "Development"

would define a base variant to use in Development context.

.. note::

   Notice that environment variables can be used in the :yaml:`base` via ``%env(...)%``.
   :yaml:`condition` needs ``getenv(...)`` instead.

.. include:: /Images/AutomaticScreenshots/SiteHandling/SiteHandlingBaseVariants-1.rst.txt

.. hint::
   For those coming from earlier TYPO3 versions: With site handling, there is
   no need for `sys_domain` records anymore!

.. seealso::
   Read :ref:`application-context` for more information on how to set the
   application context.

   Read :ref:`yaml-api` for more information on YAML parsing.

The following variables and functions are available in addition to the default
Symfony functionality:

Example
=======

.. code-block:: yaml
   :caption: config/sites/<some_site>/config.yaml | typo3conf/sites/<some_site>/config.yaml

   rootPageId: 1
   base: 'https://example.org/'
   baseVariants:
     -
       base: 'https://example.localhost/'
       condition: 'applicationContext == "Development"'
     -
       base: 'https://staging.example.org/'
       condition: 'applicationContext == "Production/Sydney"'
     -
       base: 'https://testing.example.org/'
       condition: 'applicationContext == "Testing/Paris"'
     -
       base: '%env("TYPO3_BASE")%'
       condition: 'getenv("TYPO3_BASE")'
   languages:
     -
       title: English
       enabled: true
       locale: en_US.UTF-8
       base: /
       websiteTitle: ''
       navigationTitle: English
       flag: gb
       languageId: 0
     -
       title: Deutsch
       enabled: true
       locale: de_DE.UTF-8
       base: 'https://example.net/'
       baseVariants:
         -
           base: 'https://de.example.localhost/'
           condition: 'applicationContext == "Development"'
         -
           base: 'https://staging.example.net/'
           condition: 'applicationContext == "Production/Sydney"'
         -
           base: 'https://testing.example.net/'
           condition: 'applicationContext == "Testing/Paris"'
       websiteTitle: ''
       navigationTitle: Deutsch
       fallbackType: strict
       flag: de
       languageId: 1


.. index:: Site handling; Base variant properties

Properties
==========

typo3.version
-------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The current TYPO3 version

:aspect:`Example`
    `11.5.0`


typo3.branch
------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The current TYPO3 branch

:aspect:`Example`
    `11.5`


typo3.devIpMask
---------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The configured devIpMask taken from `$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']`

:aspect:`Example`
    `77.176.160.*`


applicationContext
------------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The current application context

:aspect:`Example`
    `Development`


.. index::
   Site handling; Base variant functions
   DefaultFunctionsProvider

Functions
=========

All functions from TYPO3s `DefaultFunctionsProvider` are available:

ip
--

:aspect:`Datatype`
    string

:aspect:`Description`
    Match an IP address, value or regex, wildcards possible. Special value: `devIp` for matching `devIpMask`.

:aspect:`Example`
    `ip("77.176.160.*")`


compatVersion
-------------

:aspect:`Datatype`
    string

:aspect:`Description`
    Match a TYPO3 version

:aspect:`Example`
    `compatVersion("11.5.0")`, `compatVersion("11.4")`


like
----

:aspect:`Datatype`
    string

:aspect:`Description`
    Comparison function to compare two strings. The first parameter is the "haystack", the
    second the "needle". Wildcards are allowed.

:aspect:`Example`
    `like("foobarbaz", "*bar*")`


getenv
------

:aspect:`Datatype`
    string

:aspect:`Description`
    Wrapper for PHPs `getenv()` function. Allows accessing environment variables.

:aspect:`Example`
    `getenv("TYPO3_BASE_URL")`


date
----

:aspect:`Datatype`
    string

:aspect:`Description`
    Get the current date in given format.

:aspect:`Example for checking the current month`
    `date("j") == 7`


feature
-------

:aspect:`Datatype`
    string

:aspect:`Description`
    Check whether a feature ("feature toggle") is enabled in TYPO3.

:aspect:`Example`
    `feature("TypoScript.strictSyntax")`


traverse
--------

:aspect:`Datatype`
    array and string

:aspect:`Description`
    This function has two parameters: - first parameter is the array to traverse - second parameter is the path to traverse Syntax.

:aspect:`Example`
    `traverse(request.getQueryParams(), 'tx_news_pi1/news') > 0`
