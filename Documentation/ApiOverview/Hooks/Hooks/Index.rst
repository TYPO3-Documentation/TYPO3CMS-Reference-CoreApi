.. include:: ../../../Includes.txt


.. _hooks-general:

=====
Hooks
=====
Hooks are basically places in the source code where a user function will be called for processing
if such has been configured. While there are conventions and best practises of how hooks should be
implemented the Hook Concept itself doesn't prevent it from being used in any way.

.. _hooks-basics:

Using Hooks
===========

The two lines of code below are an example of how a hook is used for
clear-cache post-processing. The objective of this could be to perform
additional actions whenever the cache is cleared for a specific page::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = \Vendor\Package\Hook\DataHandlerHook::class . '->postProcessClearCache';

This registers the class/method name to a hook inside of
:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`. The hook will call the user
function after the clear-cache command has been executed. The user function
will receive parameters which allows it to see what clear-cache action was
performed and typically also an object reference to the parent object. Then the
user function can take additional actions as needed.

The class has to be declared with the TYPO3 autoloader.

If we take a look inside of :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` we
find the hook to be activated like this:

.. code-block:: php
   :linenos:

      // Call post processing function for clear-cache:
   if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'])) {
      $_params = array('cacheCmd' => $cacheCmd);
      foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'] as $_funcRef) {
         \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef, $_params, $this);
      }
   }

This is how hooks are typically constructed. The main action happens in line 5
where the function :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`
is called. The user function is called with two arguments, an array with
variable parameters and the parent object.

In line 3 the contents of the parameter array is prepared. This is of
high interest to you because this is where you see what data is passed
to you and what data might be passed by reference and thereby
could be manipulated from your hook function.

Finally, notice how the array
:code:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib\_tcemain.php']['clearCachePostProc']`
is traversed and for each entry the value is expected to be a function
reference which will be called. This allows many hooks to be called at once.
The hooks can even rearrange the calling order if they dare.

The syntax of a function reference can be seen in the API documentation of
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility`.

.. note::

   The example hook shown above refers to old class names. All these old class
   names were left in hooks, for obvious reasons of backwards-compatibility.


.. _hooks-creation:

Creating Hooks
==============

You are encouraged to create hooks in your extensions if they seem
meaningful. Typically someone would request a hook somewhere. Before
you implement it, consider if it is the right place to put it. On
the one hand we want to have many hooks but not more than needed.
Redundant hooks or hooks which are implemented in the wrong context is
just confusing. So put a little thought into it first, but be
generous.

There are two main methods of calling a user defined function in
TYPO3.

- :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` - The classic way. Takes a
  file/class/method reference as value and calls that function. The
  argument list is fixed to a parameter array and a parent object. So
  this is the limitation. The freedom is that the reference defines the
  function name to call. This method is mostly useful for small-scale
  hooks in the sources.

- :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` - Create an
  object from a user defined
  file/class. The method called in the object is fixed by the hook, so
  this is the non-flexible part. But it is cleaner in other ways, in
  particular that you can even call many methods in the object and you
  can pass an arbitrary argument list which makes the API cleaner.
  You can also define the objects to be singletons,
  instantiated only once in the global scope.

Here are some examples:


.. _hooks-creation-object:

Using \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()
============================================================

Data submission to extensions::

   // Hook for processing data submission to extensions
   foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']
         ['checkDataSubmission'] ?? [] as $className) {
      $_procObj = GeneralUtility::makeInstance($className);
      $_procObj->checkDataSubmission($this);
   }


.. _hooks-creation-function:

Using with \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()
=====================================================================

Constructor post-processing::

      // Call post-processing function for constructor:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'])) {
      $_params = array('pObj' => &$this);
      foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'] as $_funcRef) {
         \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef,$_params, $this);
      }
   }


.. _hooks-configuration:

Hook Configuration
==================

There is no complete index of hooks in the core. But they are easy to
search for and find. And typically it comes quite naturally since you
will find the hooks in the code you want to extend - if they exist.

This index will list the main variable spaces for configuration of
hooks. By the names of these you can easily scan the source code to
find which hooks are available or might be interesting for you.

The index below also includes some variable spaces which not only
carry hook configuration but might be used for other purposes as well.


.. _hooks-extensions:

$GLOBALS['TYPO3\_CONF\_VARS']['EXTCONF']
========================================

**Configuration space for extensions.**

This will contain all kinds of configuration options for specific
extensions including possible hooks in them! What options are
available to you will depend on a search in the documentation for that
particular extension. ::

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][ extension_key ][ sub_key ] = value

- **extension\_key :** The unique extension key

- **sub\_key :** Whatever the script defines. Typically it identifies
  the context of the hook

- **value :** It is up to the extension what the values mean, if they
  are mere configuration options or hooks or whatever and how deep the
  arrays go. Read the source code where the options are implemented to
  see. Or the documentation of the extension, if available.

.. note::

   :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']` is the recommended place where to
   put hook configurations, which are processed inside of your extensions!

This example shows hooks used in the "linkvalidator" system extension.
The code looks inside the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']` array
for items listed under the "checkLinks" key of the "linkvalidator"
extension itself. All found classes are stored in an array, to be instantiated
and used at a later point. ::

   /**
    * Fill hookObjectsArr with different link types and possible XClasses.
    */
   public function __construct() {
         // Hook to handle own checks
      if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['linkvalidator']['checkLinks'])) {
         foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['linkvalidator']['checkLinks'] as $key => $classRef) {
            $this->hookObjectsArr[$key] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($classRef);
         }
      }
   }


.. _hooks-core:

$GLOBALS['TYPO3\_CONF\_VARS']['SC\_OPTIONS']
============================================

**Configuration space for core scripts.**

This array is created as an ad hoc space for creating hooks from any
script. This will typically be used from the core scripts of TYPO3
which do not have a natural identifier like extensions have their
extension keys. ::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][ main_key ][ sub_key ][ index ] = function_reference

- **main\_key :** The relative path of a script (for output scripts it
  should be the "script ID" as found in a comment in the HTML header )

- **sub\_key :** Whatever the script defines. Typically it identifies
  the context of the hook.

- **index :** Integer index typically. Can be unique string if you have
  a reason to use that. Normally it has no greater significance since
  the value of the key is not used. The hooks normally traverse over the
  array and uses only the value (function reference)

- **function\_reference :** A function reference using the syntax of
  :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` as a function
  or :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` as a class name
  depending on implementation of the hook.

  A namespace function has the quoted string format :php:`'Foo\\Bar\\MyClassName->myUserFunction'`
  or a format using an unquoted class name :php:`\Foo\Bar\MyClassName::class . '->myUserFunction'`.
  The latter is available since PHP 5.5.

  A namespace class name can be in the FQCN quoted string format :php:`'Foo\\Bar\\MyClassName'`,
  or in the unquoted form :php:`\Foo\Bar\MyClassName::class`. The called function name
  is determined by the hook itself.

  Leading backslashes for class names are not allowed and lead to an error.

The above syntax is how a hook is typically defined but it might
differ and it might not be a hook at all, but just configuration.
Depends on implementation in any case.

The following example shows a hook from :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`. In this case the
function :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` is used for the hook. The
function\_reference is referring to the class name only since the
function returns an object instance of that class. The method name to
call is predefined by the hook, in this case
:php:`sendFormmail_preProcessVariables()`. This method allows to pass any
number of variables along instead of the limited :php:`$params` and :php:`$pObj`
variables from :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`. ::

    // Hook for preprocessing of the content for formmails:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'])) {
       foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'] as $_classRef) {
           $_procObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($_classRef);
           $EMAIL_VARS = $_procObj->sendFormmail_preProcessVariables($EMAIL_VARS, $this);
       }
   }

In this example we are looking at a special hook, namely the one for
RTE transformations. It is not a "hook" in the strict
sense, but the same principles are used. In this case the "index" key
is defined to be the transformation key name, not a random integer
since we do not iterate over the array as usual.
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` is also used. ::

    if ($className = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation'][$cmd]) {
        $_procObj = GeneralUtility::makeInstance($className);
        $_procObj->pObj = $this;
        $_procObj->transformationKey = $cmd;
        $value = $_procObj->transform_db($value, $this);
    }

A classic hook also from :php:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`. This one is based on
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` and it passes a reference to :php:`$this`
along to the function via :php:`$_params`. In the user-defined function
:php:`$_params['pObj']->content` is meant to be manipulated in some way. The
return value is insignificant - everything works by the reference to
the parent object. ::

       // Hook for post-processing of page content cached/non-cached:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'])) {
       $_params = array('pObj' => &$this);
       foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'] as $_funcRef) {
           \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef, $_params, $this);
       }
   }


.. _hooks-modules:

$GLOBALS['TYPO3\_CONF\_VARS']['TBE\_MODULES\_EXT']
==================================================

**Configuration space for backend modules.**

Among these configuration options you might find entry points for
hooks in the backend. This somehow overlaps the intention of
:php:`SC_OPTIONS` above but this array is an older invention and slightly
outdated. ::

   $TBE_MODULES_EXT[ backend_module_key ][ sub_key ] = value

- **backend\_module\_key :** The backend module key for which the
  configuration is used.

- **sub\_key :** Whatever the backend module defines.

- **value :** Whatever the backend module defines.

The following example shows :php:`TBE_MODULES_EXT` being used for adding
items to the Context Sensitive Menus (Clickmenu) in the backend. The
hook value is an array with a key pointing to a file reference to
class file to include. Later each class is instantiated and a fixed
method inside is called to do processing on the array of menu items.
This kind of hook is non-standard in the way it is made.

.. warning::
   The API for registering context-sensitive menus was changed completely
   in TYPO3 4.5.

::

       // Setting internal array of classes for extending the clickmenu:
   $this->extClassArray = $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'];

       // Traversing that array and setting files for inclusion:
   if (is_array($this->extClassArray)) {
       foreach($this->extClassArray as $extClassConf) {
           if ($extClassConf['path'])    $this->include_once[]=$extClassConf['path'];
       }
   }

The following code listings works in the same way. First, a list of
class files to include is registered. Then in the second code listing
the same array is traversed and each class is instantiated and a fixed
function name is called for processing. ::

       // Setting class files to include:
   if (is_array($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
       $this->include_once = array_merge($this->include_once,$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']);
   }

       // PLUG-INS:
   if (is_array($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
       reset($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']);
       while(list($class,$path)=each($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
           $modObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($class);
           $wizardItems = $modObj->proc($wizardItems);
       }
   }

