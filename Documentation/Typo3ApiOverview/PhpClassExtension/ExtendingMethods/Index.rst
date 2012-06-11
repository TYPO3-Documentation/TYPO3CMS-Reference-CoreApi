

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


Extending methods
^^^^^^^^^^^^^^^^^

When extending a method like in the case above with stdWrap() please
observe that such a method might gain new parameters in the future
without further notice. For instance stdWrap is currently defined like
this:

::

      function stdWrap($content, $conf) {

... but maybe some day this method will have another parameter added,
eg:

::

      function stdWrap($content, $conf, $yet_a_parameter=0) {

This means if you want to override stdWrap(), but still call the
parent class' method, you must extend your own method call from...:

::

       function stdWrap($content, $conf) {
               // Call the real stdWrap method in the parent class:
           $content = parent::stdWrap($content, $conf);

:code:`...`

... to:

::

       function stdWrap($content, $conf, $yet_a_parameter=0) {
               // Call the real stdWrap method in the parent class:
           $content = parent::stdWrap($content, $conf,$ yet_a_parameter);
       ...
   

Also be aware of constructors. If you have a constructor in your
extension class you must observe if there is a constructor in the
parent class which you should call first / after. In case, you can do
it by “parent::[original class name]”

For instance the class tslib\_fe is instantiated into the global
object $TSFE. This class has a constructor looking like this:

::

   /** 
    * Class constructor
    */
   function tslib_fe($TYPO3_CONF_VARS, $id, $type, $no_cache='', $cHash='', $jumpurl='') {
           // Setting some variables:
       $this->id = $id;
       $this->type = $type;
       $this->no_cache = $no_cache ? 1 : 0;
       $this->cHash = $cHash;
       $this->jumpurl = $jumpurl;
       $this->TYPO3_CONF_VARS = $TYPO3_CONF_VARS;
       $this->clientInfo = t3lib_div::clientInfo();
       $this->uniqueString=md5(microtime());
       $this->makeCacheHash();
   }

So as you see, you probably want to call this method. But let's also
say you wish to make sure the $no\_cache parameter is always set to 1
(for some strange reason...). So you make an extension class like this
with a new constructor, ux\_tslib\_fe(), overriding the $no\_cache
variable and then calling the parent class constructor:

::

   class ux_tslib_fe extends tslib_fe {
    function ux_tslib_fe($TYPO3_CONF_VARS, $id, $type, $no_cache='', $cHash='', $jumpurl='') {
        $no_cache=1;
        parent::tslib_fe($TYPO3_CONF_VARS, $id, $type, $no_cache, $cHash, $jumpurl);
    }
   }

