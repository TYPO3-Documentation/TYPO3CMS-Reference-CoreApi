.. include:: ../../Includes.txt

.. _sitehandling-baseVariants:

=============
Base Variants
=============

In Site Handling base variants represent different bases for you web site depending on a specified
condition. For example your "live" base URL might be `https://example.org` but on your local machine
you want `https://example.test` as a domain - that's when you add a variant.

Variants consist of two parts:

* a base to use for this variant
* a condition that decides when this variant shall be active

Conditions are based on Symfony Expression Language and allow flexible conditions. For example::

    applicationContext == "Development"

would define a base variant to use in Development context.

.. figure:: ../../Images/SiteHandlingBaseVariants-1.png
   :class: with-shadow
   :alt: Add a base variant

   A configured base variant for development context.

.. hint::
    For those coming from earlier TYPO3 versions: With site handling, you do not need `sys_domain` records anymore! :)

.. hint::
    Base variants exist for languages, too. 


The following variables and functions are available in addition to the default symfony functionality:

Properties
==========

typo3.version
-------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The current TYPO3 version

:aspect:`Example`
    `9.5.0`


typo3.branch
------------

:aspect:`Datatype`
    string

:aspect:`Description`
    The current TYPO3 branch

:aspect:`Example`
    `9.5`


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
    `compatVersion("9.5.0")`, `compatVersion("9.4")`


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
