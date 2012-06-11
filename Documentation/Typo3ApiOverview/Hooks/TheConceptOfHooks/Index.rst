

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


The concept of "hooks"
^^^^^^^^^^^^^^^^^^^^^^

Hooks are basically places in the source code where a user function
will be called for processing if such has been configured. Hooks
provide a way to extend functionality of TYPO3 and extensions easily
and without blocking for others to do the same.


Hooks vs. XCLASS extensions
"""""""""""""""""""""""""""

Hooks are the recommended way of extending TYPO3 compared to extending
the PHP classes with a child class (see "XCLASS extensions"). It is so
because only one extension of a PHP class can exist at a time while
hooks may allow many different user-designed processing functions to
occur. On the other hand hooks have to be implemented in the core
before you can use them while extending a PHP class via the XCLASS
method allows you to extend anything spontaneously.


Proposing hooks
"""""""""""""""

If you need to extend something which has no hook yet, then you should
suggest implementing a hook. Normally that is rather easily done by
the author of the source you want to extend.


How a hook looks
""""""""""""""""

The two lines of code below are an example of how a hook is used for
clear-cache post-processing. The objective of this need could be to
perform additional actions whenever the cache is cleared for a
specific page.

::

   require_once(t3lib_extMgm::extPath('myext') . 'class.myext_cacheProc.php');
   $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'myext_cacheProc->proc';

Line 1 includes a class which contains the user-defined PHP code to be
called by the hook.

Line 2 registers the class/method name from the included file with a
hook inside of "t3lib\_TCEmain". The hook will call the user function
after the clear-cache command has been executed. The user function
will receive parameters which allows it to see what clear-cache action
was performed and typically also an object reference to the parent
object. Then the user function can take additional actions as needed.

If we take a look inside of t3lib\_TCEmain we find the hook to be
activated like this:

::

      1:     // Call post processing function for clear-cache:
      2: if (is_array($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']))    {
      3:     $_params = array('cacheCmd' => $cacheCmd);
      4:     foreach($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'] as $_funcRef)    {
      5:         t3lib_div::callUserFunction($_funcRef, $_params, $this);
      6:     }
      7: }

This is how hooks are typically constructed. The main action happens
in line 5 where the function "t3lib\_div::callUserFunction()" is
called. The user function is called with two arguments, an array with
variable parameters and the parent object.

In line 3 the contents of the parameter array is prepared. This is of
high interest to you because this is where you see what data is passed
to you and what data might possibly be passed by reference and thereby
possible to manipulate from your hook function.

Finally, notice how the array $TYPO3\_CONF\_VARS['SC\_OPTIONS']['t3lib
/class.t3lib\_tcemain.php']['clearCachePostProc'] is traversed and for
each entry the value is expected to be a function reference which will
be called. This allows many hooks to be called at the same place. The
hooks can even rearrange the calling order if they dare.

The syntax of a function reference (or object reference if
t3lib\_div::getUserObj is used in the hook instead) can be seen in the
API documentation of t3lib\_div.

