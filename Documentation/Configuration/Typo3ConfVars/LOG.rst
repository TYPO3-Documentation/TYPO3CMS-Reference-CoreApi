..  include:: /Includes.rst.txt

..  index::
    TYPO3_CONF_VARS; LOG
    Logging
..  _typo3ConfVars_log:

===========================
LOG - Logging configuration
===========================

The array :php:`$GLOBALS['TYPO3_CONF_VARS']['LOG']` defines how TYPO3 handles
logging—what gets logged, how it is formatted, and where it is written.

Depending on your role, there are two relevant guides:

*   For **developers** implementing logging in extensions or custom services,
    see :ref:`logging` chapter.
*   For **system administrators** and **DevOps** configuring logging in
    production environments, see :ref:`production-logging`.

The default logging configuration shipped with TYPO3 can be found in:
:t3src:`core/Configuration/DefaultConfiguration.php`
