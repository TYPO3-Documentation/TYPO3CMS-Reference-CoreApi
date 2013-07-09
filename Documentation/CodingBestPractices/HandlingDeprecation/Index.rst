.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _deprecation:

Handling deprecation
^^^^^^^^^^^^^^^^^^^^

This section describes the rules to follow for removing existing
functions or parameters from TYPO3. The general principle is that
functions or parameters are removed **two major versions** after they
were set to be deprecated.

To start the deprecation process for a parameter of a TYPO3 core
function, please mark it within the phpDoc param part::

   /**
    * ...
    * @param string DEPRECATED since TYPO3 6.X - is not used anymore because...
    * ...
    */


For a whole function inside one of the TYPO3 core classes, use the
phpDoc :code:`@deprecated` annotation::

   /**
    * ...
    * @return ...
    * @deprecated since TYPO3 6.X, will be removed in 2 versions - use FUNCNAME instead
    */


At the beginning of the deprecated function you must add the following code::

   \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction();


This reads the :code:`@deprecated` annotation and logs its comment into the deprecation
log.

It is also possible to deprecate finer-grained elements, such as TypoScript
or TSconfig properties. In such a case, a log message can be used inside the code itself::

	if ($fooBar !== NULL) {
		\TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog('Usage of foobar is deprecated since TYPO3 CMS 6.2. It will be removed in 2 versions. Use barfoo instead.');
		$this->useFooBar = TRUE;
	}


Anyone can submit a patch to remove deprecated elements starting with
version TYPO3 6.X+2.

