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

   $this->view->assign('data',array('Low', 'High'));

Use the dot ``.`` to access array keys::

   <p>{data.0}, {data.1}</p>

This also works for object properties:

.. code-block:: php

   $this->view->assign('product',$myProduct);

Use it like this::

   <p>{product.name}: {product.price}</p>


Accessing dynamic keys/properties
---------------------------------

It is possible to access array or object values by a dynamic index::

   myArray.{myIndex}

ViewHelper attributes
=====================

See the :ref:`Fluid Viewhelper Reference <t3viewhelper:start>` for a complete
list of all available ViewHelpers.

Simple
------

Variables can be inserted into ViewHelper attributes by putting them in
curly braces::

   Now it is: <f:format.date format="{format}">{date}</f:format.date>
