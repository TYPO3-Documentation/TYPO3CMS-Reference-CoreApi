:navigation-title: Configuration inspector

..  include:: /Includes.rst.txt
..  index::
    pair: Configuration; Module
    TYPO3_CONF_VARS; Validation
    TCA; Validation
..  _config-module:
..  _config-module-blind-options:

==================================
Configuration inspector (readonly)
==================================

Only available if :composer:`typo3/cms-lowlevel` is installed.

The configuration module can be found at :guilabel:`System > Configuration`.
It allows users with system maintainer permissions to view and validate the
global configuration of TYPO3.

..  versionchanged:: 14.0
    The :guilabel:`System > Configuration` module is now only available
    for system maintainers.

The module displays all relevant global variables, such as
:ref:`TYPO3_CONF_VARS <typo3ConfVars>`, :ref:`TCA <t3tca:start>` and many more,
in a tree format which is easy to browse through. Over time, this module has been
extended to also display configuration of newly introduced features like the
:ref:`middleware stack <request-handling>` and
:ref:`event listeners <EventDispatcherListeners>`.

..  seealso::

    The module is described in detail in the
    `EXT:lowlevel docs, chapter Module System > Configuration <https://docs.typo3.org/permalink/typo3/cms-lowlevel:module-configuration>`_

..  contents:: Table of Contents
    :local:

..  warning::
    This module is always viewed in the backend context. Variables defined
    only in the FE context will not be visible.

..  _globals-exploring:

Exploring global variables in array `$GLOBALS`
==============================================

Many of the global variables described in chapter `$GLOBALS <https://docs.typo3.org/permalink/t3coreapi:globals-variables>`_
can be inspected using the module :guilabel:`System > Configuration`.

..  figure:: /Images/ManualScreenshots/Backend/SystemConfigurationGlobals.png
    :alt: Backend module System -> Configuration with the selector open to demonstrate $GLOBALS variables that can be displayed

    This module is purely a browser. It does not let you change any settings.

..  _config-module-extending:

Extending the Configuration module
==================================

The :guilabel:`System > Configuration` module can also be extended or configured
to blind options. See the :composer:`typo3/cms-lowlevel` manual, chapter
`Configuration module <https://docs.typo3.org/permalink/typo3/cms-lowlevel:module-configuration>`_.
