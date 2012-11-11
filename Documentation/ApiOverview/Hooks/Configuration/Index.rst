.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt



.. _hooks-configuration:

Hook configuration
^^^^^^^^^^^^^^^^^^

There is no complete index of hooks in the core. But they are easy to
search for and find. And typically it comes quite naturally since you
will find the hooks in the code you want to extend - if they exist.

This index will list the main variable spaces for configuration of
hooks. By the names of these you can easily scan the source code to
find which hooks are available or might be interesting for you.

The index below also includes some variable spaces which do not only
carry hook configuration but might be used for other purposes as well.


.. _hooks-extensions:

$TYPO3\_CONF\_VARS['EXTCONF']
"""""""""""""""""""""""""""""

**Configuration space for extensions.**

This will contain all kinds of configuration options for specific
extensions including possible hooks in them! What options are
available to you will depend on a search in the documentation for that
particular extension. ::

   $TYPO3_CONF_VARS['EXTCONF'][ extension_key ][ sub_key ] = value

- **extension\_key :** The unique extension key

- **sub\_key :** Whatever the script defines. Typically it identifies
  the context of the hook

- **value :** It is up to the extension what the values mean, if they
  are mere configuration options or hooks or whatever and how deep the
  arrays go. Read the source code where the options are implemented to
  see. Or the documentation of the extension, if available.

.. note::

   :code:`$TYPO3_CONF_VARS['EXTCONF']` is the recommended place to
   put hook configuration that are available inside your extensions!

This example shows hooks used in the "linkvalidator" system extension.
The code looks inside the :code:`$TYPO3_CONF_VARS['EXTCONF']` array
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
				$this->hookObjectsArr[$key] = t3lib_div::getUserObj($classRef);
			}
		}
	}


.. _hooks-core:

$TYPO3\_CONF\_VARS['SC\_OPTIONS']
"""""""""""""""""""""""""""""""""

**Configuration space for core scripts.**

This array is created as an ad hoc space for creating hooks from any
script. This will typically be used from the core scripts of TYPO3
which do not have a natural identifier like extensions have their
extension keys. ::

   $TYPO3_CONF_VARS['SC_OPTIONS'][ main_key ][ sub_key ][ index ] = function_reference

- **main\_key :** The relative path of a script (for output scripts it
  should be the "script ID" as found in a comment in the HTML header )

- **sub\_key :** Whatever the script defines. Typically it identifies
  the context of the hook.

- **index :** Integer index typically. Can be unique string if you have
  a reason to use that. Normally it has no greater significance since
  the value of the key is not used. The hooks normally traverse over the
  array and uses only the value (function reference)

- **function\_reference :** A function reference using the syntax of
  :code:`t3lib_div::callUserFunction()` or :code:`t3lib_div::getUserObj()`
  depending on implementation of the hook.

The above syntax is how a hook is typically defined but it might
differ and it might not be a hook at all, but just configuration.
Depends on implementation in any case.

The following example shows a hook from :code:`tslib_fe`. In this case the
function :code:`t3lib_div::getUserObj()` is used for the hook. The
function\_reference is referring to the class name only since the
function returns an object instance of that class. The method name to
call is predefined by the hook, in this case
:code:`sendFormmail_preProcessVariables()`. This method allows to pass any
number of variables along instead of the limited :code:`$params` and :code:`$pObj`
variables from :code:`t3lib_div::callUserFunction()`. ::

       // Hook for preprocessing of the content for formmails:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'])) {
       foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'] as $_classRef) {
           $_procObj = &t3lib_div::getUserObj($_classRef);
           $EMAIL_VARS = $_procObj->sendFormmail_preProcessVariables($EMAIL_VARS, $this);
       }
   }

In this example we are looking at a special hook, namely the one for
RTE transformations. It is not a "hook" in the strict
sense, but the same principles are used. In this case the "index" key
is defined to be the transformation key name, not a random integer
since we do not iterate over the array as usual.
:code:`t3lib_div::getUserObj()` is also used. ::

   if ($_classRef = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation'][$cmd]) {
       $_procObj = &t3lib_div::getUserObj($_classRef);
       $_procObj->pObj = &$this;
       $_procObj->transformationKey = $cmd;
       $value = $_procObj->transform_db($value, $this);
   }

A classic hook also from :code:`tslib_fe`. This one is based on
:code:`t3lib_div::callUserFunction()` and it passes a reference to :code:`$this`
along to the function via :code:`$_params`. In the user-defined function
:code:`$_params['pObj']->content` is meant to be manipulated in some way. The
return value is insignificant - everything works by the reference to
the parent object. ::

       // Hook for post-processing of page content cached/non-cached:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'])) {
       $_params = array('pObj' => &$this);
       foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'] as $_funcRef) {
           t3lib_div::callUserFunction($_funcRef, $_params, $this);
       }
   }


.. _hooks-modules:

$TYPO3\_CONF\_VARS['TBE\_MODULES\_EXT']
"""""""""""""""""""""""""""""""""""""""

** Configuration space for backend modules.**

Among these configuration options you might find entry points for
hooks in the backend. This somehow overlaps the intention of
:code:`SC_OPTIONS` above but this array is an older invention and slightly
outdated. ::

   $TBE_MODULES_EXT[ backend_module_key ][ sub_key ] = value

- **backend\_module\_key :** The backend module key for which the
  configuration is used.

- **sub\_key :** Whatever the backend module defines.

- **value :** Whatever the backend module defines.

The following example shows :code:`TBE_MODULES_EXT` being used for adding
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
           $modObj = t3lib_div::makeInstance($class);
           $wizardItems = $modObj->proc($wizardItems);
       }
   }

