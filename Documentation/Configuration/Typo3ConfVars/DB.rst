.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; DB
.. _typo3ConfVars_db:

=================================
$GLOBALS['TYPO3_CONF_VARS']['DB']
=================================

.. index::
   TYPO3_CONF_VARS DB; additionalQueryRestrictions
.. _typo3ConfVars_db_additionalQueryRestrictions:

$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']
================================================================

.. confval:: additionalQueryRestrictions

   :Path: $GLOBALS['TYPO3_CONF_VARS']['DB']
   :type: array
   :Default: []

   It is possible to add additional query restrictions by adding class names as
   key to :php:`$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions']`.
   Have a look into the chapter :ref:`database-custom-restrictions` for details.
