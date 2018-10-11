.. include:: ../../../Includes.txt


.. _cgl-using-phpdoc:

============
Using phpDoc
============

"phpDocumentor" (`phpDoc <https://www.phpdoc.org/>`_) is used for documenting
source code. TYPO3 code typically uses the following phpDoc_ keywords:

* :code:`@global`

* :code:`@param`

* :code:`@return`

* :code:`@see`

* :code:`@var`

* :code:`@deprecated`

For more information on phpDoc_ see the phpDoc_ web site at
https://www.phpdoc.org/.

TYPO3 does **not** require that *each class, function* and *method* be
documented with phpDoc_.

But documenting types is required. If you cannot use *type hints* then a
docblock is mandatory to describe the types..

Additionally you should add a phpDoc_ block if additional information seems
appropriate:

* An example would be the detailed description of the content of arrays using
  the Object[] notation.

* If the return type is mixed and cannot be annotated strictly, add a
  @return tag.

* If parameters or return types have specific syntactical requirements:
  document that!

The different parts of a phpDoc_ statement after the keyword are separated by
**one single space.**


Class information block
=======================

((to be written))

((was: For information on phpDoc use for class declarations see "Class
information block".))


Function information block
==========================

Functions should have *parameters* and *the return type* documented. Example::

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


Short and long description
--------------------------

A method or class may have both a short and a long description. The
short description is the first piece of text inside the phpDoc block.
It ends with the next blank line. Any additional text after that line
and before the first tag is the long description.

In the comment blocks use the *short* forms of the type names (e.g.
:php:`int`, :php:`bool`, :php:`string`, :php:`array` or
:php:`mixed`).

Use :code:`@return void` when a function does *not* return a value.
