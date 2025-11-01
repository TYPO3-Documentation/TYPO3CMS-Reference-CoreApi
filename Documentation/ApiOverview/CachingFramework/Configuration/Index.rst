:navigation-title: Configuration

..  include:: /Includes.rst.txt
..  _caching-configuration:

===================
Cache configuration
===================

Caches are configured in the array
:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']`. The basic structure is
predefined in :t3src:`core/Configuration/DefaultConfiguration.php`, and consists
of the single section:

:php:`cacheConfigurations`
    Registry of all configured caches. Each cache is identified by its array
    key. Each cache can have the sub-keys :php:`frontend`, :php:`backend` and
    :php:`options` to configure the used frontend, backend and possible backend
    options.

..  _caching-configuration-cache:

Cache configurations
====================

Unfortunately in TYPO3, all :file:`ext_localconf.php` files of the extensions
are loaded **after** the instance-specific configuration from
:file:`config/system/settings.php` and :file:`config/system/additional.php`.
This enables extensions to overwrite cache configurations already done for the
instance. All extensions should avoid this situation and should define the very
bare minimum of cache configurations. This boils down to define the array key to
populate a new cache to the system. Without further configuration, the cache
system falls back to the default backend and default frontend settings:

..  literalinclude:: _default.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Extensions, like :ref:`Extbase <extbase>`, define default caches this way,
giving administrators full freedom for specific and possibly quicker setups
(for example, a memory-driven cache for the Extbase reflection cache).

Administrators can overwrite specific settings of the cache configuration in
:file:`config/system/settings.php` or :file:`config/system/additional.php`. Here
is an example configuration to switch **pages** to the **Redis** backend using
database 3:

..  literalinclude:: _redis.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

Some backends have mandatory as well as optional parameters (which are
documented in the :ref:`Cache backends <caching-backend>` section). If not all
mandatory options are defined, the specific backend will throw an exception, if
accessed.

..  _caching-disable:

How to disable specific caches
==============================

During development it can be convenient to disable certain caches. This is
especially helpful for central caches like the language or autoloader cache.
This can be achieved by using the :ref:`null backend <caching-backend-null>` as
storage backend.

..  warning::
    Do not use this in production, it will slow the system down considerably!

Example configuration to switch the *extbase_reflection* cache to use the
**null** backend:

..  literalinclude:: _null.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php
