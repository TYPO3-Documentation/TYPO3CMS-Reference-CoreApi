..  include:: /Includes.rst.txt

..  _caching-developer:

=====================
Developer information
=====================

This chapter is aimed at extension authors who want to use the caching
framework for their needs. It is about how to use the framework properly. For
details about its inner working, please refer to the
:ref:`section about architecture <caching-architecture>`.

Example usages can be found throughout the TYPO3 Core, in particular in the
system extensions `core` and `extbase`.

..  _caching-developer-usage:
..  _caching-developer-registration:

Cache registration
==================

Registration of a new cache should be done in an extension's
:ref:`ext-localconf-php`. The example below defines an empty sub-array in
`cacheConfigurations`. Neither *frontend* nor *backend* are defined: The cache
manager will choose the default
:ref:`variable frontend <caching-frontend-variable>` and the
:ref:`database backend <caching-backend-db>` by default.

..  literalinclude:: _init.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  tip::
    The null coalescing assignment operator (:php:`??=`) check is used to
    enable administrators to overwrite configuration of caches in
    :ref:`config/system/settings.php <configuration-files>`. During
    :ref:`bootstrap <bootstrapping>`, any :file:`ext_localconf.php` is loaded
    **after** :file:`config/system/settings.php` and
    :file:`config/system/additional.php` are loaded, so it is important to make
    sure that the administrator did not already set any configuration of the
    extension's cache.

If special settings are needed, for example, a specific backend (like the
:ref:`transient memory backend <caching-backend-transient>`), it can be defined
with an additional line below the cache array declaration. The extension
documentation should hint an integrator about specific caching needs or setups
in this case.

..  tip::
    Extensions should not force specific settings, therefore the null coalescing
    assignment operator (:php:`??=`) is used to allow administrators to
    overwrite those settings. It is recommended to set up a cache configuration
    with sane defaults, but administrators should always be able to overwrite
    them for whatever reason.

..  literalinclude:: _transient.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  _caching-developer-example:
..  _caching-developer-access:

Using the cache
===============

First, we need to prepare the injection of our cache by setting it up as service
in the :ref:`container service configuration
<configure-dependency-injection-in-extensions>`:

..  literalinclude:: _Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions
<dependency-injection-in-extensions>`.

The name of the service for the injection configuration is
:yaml:`cache.myext_mycache`, the name of the cache is `myext_mycache` (as
defined in :php:`ext_localconf.php`). Both can be anything you like, just make
sure they are unique and clearly hint at the purpose of your cache.

Here is some example code which retrieves the cache via dependency injection:

..  literalinclude:: _MyClass.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php

..  tip::
    It is not needed to call :php:`$this->cache->has()` before accessing cache
    entries with :php:`$this->cache->get()` as the latter returns :php:`false`
    if no entry exists.

Since the :ref:`auto-wiring feature <dependency-injection-autowire>` of the
dependency injection container cannot detect which cache configuration should be
used for the :php:`$cache` argument of :php:`MyClass`, the :ref:`container
service configuration <configure-dependency-injection-in-extensions>` needs to
be extended:

..  literalinclude:: _Services_autowiring.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions
<dependency-injection-in-extensions>`.

Here :yaml:`@cache.myext_mycache` refers to the cache service we defined above.
This setup allows you to freely inject the very same cache into any class.

..  note::
    After changes in the :file:`Configuration/Services.yaml` file flush the
    cache via :guilabel:`System > Maintenance` or the :ref:`CLI command
    <symfony-console-commands>` `cache:flush`:

    .. include:: /_includes/CliCacheFlush.rst.txt


..  _caching-developer-cache-tags:

Working with cache tags
=======================

The frontend cache collector API is available as a PSR-7 request attribute to
collect cache tags and their corresponding lifetime. Find more information in
the chapter :ref:`typo3-request-attribute-frontend-cache-collector`.
