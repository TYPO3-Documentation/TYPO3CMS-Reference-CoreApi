
.. index::
   TYPO3_CONF_VARS SYS; allowGlobalInstall
.. _typo3ConfVars_ext_allowGlobalInstall:

$GLOBALS['TYPO3_CONF_VARS']['EXT']['allowGlobalInstall']
========================================================

.. confval:: allowGlobalInstall
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
   :type: bool
   :Default: true

   If set, local extensions in :file:`typo3conf/ext/` are allowed to be
   installed, updated and deleted etc.

.. index::
   TYPO3_CONF_VARS SYS; excludeForPackaging
.. _typo3ConfVars_ext_excludeForPackaging:

$GLOBALS['TYPO3_CONF_VARS']['EXT']['excludeForPackaging']
=========================================================

.. confval:: excludeForPackaging:
   :type: list
   :Default: :php:`'(?:\\.(?!htaccess$).*|.*~|.*\\.swp|.*\\.bak|node_modules|bower_components)'`

   List of directories and files which will not be packaged into extensions nor
   taken into account otherwise by the Extension Manager. Perl regular
   expression syntax!
