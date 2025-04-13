.. include:: /Includes.rst.txt
.. index:: Extension development; Software Design Principles
.. _extension-loading-order:

=======================
Extension loading order
=======================

In TYPO3, the order in which extensions are loaded can impact system behavior.
This is especially important when an extension overrides, extends, or modifies
the functionality of another. TYPO3 initializes extensions in a defined order,
and if dependencies are not loaded beforehand, it can lead to unintended
behavior.

.. _extension-loading-order-composer:

Composer-based installations
----------------------------

In Composer-based installations, extensions and dependencies are
installed based on the order specified in the
:file:`composer.json <extension-composer-json>` file.

For example, if an extension relies on or modifies functionality provided by
the :php:`ext:felogin` system extension, the dependency should be defined
as follows:

..  literalinclude:: _snippets/_require-composer.json
    :language: json
    :caption: Excerpt of EXT:my_extension/composer.json

This dependency will ensure that TYPO3 loads the extension **after** the
:php:`ext:felogin` system extension.

.. _extension-loading-order-classic:

Classic installations
---------------------

In classic installations, extensions and dependencies are
installed based on the order specified in the :file:`ext_emconf.php` file.

For example, if an extension relies on or modifies functionality provided by
the :php:`ext:felogin` system extension, the dependency should be defined
as follows:

..  literalinclude:: _snippets/_depends-ext-emconf.php
    :language: json
    :caption: EXT:my_extension/ext_emconf.php

This dependency will ensure that TYPO3 loads the extension **after** the
:php:`ext:felogin` system extension.

.. _extension-loading-order-composer-and-classic:

Extensions compatible with both composer and classic mode
---------------------------------------------------------

Extension authors providing an extension for both TYPO3 composer and classic
installations should ensure that the information in the
:file:`composer.json <extension-composer-json>` file is in sync with the
information in the :ref:`ext_emconf.php <ext_emconf-php>` file. This is
especially important when it comes to dependency constraints like :php:`depends`,
:php:`conflicts` and :php:`suggests`. Use the equivalent keywords in
:file:`composer.json <extension-composer-json>` `require`, `conflict` and
`suggest` to set dependencies and ensure there is a specific order.
