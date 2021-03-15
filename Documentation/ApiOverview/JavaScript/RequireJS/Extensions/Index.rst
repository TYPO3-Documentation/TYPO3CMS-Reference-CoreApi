.. include:: /Includes.rst.txt






.. _requirejs-extensions:

===================================
Use RequireJS in Your Own Extension
===================================

To be able to use RequireJS at all, some prerequisites must be fulfilled:

* Your extension *must* have a `Resources/Public/JavaScript` directory. That directory is used for autoloading the modules stored in your extension.
* Each module has a namespace and a module name. The namespace is `TYPO3/CMS/<EXTKEY>`, <EXTKEY> is your extension key in UpperCamelCase, e.g. foo_bar = FooBar
* The namespace maps automatic to your `Resources/Public/JavaScript` directory
* The filename is the modulename + `.js`

Think about what's the purpose of the module. You can only write one module per file (anything else is bad practice anyway)
A complete example: `TYPO3/CMS/FooBar/MyMagicModule` is resided in `EXT:foo_bar/Resources/Public/JavaScript/MyMagicModule.js`

Every AMD (Asynchronous Module Definition) is wrapped in the same construct:

.. code-block:: js

   define([], function() {
      // your module logic here
   });


This is the "container" of the module. It holds the module logic and takes care of dependencies.

TYPO3 defines in its own modules an object to hold the module logic in properties and methods.
The object has the same name as the module. In our case "MyMagicModule":

.. code-block:: js

   define([], function() {
      var MyMagicModule = {
         foo: 'bar'
      };

      MyMagicModule.init = function() {
        // do init stuff
      };

      // To let the module be a dependency of another module, we return our object
      return MyMagicModule;
   });

