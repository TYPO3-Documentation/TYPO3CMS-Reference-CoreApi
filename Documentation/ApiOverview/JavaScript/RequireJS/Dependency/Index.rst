.. include:: /Includes.rst.txt






.. _requirejs-dependency:

===================
Dependency Handling
===================

Let us try to explain the dependency handling with the most used JS lib: jQuery

To prevent the "$ is undefined" error, you should use the dependency handling of RequireJS.
To get jQuery working in your code, use the following line:

.. code-block:: js

   define(['jquery'], function($) {
      // in this callback $ can be used
   });

The code above is very easy to understand:

1. every dependency in the array of the first argument
2. will be injected in the callback function at the same position

Let us combine jQuery with our own module from the :ref:`Extension example <requirejs-extensions>`

.. code-block:: js

   define(['jquery', 'TYPO3/CMS/FooBar/MyMagicModule'], function($, MyMagicModule) {
      // $ is our jQuery object
      // MyMagicModule is the object, which is returned from our own module
      if(MyMagicModule.foo == 'bar'){
         MyMagicModule.init();
      }
   });

