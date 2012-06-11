

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


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


$TYPO3\_CONF\_VARS['EXTCONF']
"""""""""""""""""""""""""""""

**Configuration space for extensions.**

This will contain all kinds of configuration options for specific
extensions including possible hooks in them! What options are
available to you will depend on a search in the documentation for that
particular extension.

::

   $TYPO3_CONF_VARS['EXTCONF'][ extension_key ][ sub_key ] = value

- **extension\_key :** The unique extension key

- **sub\_key :** Whatever the script defines. Typically it identifies
  the context of the hook

- **value :** It is up to the extension what the values mean, if they
  are mere configuration options or hooks or whatever and how deep the
  arrays go. Read the source code where the options are implemented to
  see. Or the documentation of the extension, if available.

**Notice:** $TYPO3\_CONF\_VARS['EXTCONF'] is the recommended place to
put hook configuration that are available inside your extensions!

Here is an example of how the EXTCONF array is used inside an
extension. Notice, this example is  *not* a hook (sorry, couldn't find
a better example) but it is based on the same principles. It is just
an example of configuration of additional "root line fields" that can
be used during indexing (line 8-12). It shows the versatility of the
EXTCONF array:

::

      1: function getRootLineFields(&$fieldArr)    {
      2:     $rl = $this->rootLevel;
      3: 
      4:     $fieldArr['rl0'] = intval($rl[0]['uid']);
      5:     $fieldArr['rl1'] = intval($rl[1]['uid']);
      6:     $fieldArr['rl2'] = intval($rl[2]['uid']);
      7: 
      8:     if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['indexed_search']['addRootLineFields']))    {
      9:         foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['indexed_search']['addRootLineFields'] as $fieldName => $rootLineLevel)    {
     10:             $fieldArr[$fieldName] = intval($rl[$rootLineLevel]['uid']);
     11:         }
     12:     }
     13: }


$TYPO3\_CONF\_VARS['SC\_OPTIONS']
"""""""""""""""""""""""""""""""""

**Configuration space for core scripts.**

This array is created as an ad hoc space for creating hooks from any
script. This will typically be used from the core scripts of TYPO3
which do not have a natural identifier like extensions have their
extension keys.

::

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
  t3lib\_div::callUserFunction() or t3lib\_div::getUserObj() depending
  on implementation of the hook.

The above syntax is how a hook is typically defined but it might
differ and it might not be a hook at all, but just configuration.
Depends on implementation in any case.

The following example shows a hook from tslib\_fe. In this case the
function t3lib\_div::getUserObj() is used for the hook. The
function\_reference is referring to the class name only since the
function returns an object instance of that class. The method name to
call is predefined by the hook, in this case
"sendFormmail\_preProcessVariables()". This method allows to pass any
number of variables along instead of the limited $params and $pObj
variables from t3lib\_div::callUserFunction().

::

      1:     // Hook for preprocessing of the content for formmails:
      2: if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'])) {
      3:     foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'] as $_classRef) {
      4:         $_procObj = &t3lib_div::getUserObj($_classRef);
      5:         $EMAIL_VARS = $_procObj->sendFormmail_preProcessVariables($EMAIL_VARS, $this);
      6:     }
      7: }

In this example we are looking at a special hook, namely the one for
RTE transformations. Well, maybe this is not a "hook" in the normal
sense, but the same principles are used. In this case the "index" key
is defined to be the transformation key name, not a random integer
since we do not iterate over the array as usual. In this case
t3lib\_div::getUserObj() is also used.

::

      1: if ($_classRef = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation'][$cmd]) {
      2:     $_procObj = &t3lib_div::getUserObj($_classRef);
      3:     $_procObj->pObj = &$this;
      4:     $_procObj->transformationKey = $cmd;
      5:     $value = $_procObj->transform_db($value, $this);
      6: }

A classic hook also from tslib\_fe. This is also based on
t3lib\_div::callUserFunction() and it passes a reference to $this
along to the function via $\_params. In the user defined function
$\_params['pObj']->content is meant to be manipulated in some way. The
return value is insignificant - everything works by the reference to
the parent object.

::

      1:     // Hook for post-processing of page content cached/non-cached:
      2: if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'])) {
      3:     $_params = array('pObj' => &$this);
      4:     foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'] as $_funcRef) {
      5:         t3lib_div::callUserFunction($_funcRef, $_params, $this);
      6:     }
      7: }


$TYPO3\_CONF\_VARS['TBE\_MODULES\_EXT']
"""""""""""""""""""""""""""""""""""""""

Configuration space for backend modules.

Among these configuration options you might find entry points for
hooks in the backend. This somehow overlaps the intention of
"SC\_OPTIONS" above but this array is an older invention and slightly
outdated.

::

   $TBE_MODULES_EXT[ backend_module_key ][ sub_key ] = value

- **backend\_module\_key :** The backend module key for which the
  configuration is used.

- **sub\_key :** Whatever the backend module defines.

- **value :** Whatever the backend module defines.

The following example shows TBE\_MODULES\_EXT being used for adding
items to the Context Sensitive Menus (Clickmenu) in the backend. The
hook value is an array with a key pointing to a file reference to
class file to include. Later each class is instantiated and a fixed
method inside is called to do processing on the array of menu items.
This kind of hook is non-standard in the way it is made.

::

      1:     // Setting internal array of classes for extending the clickmenu:
      2: $this->extClassArray = $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'];
      3: 
      4:     // Traversing that array and setting files for inclusion:
      5: if (is_array($this->extClassArray)) {
      6:     foreach($this->extClassArray as $extClassConf) {
      7:         if ($extClassConf['path'])    $this->include_once[]=$extClassConf['path'];
      8:     }
      9: }

The following code listings works in the same way. First, a list of
class files to include is registered. Then in the second code listing
the same array is traversed and each class is instantiated and a fixed
function name is called for processing.

::

      1:     // Setting class files to include:
      2: if (is_array($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
      3:     $this->include_once = array_merge($this->include_once,$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']);
      4: }
   
      1:     // PLUG-INS:
      2: if (is_array($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
      3:     reset($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']);
      4:     while(list($class,$path)=each($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'])) {
      5:         $modObj = t3lib_div::makeInstance($class);
      6:         $wizardItems = $modObj->proc($wizardItems);
      7:     }
      8: }

