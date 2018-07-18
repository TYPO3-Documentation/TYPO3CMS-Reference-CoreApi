.. include:: ../../Includes.txt


.. _cgl-deprecation:

Handling deprecation
^^^^^^^^^^^^^^^^^^^^

This section describes the rules to follow for removing existing
functions or parameters from TYPO3 CMS. The general principle is that
functions or parameters are removed **two major versions** after they
were set to be deprecated.

To start the deprecation process for a parameter of a TYPO3 CMS core
function, please mark it within the phpDoc param part::

   /**
    * ...
    * @param string DEPRECATED since TYPO3 CMS 9 - is not used anymore because...
    * ...
    */


For a whole function inside one of the TYPO3 CMS core classes, use the
phpDoc `@deprecated` annotation::

   /**
    * ...
    * @return ...
    * @deprecated
    */


At the beginning of the deprecated function you must add the following
code::

   trigger_error('since TYPO3 CMS 9, will be removed in TYPO3 CMS 10, use FUNCNAME instead', E_USER_DEPRECATED);


It is also possible to deprecate finer-grained elements, such as
TypoScript or TSconfig properties. In such a case, a log message can be
used inside the code itself::

   if ($fooBar !== null) {
      trigger_error('A useful message', E_USER_DEPRECATED);
      $this->useFooBar = true;
   }


Anyone can submit a patch to remove deprecated elements.
