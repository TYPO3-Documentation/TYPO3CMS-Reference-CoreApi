.. include:: ../../Includes.txt


.. _using-constants:

Using constants
^^^^^^^^^^^^^^^

When a TypoScript Template is parsed by TYPO3 CMS, constants are simply
replaced, as you would perform any ordinary string replacement.
Constants are used in the "Setup" field by placing them inside curly
braces and prepending them with a :code:`$` sign:

.. code-block:: typoscript

   {$bgCol}
   {$topimg.width}
   {$topimg.file.pic2}
   {$file.toplogo}


Example
"""""""

.. code-block:: typoscript

   page = PAGE
   page.typeNum = 0

   page.bodyTag = <body bgColor="{$bgCol}">
   page.10 = IMAGE
   page.10.file = {$file.toplogo}


**Only constants, which are actually defined** in the "Constants"
field, are substituted. So for our example to work, we again have to
define the constants from the last example in the constants field.

When you reference files in the constants field, you have to define
file name *and path* (except if the file is located in the root directory
of your TYPO3 installation). So in our case for "logo.gif", for the
replacement to work, you must make sure that the file resides on the
server and use its precise path in the constant.

Constants in included templates are also substituted as the whole
template is just one large chunk of text.

You should use a systematic naming scheme for constants. Seek
inspiration in the code examples around.

.. figure:: ../../Images/TemplatesSetup.png
   :alt: Overview of the defined setup

Notice how the constants in the setup code are substituted (marked in
green). In the Object Browser, you can monitor the constants with or
without substitution.

.. note::

   The "Display constants" function is not available if you select
   "Crop lines".

