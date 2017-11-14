.. include:: ../../Includes.txt


.. _using-phpdoc:

Using phpDoc
^^^^^^^^^^^^

phpDoc is used for documenting source code. Typically TYPO3 code uses
the following phpDoc keywords:

- :code:`@global`

- :code:`@param`

- :code:`@return`

- :code:`@see`

- :code:`@var`

- :code:`@deprecated`

For more information on phpDoc see the phpDoc web site at
`http://www.phpdoc.org/ <http://www.phpdoc.org/>`_

TYPO3 does not require that each class, function and method be documented with
phpDoc, but if you cannot use a type-hint, then a docblock documenting types is necessary. 
Additionally add a phpDoc to your code if it provides additional information. 
For example detail the content of arrays using the Object[] notation, if the return type is 
mixed and cannot be strictly annotated, add a @return tag. If parameters or return 
types have specific syntactical requirements, document them.

The single parts of information for a phpDoc keyword are separated by
one single space.

For information on phpDoc use for class declarations see
"Class information block".

Function information block
""""""""""""""""""""""""""

Functions should have parameters and return type documented. Example::

   /**
    * Initializes the plugin.
    *
    * Checks the configuration and substitutes defaults for missing values.
    *
    * @param array $conf Plugin configuration from TypoScript
    * @return bool true if initialization was successful, false otherwise
    * @see MyClass:anotherFunc()
    */
   protected function initialize(array $conf) : bool
   {
       // Do something
   }

**Short and long description**

A method or class may have both a short and a long description. The
short description is the first piece of text inside the phpDoc block.
It ends with the next blank line. Any additional text after that line
and before the first tag is the long description.

In the comment blocks use the *short* forms of the type names (e.g.
:code:`int`, :code:`bool`, :code:`string`, :code:`array` or
:code:`mixed`).

Use :code:`@return void` when a function does *not* return a value.

