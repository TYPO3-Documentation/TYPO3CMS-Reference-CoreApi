.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _hooks-concept:

The concept of "hooks"
^^^^^^^^^^^^^^^^^^^^^^

Hooks are basically places in the source code where a user function
will be called for processing if such has been configured. Hooks
provide a way to extend functionality of TYPO3 and extensions easily
and without blocking for others to do the same.


.. _hooks-xclass:

Hooks vs. XCLASS extensions
"""""""""""""""""""""""""""

Hooks are the recommended way of extending TYPO3 compared to extending
the PHP classes with a child class (see "XCLASS extensions"). It is so
because only one extension of a PHP class can exist at a time while
hooks may allow many different user-designed processing functions to
occur. On the other hand hooks have to be implemented in the core
before you can use them while extending a PHP class via the XCLASS
method allows you to extend anything spontaneously.


.. _hooks-proposing:

Proposing hooks
"""""""""""""""

If you need to extend something which has no hook yet, then you should
suggest implementing a hook. Normally that is rather easily done by
the author of the source you want to extend.


.. _hooks-basics:

How a hook looks
""""""""""""""""

The two lines of code below are an example of how a hook is used for
clear-cache post-processing. The objective of this need could be to
perform additional actions whenever the cache is cleared for a
specific page. ::

   $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'myext_cacheProc->proc';

This registers the class/method name to a
hook inside of :code:`\TYPO3\CMS\Core\DataHandling\DataHandler`. The hook will call the user function
after the clear-cache command has been executed. The user function
will receive parameters which allows it to see what clear-cache action
was performed and typically also an object reference to the parent
object. Then the user function can take additional actions as needed.

The class has to be declared with the TYPO3 autoloader.

If we take a look inside of :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` we find the hook to be
activated like this:

.. code-block:: php
   :linenos:

       // Call post processing function for clear-cache:
   if (is_array($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'])) {
       $_params = array('cacheCmd' => $cacheCmd);
       foreach($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'] as $_funcRef) {
           \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef, $_params, $this);
       }
   }

This is how hooks are typically constructed. The main action happens
in line 5 where the function :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` is
called. The user function is called with two arguments, an array with
variable parameters and the parent object.

In line 3 the contents of the parameter array is prepared. This is of
high interest to you because this is where you see what data is passed
to you and what data might possibly be passed by reference and thereby
possible to manipulate from your hook function.

Finally, notice how the array
:code:`$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib\_tcemain.php']['clearCachePostProc']`
is traversed and for each entry the value is expected to be a function reference which will
be called. This allows many hooks to be called at the same place. The
hooks can even rearrange the calling order if they dare.

The syntax of a function reference (or object reference if
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj` is used in the hook instead) can be seen in the
API documentation of :code:`\TYPO3\CMS\Core\Utility\GeneralUtility`.

.. note::
   The example hook shown above refers to old class names. All these old class
   names were left in hooks, for obvious reasons of backwards-compatibility.
