.. include:: /Includes.rst.txt
.. highlight:: xml
.. _fluid-syntax:

============
Fluid syntax
============

.. _fluid-variables:

Variables
=========

Assign a variable in PHP:

.. code-block:: php

   $this->view->assign('title', 'An example title');

Output it in a Fluid template::

   <h1>{title}</h1>

The result::

   <h1>An example title</h1>

In the template's HTML code, simply wrap the variable name into curly
braces to output it:

.. _fluid-arrays:

Arrays and objects
------------------

Assign an array in PHP:

.. code-block:: php

   $this->view->assign('data', ['Low', 'High']);

Use the dot ``.`` to access array keys:

.. code-block:: html
   :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

   <p>{data.0}, {data.1}</p>

This also works for object properties:

.. code-block:: php
   :caption: EXT:site_package/Classes/Controller/SomeController.php

   $this->view->assign('product', $myProduct);

Use it like this:

.. code-block:: html
   :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

   <p>{product.name}: {product.price}</p>


Accessing dynamic keys/properties
---------------------------------

It is possible to access array or object values by a dynamic index:

.. code-block:: html
   :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

   myArray.{myIndex}

ViewHelper attributes
=====================

See the :doc:`Fluid Viewhelper Reference <t3viewhelper:Index>` for a complete
list of all available ViewHelpers.

Simple
------

Variables can be inserted into ViewHelper attributes by putting them in
curly braces:

.. code-block:: html
   :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

   Now it is: <f:format.date format="{format}">{date}</f:format.date>

Fluid inline notation
=====================

.. tip::

   There is an online converter from tag-based syntax to inline syntax:
   `Fluid Converter <https://fluid-to-inline-converter.com/>`__

An alternative to the tag based notation used above is inline notation. For
example, compare the 2 identical Fluid constructs:

.. code-block:: html
   :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

   <!-- tag based notation -->
   <f:translate key="LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive"/>

   <!-- inline notation -->
   {f:translate(key: 'LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive')}

Tag based notation and inline notation can be freely mixed within one Fluid
template.

Inline notation is often a better choice if HTML tags are nested, for example:

.. code-block:: html
   :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

   <!-- tag based notation -->
   <span title="<f:translate key='LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive'/>">

   <-- inline notation -->
   <span title="{f:translate(key: 'LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive')}">

More complex example with chaining:

.. code-block:: html
   :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

   <!-- tag based notation -->
   <f:format.padding padLength="40"><f:format.date format="Y-m-d">{post.date}</f:format.date></f:format.padding>

   <!-- inline notation -->
   {post.date -> f:format.date(format: 'Y-m-d') -> f:format.padding(padLength: 40)}


