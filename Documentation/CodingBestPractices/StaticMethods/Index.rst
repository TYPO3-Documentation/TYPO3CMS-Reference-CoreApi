.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Static methods
^^^^^^^^^^^^^^

When a given class calls one of its own static methods (or from one of
its parents), the code should use the selfkeyword instead of the class
name.


((generated))
"""""""""""""

Example
~~~~~~~

::

   class tx_myext_MyClass {
       public static function methodA() {
         //...
       }
       public static function methodB() {
         self::methodA(); // instead of tx_myext_MyClass::methodA();
       }
   }

