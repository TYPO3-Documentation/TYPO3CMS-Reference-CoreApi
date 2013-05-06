.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


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
    * @param       string  DEPRECATED since TYPO3 6.X - is not used anymore because...
    * ...
    */

For a whole function inside one of the TYPO3 core classes, use the
phpDoc :code:`@deprecated` parameter::

   /**
    * ...
    * @return...
    * @deprecated since TYPO3 6.X - is not used anymore, use FUNCNAME instead
    */

At the beginning of the deprecated function you should add a call to
:code:`GeneralUtility::logDeprecatedFunction()` and provide a helpful
deprecation message::

   \TYPO3\CMS\Core\Utility\GeneralUtility::logDeprecatedFunction('This function is deprecated since TYPO3 6.X. Please use xyz instead by doing...');

Anyone can submit a patch to remove deprecated elements starting with
version TYPO3 6.X+2.


