.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _xclasses-warnings:

Warnings
^^^^^^^^

There are a few warnings about using XCLASS extensions:

- **Avoid using XCLASS extensions in your (public) extensions!** A PHP
  class can only be extended by *one* extension class at a time. Thus,
  having two extension classes set up, only the latter one will be
  enabled. There is no way to work around this technologically in PHP.
  However :code:`t3lib_div::makeInstance()` supports "cascaded" extension
  classes, meaning that you can do :code:`ux_ux_someclass` which will extend
  :code:`ux_someclass` but this requires an internal awareness of the
  extension class :code:`ux_someclass` in the first place.The conclusion is
  that XCLASS extensions are best suited for project development where
  you need a quick hack of something in the core which should still stay
  backwards compatible with TYPO3 core upgrades.

- **Check if child classes are instantiated** Quite often people have
  been confused about extending for instance the :code:`tslib_menu` class
  when they want to add a feature for "TMENU". But actually the class to
  extend is :code:`tslib_tmenu` which is an extension of :code:`tslib_menu`. So
  make sure you are extending the *right* class name (and always make
  sure your extension class is included also).

- **Strange opcode caching behaviors when you upgrade TYPO3 core** When
  you upgrade the TYPO3 core and you have an extension which extends a
  core class, the upgraded core underneath might not be detected by
  opcode caches. In particular PHP-Accelerator is known for this
  behavior producing "undefined function...." errors. The solution is:
  Always clear :file:`/tmp/php_a_*` files and restart your web server after
  upgrading source.


