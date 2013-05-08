.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _namespaces:

Namespaces
^^^^^^^^^^

TYPO3 logically separates all files and directories into several
namespaces. These namespaces serve two purposes:

#. They show where a file or directory belongs inside TYPO3 CMS

#. They restrict PHP execution only to files from a certain namespace
   (for example, TYPO3 expects all callable functions to be in the
   :code:`user\_` or :code:`tx_` namespace).

Sections below describe currently defined namespaces inside TYPO3.


t3lib
"""""

The :code:`t3lib` namespace is reserved for common TYPO3 files. These files are
used by both Frontend and Backend. Physically this namespace
corresponds to the :code:`t3lib/` directory in the TYPO3 directory hierarchy.

All PHP class files in :code:`t3lib` namespace start with :code:`class.t3lib\_` prefix.

The :code:`t3lib/` directory contains subdirectories. Class and interface files
in these subdirectories have directory name appended to the
:code:`t3lib\_` prefix and separated from the class name by the underscore
character. For example, files in :code:`t3lib/cache/` are named like
:code:`class.t3lib\_cache\_exception.php`. Files inside :code:`t3lib/cache/backend` are
named like :code:`class.t3lib\_cache\_backend\_abstractbackend.php`.

User files are not allowed inside this namespace.


typo3
"""""

This namespace is reserved for TYPO3 Backend files. No user files are
allowed here.

Historically files in this namespace have different prefixes and do
not follow common naming rules.


tslib
"""""

:code:`tslib` historically stands for "TypoScript library". This namespace is
part of the :code:`cms` extension. Physically it is located in the
:code:`typo3/sysext/cms/tslib/` directory and contains Frontend page and
content generation files.

Files in this namespace historically may not follow common naming
conventions.

User files are not allowed in this namespace.


tx\_
""""

This namespace is reserved for extensions. Extension PHP class files
must start with :code:`class.tx\_` prefix, followed by the extension key
without underscores, another underscore and the name of the class in
lowercase. The file name ends with :code:`php` extension. For
example, if the extension key is :code:`test\_ext`, the file name will be
:code:`class.tx\_testext\_myclass.php` and the name of the class will be
:code:`tx\_testext\_myClass`.

User files from this namespace are commonly found in the
:code:`typo3conf/ext/` directory. Optionally these files can be installed to
the :code:`typo3/ext/` directory to be shared by many TYPO3 installations.


user\_
""""""

This namespace is used for PHP files, which are used in user functions
in TYPO3. It can also be used for extensions, which are local to a
single installation, although the :code:`user\_` prefix is not recommended
here.

Non–class files contain PHP functions. These functions can be called
by TYPO3 only if they have :code:`user\_` prefix (the prefix can be changed by
the administrator in the Install tool). All functions inside such files
must have the :code:`user\_` prefix as well. Usually such files are placed
inside the :code:`fileadmin/` directory or its subdirectories.


ux\_
""""

This name space is reserved for XCLASS files. These files usually
appear in extensions.

