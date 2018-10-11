.. include:: ../../Includes.txt


.. _cgl-static-methods:

Static methods
^^^^^^^^^^^^^^

When a given class calls one of its own static methods (or one from one
of its parents), the code should use the :php:`self` keyword instead
of the class name. For more information on when or where static methods
are a good idea (or not), see :ref:`modelling cross cutting concerns <cgl-model-static-methods>`.

Example
"""""""

.. code-block:: php

   class MyClass
   {
       public static function methodA()
       {
           //...
       }
       public static function methodB()
       {
           // instead of MyClass::methodA():
           self::methodA();
       }
   }

Note that using :php:`static::` does not work in closures/lambda
functions/anonymous functions.
