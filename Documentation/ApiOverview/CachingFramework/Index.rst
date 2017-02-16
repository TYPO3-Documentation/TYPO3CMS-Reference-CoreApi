.. include:: ../../Includes.txt

.. http://wiki.typo3.org/Caching_framework

.. _caching:

Caching framework
=================

Since TYPO3 CMS 4.3, the core contains a data caching framework
which supports a wide variety of storage solutions and options
for different caching needs. Each cache can be configured individually
and can implement its own specific storage strategy.
Major parts of the system are backported from TYPO3 Flow and are kept in sync between the two systems.

The caching framework exists to help speeding up TYPO3 sites, especially heavily loaded ones.
It is possible to move all caches to a dedicated cache server with specialized cache systems
like the Redis key-value store (a so called `NoSQL database <http://en.wikipedia.org/wiki/NoSQL>`_).

Since TYPO3 CMS 4.6, the caching framework is always enabled,
the old and unflexible approach to cache content is gone.
This document covers settings for TYPO3 CMS 6.0 and beyond.



.. toctree::
   :titlesonly:

   QuickStart/Index
   Configuration/Index
   Architecture/Index
   FrontendsBackends/Index
   Developer/Index
