..  include:: /Includes.rst.txt
..  index:: ! Deprecation
..  _deprecation:

===========
Deprecation
===========

..  contents::
    :local:

..  index:: Deprecation; Log
..  _deprecation_introduction:
..  _cgl-deprecation:

Introduction
============

Calls to deprecated functions are logged to track usage of deprecated/outdated
methods in the TYPO3 Core. Developers have to make sure to adjust their code to
avoid using this old functionality since deprecated methods will be removed in
future TYPO3 releases.

Deprecations use the PHP method :php:`trigger_error('a message', E_USER_DEPRECATED)`
and run through the logging and exception stack of the TYPO3 Core. There are
several methods that help extension developers in dispatching deprecation
errors. In the development context, deprecations are turned into exceptions by
default and ignored in the production context.

..  note::
    For information how to handle deprecations in the TYPO3 Core,
    see the Contribution Guide: :ref:`t3contribute:deprecations`.


..  index:: Deprecation; Log enabling
..  _deprecation_disable_errors:
..  _deprecation_enable_errors:

Enabling deprecation errors
===========================

TYPO3 ships with a default configuration, in which deprecation logging is
**disabled**. If you upgrade to the latest TYPO3 version, you need to change
your development configuration to enable deprecation logging in case you need
it.

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

The debug preset enables also some other debug settings.

..  note::
    These steps only enable/disable the :ref:`FileWriter <logging-writers-FileWriter>`,
    which comes with the TYPO3 default configuration. If you manually configured
    **additional** writers for the `TYPO3.CMS.deprecations` logger, you need to
    manually remove them to completely disable deprecation logging.

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
