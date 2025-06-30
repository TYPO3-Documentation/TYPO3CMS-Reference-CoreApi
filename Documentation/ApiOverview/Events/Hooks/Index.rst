..  include:: /Includes.rst.txt
..  index:: ! Hooks
..  _hooks-general:

=====
Hooks
=====

Hooks are basically places in the source code where a user function will be
called for processing, if such has been configured. While there are conventions
and best practises of how hooks should be implemented the hook concept itself
does not prevent it from being used in any way.

Hooks are being phased-out and no new ones should be created. Dispatch a
:ref:`PSR-14 event <EventDispatcher>` instead.


..  index::
    Hooks;  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']
    Hooks; Usage
    TYPO3_CONF_VARS; SC_OPTIONS
..  _hooks-basics:

Using hooks
===========

The two lines of code below are an example of how a hook can be used for
clear-cache post-processing. The objective of this could be to perform
additional actions whenever the cache is cleared for a specific page:

..  literalinclude:: _ext_localconf_addhook.php
    :language: php
    :caption: EXT:site_package/ext_localconf.php

This hook registers the class/method name to a hook inside of
:php:`\TYPO3\CMS\Core\DataHandling\DataHandler`. The hook calls the user
function after the cache has been cleared. The user function
will receive parameters which allows it to see what clear-cache action was
performed and typically also an object reference to the parent object. Then the
user function can take additional actions as needed.

The class has to follow the PSR-4 class name scheme to be available in
:ref:`autoloading <autoloading_classes>`.

If we take a look inside of :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` we
find the hook to be activated like this:

..  literalinclude:: _DataHandler.php
    :language: php
    :caption: :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` (excerpt)

This is how hooks are typically constructed. The main action happens in line 5
where the function :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`
is called. The user function is called with two arguments, an array with
variable parameters and the parent object.

In line 24 the content of the parameter array is prepared. This is of
high interest to you because this is where you see what data is passed
to you and what data might be passed by reference and thereby
could be manipulated from your hook function.

Finally, notice how the array
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']`
is traversed and for each entry the value is expected to be a function
reference which will be called. This allows many hooks to be called at once.
The hooks can even rearrange the calling order if they dare.

The syntax of a function reference can be seen in the API documentation of
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility`.

..  note::

    The example hook shown above refers to old class names. All these old class
    names were left in hooks, for obvious reasons of backwards-compatibility.

..  index::
    GeneralUtility; callUserFunction
    Hooks; Creation
..  _hooks-creation:

Creating hooks
==============

..  note::
    It is highly recommended to dispatch `PSR-14 events
    <EventDispatcherQuickStartDispatching>` instead of introducing new hooks.
    Existing hooks should be migrated to events.

There are two main methods of calling a user-defined function in
TYPO3.

:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`
    Takes a reference to a function in a PHP class reference as value
    and calls that function. The argument list is fixed to a parameter array
    and a parent object.

:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`
    Creates an object from a user-defined
    PHP class. The method to be called is defined by the implementation of
    the hook.

Here are some examples:

..  _hooks-creation-object:

Using `\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`
--------------------------------------------------------------

Data submission to extensions:

..  literalinclude:: _SomeClass.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeClass.php

..  _hooks-creation-function:

Using with `\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()`
-----------------------------------------------------------------------

Constructor post-processing:

..  literalinclude:: _SomeClassPostProc.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeClass.php

..  index:: Hooks; Configuration
..  _hooks-configuration:

Hook configuration
==================

Most hooks in the TYPO3 Core have been converted into PSR-14 events which are
completely listed in the :ref:`event list <eventlist>`.

There is no complete index of the remaining hooks in the Core. The following
naming scheme should be used:

..  index::
    Hooks;  $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']
    pair: Hooks; Extensions
..  _hooks-extensions:

$GLOBALS['TYPO3\_CONF\_VARS']['EXTCONF']
----------------------------------------

**Configuration space for third-party extensions.**

This will contain all kinds of configuration options for specific
extensions including possible hooks in them! What options are
available to you will depend on a search in the documentation for that
particular extension.

..  literalinclude:: _ext_localconf_schema.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

`<extension_key>`
    The unique extension key

`<sub_key>`
    Whatever the script defines. Typically it identifies
    the context of the hook

`<value>`
    It is up to the extension what the values mean, if they
    are mere configuration options or hooks or whatever and how deep the
    arrays go. Read the source code where the options are implemented to
    see. Or the documentation of the extension, if available.

..  note::

    :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']` was the recommended place where to
    put hook configurations inside third-party extensions. It is not recommended anymore
    to introduce new hooks. :ref:`Events <EventDispatcher>` should be used instead.


..  index::
    Hooks;  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']
    pair: Hooks; Core
..  _hooks-core:

$GLOBALS['TYPO3\_CONF\_VARS']['SC\_OPTIONS']
============================================

**Configuration space for Core extensions.**

This array is created as an ad hoc space for creating hooks from any
script. This will typically be used from the Core scripts of TYPO3
which do not have a natural identifier like extensions have their
extension keys.

..  literalinclude:: _ext_localconf_schema_core.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

`<main_key>`
    The relative path of a script (for output scripts it
    should be the "script ID" as found in a comment in the HTML header)

`<sub_key>`
    This is defined by the script. Typically it identifies
    the context of the hook.

`<index>`
    Integer index typically. Can be a unique string, if you have
    a reason to use that. Normally it has no greater significance since
    the value of the key is not used. The hooks normally traverse over the
    array and uses only the value (function reference).

`<function_reference>`
    A function reference using the syntax of
    :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` as a function
    or :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` as a class name
    depending on implementation of the hook.

    A namespace function has the format :php:`\Foo\Bar\MyClassName::class . '->myUserFunction'`.

    A namespace class should be used in the unquoted form, for example
    :php:`\Foo\Bar\MyClassName::class`. The called function name is determined
    by the hook itself.

The above syntax is how a hook is typically defined but it might
differ and it might not be a hook at all, but just configuration.
Depends on implementation in any case.
