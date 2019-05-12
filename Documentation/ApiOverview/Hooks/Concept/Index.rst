.. include:: ../../../Includes.txt



.. _hooks-concept:

====================================
The concept of "hooks" and "signals"
====================================

Hooks and Signals provide an easy way to extend the functionality of TYPO3 and
its extensions without blocking others to do the same. Hooks are basically
places in the source code where a user function will be called for processing
if such has been configured. Signals roughly follow the observer pattern.
Signals and slots decouple the sender (sending a signal) and the receiver(s)
(called slots). The sender sends a signal - like "database updated" - and all
receivers listening to that signal will be executed.


.. _hooks-xclass:

Hooks and Signals vs. XCLASS extensions
=======================================

Hooks or Signals are the recommended way of extending TYPO3 compared to
extending PHP classes with a child class (see "XCLASS extensions"). Because
only one extension of a PHP class can exist at a time while hooks and signals
may allow many different user-designed processor functions to be executed.
However, hooks and signals have to be implemented in the TYPO3 core before you
can use them, while extending a PHP class via the XCLASS method allows you to
extend any class you like.


.. _hooks-proposing:

Proposing hooks or signals
==========================

If you need to extend something which has no hook or signal yet, then you
should suggest implementing one. Normally that is rather easily done by the
author of the source you want to extend.


.. _hooks-basics:

Using hooks
===========

The two lines of code below are an example of how a hook is used for
clear-cache post-processing. The objective of this could be to perform
additional actions whenever the cache is cleared for a specific page. ::

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
to you and what data might possibly be passed by reference and thereby
possible to manipulate from your hook function.

Finally, notice how the array
:code:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib\_tcemain.php']['clearCachePostProc']`
is traversed and for each entry the value is expected to be a function
reference which will be called. This allows many hooks to be called at the same
place. The hooks can even rearrange the calling order if they dare.

The syntax of a function reference can be seen in the API documentation of
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility`.

.. note::

   The example hook shown above refers to old class names. All these old class
   names were left in hooks, for obvious reasons of backwards-compatibility.


.. _signals-basics:

Using Signals
=============

To connect a slot to a signal, use the :php:`\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::connect()` method.
This method accepts the following arguments:

1. :php:`$signalClassName`: Name of the class containing the signal
2. :php:`$signalName`: Name of the class containing the signal
3. :php:`$slotClassNameOrObject`: Name of the class containing the slot or the instantiated class or a :php:`\Closure` object
4. :php:`$slotMethodName`: Name of the method to be used as a slot. If :php:`$slotClassNameOrObject` is a :php:`\Closure` object, this parameter is ignored and can be skipped
5. :php:`$passSignalInformation`: If set to :php:`true`, the last argument passed to the slot will be information about the signal (:php:`EmitterClassName::signalName`)

Usage example:

.. code-block:: php
   :linenos:

   $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::
      makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
   $signalSlotDispatcher->connect(
     \TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class,  // Signal class name
     'afterExtensionUninstall',                                  // Signal name
     \TYPO3\CMS\Core\Core\ClassLoadingInformation::class,        // Slot class name
     'dumpClassLoadingInformation'                               // Slot name
   );

In this example, we define that we want to call the method
:php:`dumpClassLoadingInformation` of the class
:php:`\TYPO3\CMS\Core\Core\ClassLoadingInformation::class` when the signal
:php:`afterExtensionUninstall` of the class
:php:`\TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class` is dispatched.

To find out which parameters/variables are available, open the signal's class
and take a look at the dispatch call:

:php:`$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterExtensionUninstall', [$extensionKey, $this]);`

In this case, the :php:`dumpClassLoadingInformation` method will get the
extension key and an instance of the dispatching class as parameters.


Finding Signals
===============

There is no complete list of signals available, but they are easily found by
searching the TYPO3 core for :php:`dispatch(`.

For finding hooks, look into the next chapter :ref:`hooks-configuration`.
