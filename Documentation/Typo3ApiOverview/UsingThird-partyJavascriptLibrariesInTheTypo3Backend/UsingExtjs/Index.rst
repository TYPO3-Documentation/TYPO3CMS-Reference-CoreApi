

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


Using ExtJS
^^^^^^^^^^^

To load the ExtJS library use this syntax:

::

   $this->doc->loadExtJS();

There are 2 optional parameters in this call:

::

   $this->doc->loadExtJS($css = TRUE, $theme = TRUE);

- The first parameter is a boolean. If set to true, "ext-all.css" is
  added automatically.

- The second parameter is also a boolean. If set to true, theme-grey is
  added automatically.

Additionally the function takes care of:

- adding the correct adapter

- adding the localization file of BE-User language

- adding Ext.BLANK\_IMAGE\_URL

To do debugging in the ExtJS library, use the following call to force
the debug variant to be loaded:

::

   $this->doc->setExtJSdebug();

