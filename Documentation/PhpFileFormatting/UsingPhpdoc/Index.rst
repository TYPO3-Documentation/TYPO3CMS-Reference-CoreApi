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

TYPO3 requires that each class, function and method be documented with
phpDoc. For information on phpDoc use for class declarations see
"Class information block".

The single parts of information for a phpDoc keyword are separated by
one single space.


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

