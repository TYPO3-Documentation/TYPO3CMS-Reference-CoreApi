.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; EXT
.. _typo3ConfVars_ext:

=====================================
EXT - Extension manager configuration
=====================================

The following configuration variables can be used to configure settings for
the Extension manager:

..  contents::
    :local:

..  attention::
    Extension specific configuration should be stored in
    :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSION']` and not here.

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['EXT']`.

    This variable can be set in one of the following files:

    *   :ref:`config/system/settings.php <typo3ConfVars-settings>`
    *   :ref:`config/system/additional.php <typo3ConfVars-additional>`


.. index::
   TYPO3_CONF_VARS SYS; excludeForPackaging
.. _typo3ConfVars_ext_excludeForPackaging:

excludeForPackaging
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['EXT']['excludeForPackaging']

   :Path: $GLOBALS['TYPO3_CONF_VARS']['EXT']
   :type: list
   :Default: :php:`'(?:\\.(?!htaccess$).*|.*~|.*\\.swp|.*\\.bak|node_modules|bower_components)'`

   List of directories and files which will not be packaged into extensions nor
   taken into account otherwise by the Extension Manager. Perl regular
   expression syntax!
