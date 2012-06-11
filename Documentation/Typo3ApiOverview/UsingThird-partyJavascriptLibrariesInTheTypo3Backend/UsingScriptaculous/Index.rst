

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


Using Scriptaculous
^^^^^^^^^^^^^^^^^^^

To load the Scriptaculous library use this syntax:

::

   $this->doc->loadScriptaculous();

To load modules, just pass some module's name to the above call.
Possible modules are: “builder”, “effects”, “dragdrop”, “controls”,
“slider”.


((generated))
"""""""""""""

Example:
~~~~~~~~

::

   $this->doc->loadScriptaculous('slider');
   $this->doc->loadScriptaculous('effects,dragdrop');

If a module depends on other modules, those will automatically be
added. The calling order doesn't matter. Proper load order is taken
care of by the API.

To load all available modules, use the keyword “all”:

::

   $this->doc->loadScriptaculous('all');

When loading Scriptaculous, Prototype is automatically added.

