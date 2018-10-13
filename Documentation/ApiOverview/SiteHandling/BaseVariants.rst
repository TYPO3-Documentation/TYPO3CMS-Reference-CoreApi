.. include:: ../../Includes.txt

.. _sitehandling-baseVariants:

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

The following variables and functions are available in addition to the default symfony functionality:

Properties
----------

.. container:: table-row

   Property
         typo3.version

   Data type
         string

   Description
         The current TYPO3 version

   Example
         `9.5.0`

.. container:: table-row

   Property
         typo3.branch

   Data type
         string

   Description
         The current TYPO3 branch

   Example
        `9.5`

.. container:: table-row

   Property
         typo3.devIpMask

   Data type
         string

   Description
         The configured devIpMask taken from `$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask']`

   Example
        `77.176.160.*`

.. container:: table-row

   Property
         applicationContext

   Data type
         string

   Description
         The current application context

   Example
        `Development`

Functions
---------

All functions from TYPO3s `DefaultFunctionProvider` are available:

.. container:: table-row

   Function
         ip

   Data type
         string

   Description
         Match an IP address, value or regex, wildcards possible. 
         Special value: `devIp` for matching `devIpMask`.

   Example
        `ip("77.176.160.*")`

.. container:: table-row

   Function
         compatVersion

   Data type
         string

   Description
         Match a TYPO3 version

   Example
        `compatVersion("9.5.0")`
        `compatVersion("9.4")`

.. container:: table-row

   Function
         like

   Data type
         string

   Description
         Comparison function to compare two strings. The first parameter is the "haystack", the 
         second the "needle". Wildcards are allowed.

   Example
        `like("foobarbaz", "*bar*")`

.. container:: table-row

   Function
         env

   Data type
         string

   Description
         Wrapper for PHPs `getenv()` function. Allows accessing environment variables.

   Example
        `env("TYPO3_BASE_URL")`

.. hint::
    For those coming from earlier TYPO3 versions: With site handling, you do not need `sys_domain` records anymore! :)