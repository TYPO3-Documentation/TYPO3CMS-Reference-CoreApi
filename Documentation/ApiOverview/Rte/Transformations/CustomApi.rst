.. include:: /Includes.rst.txt


.. _transformations-custom:

==========================
Custom Transformations API
==========================

Up until TYPO3 9 it was possibile to use custom transformations instead of using
the built-in transformations of TYPO3.

The hook can still be implemented in TYPO3 10 however it is recommended to
no more rely on it as it will get removed in the future.

To register a transformation key in the s<stem set a :code:`$GLOBALS['TYPO3_CONF_VARS']` variable
to point to the class which contains the transformation methods::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']['tx_examples_transformation']
      = 'Documentation\Examples\Service\RteTransformation';

This class must contain two public methods, :code:`transform_db()` and
:code:`transform_rte()`.
