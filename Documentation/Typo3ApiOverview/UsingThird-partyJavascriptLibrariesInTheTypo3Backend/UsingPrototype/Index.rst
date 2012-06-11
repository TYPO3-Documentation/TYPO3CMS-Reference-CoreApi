

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


Using Prototype
^^^^^^^^^^^^^^^

To load the Prototype library use this syntax:

::

   $this->doc->loadPrototype();

That's all, prototype will be added to the head of the document, any
double inclusion will be prevented.

