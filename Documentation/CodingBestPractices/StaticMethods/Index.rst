.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Static methods
^^^^^^^^^^^^^^

When a given class calls one of its own static methods (or one from one
of its parents), the code should use the :code:`self` keyword instead
of the class name.


((generated))
"""""""""""""

Example
~~~~~~~

::

   class tx_myext_MyClass {
       static public function methodA() {
           //...
       }
       static public function methodB() {
           // instead of tx_myext_MyClass::methodA():
           self::methodA();
       }
   }

