.. include:: ../../Includes.txt


.. _static-methods:

Static methods
^^^^^^^^^^^^^^

When a given class calls one of its own static methods (or one from one
of its parents), the code should use the :code:`self` keyword instead
of the class name.


Example
"""""""

::

   class MyClass {
       static public function methodA() {
           //...
       }
       static public function methodB() {
           // instead of MyClass::methodA():
           self::methodA();
       }
   }

Note that using :code:`static::` does not work in closures/lambda
functions/anonymous functions.

