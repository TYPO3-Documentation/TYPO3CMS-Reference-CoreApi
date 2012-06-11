

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Handling deprecation
^^^^^^^^^^^^^^^^^^^^

This section describes the rules to follow for removing existing
functions or parameters from TYPO3. The general principle is that
functions or parameters are removed  **two major versions** after they
were set to be deprecated.

To start the deprecation process for a parameter of a TYPO3 core
function, please mark it within the phpDoc param part:

::

   /**
    * ...
    * @param       string  DEPRECATED since TYPO3 4.X - is not used anymore because...
    * ... 
    */

For a whole function inside one of the TYPO3 core classes, use the
phpDoc @deprecatedparameter:

::

   /**
    * ...
    * @return...
    * @deprecated since TYPO3 4.X - is not used anymore, use FUNCNAME instead 
    */

Anyone can submit a patch to remove deprecated elements starting with
version TYPO3 4.X+2.


