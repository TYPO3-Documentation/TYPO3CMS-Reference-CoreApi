.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _using-phpdoc:

Using phpDoc
^^^^^^^^^^^^

phpDoc is used for documenting source code. Typically TYPO3 code uses
the following phpDoc keywords:

- :code:`@author`

- :code:`@access`

- :code:`@global`

- :code:`@param`

- :code:`@return`

- :code:`@see`

- :code:`@var`

- :code:`@deprecated`

For more information on phpDoc see the phpDoc web site at
`http://www.phpdoc.org/ <http://www.phpdoc.org/>`_

TYPO3 requires that each class, function and method be documented with
phpDoc. For information on phpDoc use for class declarations see
"Class information block".

Note that the :code:`@author` tag should **not** be used in function or
method phpDoc comment blocks – only at class level – because it is too
liable to change frequently and authors would accumulate indefinitely.
:code:`git blame` is enough for tracking changes.


Function information block
""""""""""""""""""""""""""

Functions should have parameters and return type documented. Example::

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

**Short and long description**

A method or class may have both a short and a long description. The
short description is the first piece of text inside the phpDoc block.
It ends with the next blank line. Any additional text after that line
and before the first tag is the long description.

Use :code:`@return void` when a function does not return a value.

