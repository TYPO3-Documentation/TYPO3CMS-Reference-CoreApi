.. include:: ../../Includes.txt


.. _typoscript-syntax-constants:

Constants
^^^^^^^^^


.. _typoscript-syntax-what-are-constants:

What are constants?
"""""""""""""""""""

Constants are values defined in the "Constants" field of a template.
They follow the :ref:`syntax of ordinary TypoScript <typoscript-syntax-syntax>` and are
case sensitive! They are used to manage *in a single place* values,
which are later used in *several places*.

.. note::

   **Reserved name**

   The object or property "file" is always interpreted as data type
   ":ref:`resource <t3tsref:data-type-resource>`". That means it refers
   to a file, which you have to upload in your TYPO3 CMS installation.


Example
~~~~~~~

Here :code:`bgCol` is set to "red", :code:`file.toplogo` is set to
"fileadmin/logo.gif" and :code:`topimg.file.pic2` is set to
"fileadmin/logo2.gif", assuming these files are indeed available
at the expected location.

.. code-block:: typoscript
   :emphasize-lines: 3,4

   bgCol = red
   topimg.width = 200
   topimg.file.pic2 = fileadmin/logo2.gif
   file.toplogo = fileadmin/logo.gif

This could also be defined in other ways, e.g. like this:

.. code-block:: typoscript
   :emphasize-lines: 2,7

   bgCol = red
   file {
     toplogo = fileadmin/logo.gif
   }
   topimg {
     width = 200
     file.pic2 = fileadmin/logo2.gif
   }

(The objects in the highlighted lines contain the reserved word "file"
and the properties are always of data type ":ref:`resource <t3tsref:data-type-resource>`".)

.. figure:: ../Images/TemplatesConstants.png
   :alt: Overview of the defined constants


The :code:`module` constant which is visible in the above screenshot
comes from the TYPO3 CMS core itself.
