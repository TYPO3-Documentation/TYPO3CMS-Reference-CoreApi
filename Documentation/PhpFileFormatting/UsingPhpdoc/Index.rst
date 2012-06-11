.. include:: Images.txt

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


Using phpDoc
^^^^^^^^^^^^

phpDoc is used for documenting source code. Typically TYPO3 code uses
the following phpDoc keywords:

- @author

- @access

- @global

- @param

- @package

- @return

- @see

- @subpackage

- @var

- @deprecated

For more information on phpDoc see the phpDoc web site at
`http://www.phpdoc.org/ <http://www.phpdoc.org/>`_

TYPO3 requires that each class, function and method be documented with
phpDoc. For information on phpDoc use for classes declarations see
“Class information block” on page 12.

Note that the @authortag should  **not** be used in function or method
phpDoc comment blocks – only at class level – because it is too liable
to change frequently and authors would accumulate indefinitely.git
blameis enough for tracking changes.


Function information block
""""""""""""""""""""""""""

Functions should have parameters and return type documented. Example:

::

   /**
    * Initializes the plugin.
    *
    * Checks the configuration and substitutes defaults for missing values.
    *
    * @param array $conf Plugin configuration from TypoScript
    * @return boolean TRUE if initialization was successful, FALSE otherwise 
    * @see tx_myext_class:anotherFunc()
    */
   protected function initialize(array $conf) {
           // Do something
   }
   |img-3| 

**Short and long description**

A method or class may have both a short and a long description. The
short description is the first piece of text inside the phpDoc block.
It ends with the next blank line. Any additional text after that line
and before the first tag is the long description.

Use  `@return <mailto:v@return>`_ voidwhen a function does not return
a value.

