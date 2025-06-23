:navigation-title: Deprecation Handling

..  include:: /Includes.rst.txt
..  _deprecation_introduction:
..  _deprecation:

===============================================================
Deprecation handling: logging, marking and finding deprecations
===============================================================

TYPO3 logs calls to deprecated functions to help developers identify and update
outdated code. Deprecated methods will be removed in future TYPO3 versions, so
they should be avoided.

Deprecations are triggered by :php:`trigger_error()` and pass through TYPO3’s
logging and exception system. In development, they are shown as exceptions by
default; in production, they are typically ignored.

..  note::
    For information how to handle deprecations in the TYPO3 Core,
    see the Contribution Guide: :ref:`t3contribute:deprecations`.

..  contents:: Table of content
    :local:

..  index:: Deprecation; Log enabling
..  _deprecation-enable-errors:

Enabling the deprecation log
============================

TYPO3 ships with a default configuration where deprecation logging is
**disabled**. If you upgrade to the latest TYPO3 version, you need to change
your development configuration to enable deprecation logging if you need
it.

..  seealso::

    To learn how to properly disable the deprecation log in production, see
    :ref:`deprecation-disable-errors`.

..  _deprecation-enable-errors-gui:

Via GUI
-------

Enabling the deprecation log can be done in the
:guilabel:`Admin Tools > Settings` backend module. Click on
:guilabel:`Choose Preset` in the :guilabel:`Configuration Presets` pane, open
:guilabel:`Debug settings`, activate the :guilabel:`Debug` option and submit
with :guilabel:`Activate preset`. Disabling the deprecation log can be done by
selecting the :guilabel:`Live` preset instead.

..  figure:: /Images/ManualScreenshots/Backend/EnablingDebugPreset.png
    :alt: Enabling the debug preset
    :class: with-shadow

    Enabling the debug preset

The debug preset also enables some other debug settings.

..  note::
    These steps only enable/disable the :ref:`FileWriter <logging-writers-FileWriter>`,
    which comes with the TYPO3 default configuration. If you manually configured
    **additional** writers for the `TYPO3.CMS.deprecations` logger, you need to
    manually remove them to completely disable deprecation logging.

..  _deprecation-enable-errors-config:

Via configuration file directly
-------------------------------

Instead of using the :abbr:`GUI (Graphical User Interface)` you can also enable
or disable the deprecation log with the :php:`disabled` option:

..  literalinclude:: _settings.php
    :language: php
    :caption: Excerpt of config/system/settings.php | typo3conf/system/settings.php

Deprecation logging can also be enabled in the :file:`additional.php`
configuration file, here with safeguarding to only enable it in
development context:

..  literalinclude:: _additional.php
    :language: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

For more information on how to configure the writing of deprecation logs see
:ref:`logging-configuration-writer`.


..  index::
    Deprecation; Find deprecated functions
    Deprecation; Extension scanner
..  _deprecation_finding_calls:

Find calls to deprecated functions
==================================

The :ref:`extension scanner <extension-scanner>` provides an interactive
interface to scan extension code for usage of removed or deprecated TYPO3 Core
API.

It is also possible to do a file search for :php:`@deprecated` and
:php:`E_USER_DEPRECATED`. Using an IDE you can find all calls to the affected
methods.

The deprecations are also listed in the :doc:`changelog <ext_core:Index>` of the
corresponding TYPO3 version.


..  index:: Deprecation; Functions
..  _deprecate_functions:

Deprecate functions in extensions
=================================

Methods that will be removed in future versions of your extension should be
marked as deprecated by both the doc comment and a call to the PHP error method:

..  code-block:: php
    :caption: Excerpt of EXT:my_extension/Classes/MyClass.php

    /**
     * @deprecated since version 3.0.4, will be removed in version 4.0.0
     */
    public function decreaseColPosCountByRecord(array $record, int $dec = 1): int
    {
        trigger_error(
            'Method "decreaseColPosCountByRecord" is deprecated since version 3.0.4, will be removed in version 4.0.0',
            E_USER_DEPRECATED
        );

        // ... more logic
    }

For more information about how to deprecate classes, arguments and hooks and how
the TYPO3 Core handles deprecations, see :ref:`t3contribute:deprecations`.
