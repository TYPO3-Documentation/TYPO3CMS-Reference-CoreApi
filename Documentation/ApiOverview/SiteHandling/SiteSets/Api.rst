:navigation-title: PHP API

..  include:: /Includes.rst.txt
..  index:: Site handling; Site set API
..  _site-sets-php-api:

================
Site set PHP API
================

This page answers two different questions: *what are this site's effective
settings* and *what set definitions exist at all*. Use the site object for
the first — it holds the effective settings of one site after defaults and
overrides have been composed.

Use :php-short:`\TYPO3\CMS\Core\Site\Set\SetRegistry` for the second — it
lets code inspect which set definitions are available independently of any
site.

Do not use the registry to rebuild a site's configuration. The site object
already contains the correctly resolved result.

..  contents:: On this page
    :local:

..  _site-sets-php-api-site:

Read site settings from the site object
=======================================

Read site settings through the
:php-short:`\TYPO3\CMS\Core\Site\Entity\Site` object:

..  code-block:: php

    $color = $site->getSettings()->get('website.background.color');

For a defined setting, TYPO3 validates and converts the returned value and
uses the default when no override exists. See :ref:`Site settings <sitehandling-settings>` for
details, including the requirement to define settings before relying on them.

The caller should depend on the setting contract provided by the active set,
not on the physical YAML file from which the effective value originated.

..  _site-sets-php-api-setregistry:

Query set definitions with `SetRegistry`
========================================

Use :php:`\TYPO3\CMS\Core\Site\Set\SetRegistry` to query available site set
definitions. Use the site object instead when you need the configuration or
settings of a specific site.

This distinction is useful for tooling that validates dependencies or presents
available sets. Normal frontend and backend features usually start from a site
and therefore should use its resolved settings.

..  _site-sets-php-api-setregistry-getsets:

`getSets()`
-----------

Returns the requested site set definitions and their dependencies in dependency
order. A requested name that is not available contributes no result; use
:php:`hasSet()` when its availability matters:

..  code-block:: php

    $sets = $setRegistry->getSets('my-vendor/my-set', 'my-vendor/my-set-two');

..  _site-sets-php-api-setregistry-hasset:

`hasSet()`
----------

Checks whether a site set definition is available:

..  code-block:: php

    $hasSet = $setRegistry->hasSet('my-vendor/my-set');

..  _site-sets-php-api-setregistry-getset:

`getSet()`
----------

Returns one site set definition without resolving its dependencies, or `null`
when the name is not available:

..  code-block:: php

    $set = $setRegistry->getSet('my-vendor/my-set');

..  _site-sets-php-api-setcollector:

Internal set collection
=======================

:php:`\TYPO3\CMS\Core\Site\Set\SetCollector` is an internal implementation
detail used while TYPO3 discovers set definitions. Extension code must not
inject or call it because internal APIs can change without a public API promise.

Use :php-short:`\TYPO3\CMS\Core\Site\Set\SetRegistry` to query available set
definitions. Use the site object when code needs the resolved configuration of
a specific site.
