..  include:: /Includes.rst.txt
..  index:: Extension development; Software Design Principles
..  _extension-loading-order:

=======================
Extension loading order
=======================

In TYPO3, the order in which extensions are loaded can impact system behavior.
This is especially important when an extension overrides, extends, or modifies
the functionality of another. TYPO3 initializes extensions in a defined order,
and if dependencies are not loaded beforehand, it can lead to unintended
behavior.

..  _extension-loading-order-composer:

Composer-based installations: Loading order via composer.json
=============================================================

In Composer-based installations, extensions and dependencies are
installed based on the configuration in the
:file:`composer.json <extension-composer-json>` file.

For example, if an extension relies on or modifies functionality provided by
the :php:`ext:felogin` system extension, the dependency should be defined
as follows:

..  literalinclude:: _snippets/_require-composer.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json

This ensures that TYPO3 loads the extension **after** the
:php:`ext:felogin` system extension.

Instead of `require`, extensions can also use the `suggest` section.
Suggested extensions, if installed, are loaded **before** the current one —
just like required ones — but without being mandatory.

A typical use case is suggesting an extension that provides optional widgets,
such as for EXT:dashboard.

..  _extension-loading-order-classic:

Classic installations: Loading order via ext_emconf.php
=======================================================

In classic installations, extensions are loaded based on the order defined in the
:file:`ext_emconf.php` file.

For example, if an extension relies on or modifies functionality provided by
the :php:`ext:felogin` system extension, the dependency should be defined
as follows:

..  literalinclude:: _snippets/_depends-ext-emconf.php
    :language: json
    :caption: EXT:my_extension/ext_emconf.php

This ensures that TYPO3 loads the extension **after** the
:php:`ext:felogin` system extension.

As with Composer, you can use the `suggest` section instead of `depends`.
Suggested extensions, if installed, are loaded **before** the current one,
without being strictly required.

..  _extension-loading-order-composer-and-classic:

Keeping the loading order in sync between Composer-based and classic installations
==================================================================================

If your extension supports both Composer-based and classic TYPO3 installations,
you should keep dependency information consistent between the
:file:`composer.json <extension-composer-json>` and
:ref:`ext_emconf.php <ext_emconf-php>` files.

This is especially important for managing dependency constraints such as
`depends`, `conflicts`, and `suggests`. Use the equivalent fields in
:file:`composer.json <extension-composer-json>` — `require`, `conflict`, and
`suggest` — to ensure consistent loading behavior across both installation types.
