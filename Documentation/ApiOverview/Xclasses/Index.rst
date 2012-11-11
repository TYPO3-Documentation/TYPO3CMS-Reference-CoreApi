.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _xclasses:

Extending classes (XCLASSes)
----------------------------


.. _xclasses-intro:

Introduction
^^^^^^^^^^^^

Practically all classes used in TYPO3 -
both frontend and backend - can be extended by user-defined classes.
Extension of TYPO3 PHP classes is often referred to as an "XCLASS
extension".

Extending TYPO3 PHP classes is recommended mostly for special needs
in individual projects. This is due to the limitation that a class can
only be extended once. Thus, if many extensions try to extend the same
class, only one of them will succeed and in turn the others will not
function correctly.

So, extending classes is a great option for individual projects where
special "hacks" are needed. But generally it is a poor way of
programming TYPO3 extensions in which case you should look for a
system hook or request a system hook to be made for your purpose if
generally meaningful.

Configuring user classes works like this:

#. In :file:`(ext_)localconf.php` you configure for either frontend or backend
   that you wish to include a file with the extension of the class. This
   inclusion is usually done in the end of the class-file itself based on
   a lookup in :code:`$TYPO3_CONF_VARS`.

#. Whenever the class is instantiated as an object, the source code
   checks if a user-extension of that class exists. If so, then *that*
   class (or an extension of the extended class) is instantiated and not
   the "normal" (parent) class. Getting the correct instance of a class is
   handled transparently by :code:`t3lib_div::makeInstance()`,
   which is why you should never use the :code:`new` operator when
   creating an object.


.. _xclasses-which-classes:

Which classes?
^^^^^^^^^^^^^^

Most code in TYPO3 resides in classes and therefore anything in the
system can be extended. So you should rather say to yourself: In which
script (and thereby which class) is it that I'm going to extend/change
something. When you know which script, you simply open it, look inside
and somewhere you'll find the lines of code which are responsible for
the inclusion of the extension, typically in the bottom of the script.

The exceptions to this rule are classes like :code:`t3lib_div`,
:code:`t3lib_extMgm` or :code:`t3lib_BEfunc`. These classes are static.
Since they never get instantiated, the cannot be extended
with an XCLASS.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Examples/Index
   ExtendingMethods/Index
   UserMethods/Index
   Warnings/Index


