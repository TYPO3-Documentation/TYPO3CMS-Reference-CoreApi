.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; EXT
.. _typo3ConfVars_ext:

==================================
$GLOBALS['TYPO3_CONF_VARS']['EXT']
==================================

.. index::
   TYPO3_CONF_VARS SYS; excludeForPackaging
.. _typo3ConfVars_ext_excludeForPackaging:

$GLOBALS['TYPO3_CONF_VARS']['EXT']['excludeForPackaging']
=========================================================

.. confval:: excludeForPackaging:

   :Path: $GLOBALS['TYPO3_CONF_VARS']['EXT']
   :type: list
   :Default: :php:`'(?:\\.(?!htaccess$).*|.*~|.*\\.swp|.*\\.bak|node_modules|bower_components)'`

   List of directories and files which will not be packaged into extensions nor
   taken into account otherwise by the Extension Manager. Perl regular
   expression syntax!
