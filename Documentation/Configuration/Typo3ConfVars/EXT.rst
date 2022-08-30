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

    *   :ref:`typo3conf/LocalConfiguration.php <typo3ConfVars-localConfiguration>`
    *   :ref:`typo3conf/AdditionalConfiguration.php <typo3ConfVars-additionalConfiguration>`


.. index::
   TYPO3_CONF_VARS SYS; allowGlobalInstall
.. _typo3ConfVars_ext_allowGlobalInstall:

$GLOBALS['TYPO3_CONF_VARS']['EXT']['allowGlobalInstall']
========================================================

.. confval:: allowGlobalInstall

   :Path: $GLOBALS['TYPO3_CONF_VARS']['EXT']
   :type: bool
   :Default: false

   If set, global extensions in :file:`typo3/ext/` are allowed to be installed,
   updated and deleted etc.

.. index::
   TYPO3_CONF_VARS SYS; allowLocalInstall
.. _typo3ConfVars_ext_allowLocalInstall:

$GLOBALS['TYPO3_CONF_VARS']['EXT']['allowLocalInstall']
=======================================================

.. confval:: allowLocalInstall

   :Path: $GLOBALS['TYPO3_CONF_VARS']['EXT']
   :type: bool
   :Default: true

   If set, local extensions in :file:`typo3conf/ext/` are allowed to be
   installed, updated and deleted etc.

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
