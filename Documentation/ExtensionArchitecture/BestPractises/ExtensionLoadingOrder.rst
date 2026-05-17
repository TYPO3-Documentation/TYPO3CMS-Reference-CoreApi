:navigation-title: Loading order

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
..  _extension-loading-order-classic:
..  _extension-loading-order-composer-and-classic:

Defining the loading order via file composer.json
=================================================

..  deprecated:: 14.2
    File :file:`ext_emconf.php` is deprecated, the loading order is
    defined in the :file:`composer.json` file for all installation methods.

Extensions and dependencies are installed based on the configuration in the
:file:`composer.json <extension-composer-json>` file.

For example, if an extension relies on or modifies functionality provided by
the :composer:`typo3/cms-felogin` system extension, the dependency should be defined
as follows:

..  literalinclude:: _snippets/_require-composer.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json

This ensures that TYPO3 loads the extension **after** the
:composer:`typo3/cms-felogin` system extension.

Instead of `require`, extensions can also use the `suggest` section.
Suggested extensions, if installed, are loaded **before** the current one —
just like required ones — but without being mandatory.

A typical use case is suggesting an extension that provides optional widgets,
such as for :composer:`typo3/cms-dashboard`.
