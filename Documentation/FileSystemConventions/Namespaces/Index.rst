.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Namespaces
^^^^^^^^^^

TYPO3 logically separates all files and directories into several
namespaces. These namespaces serve two purposes:

#. They show where a file or directory belongs inside TYPO3 CMS

#. They restrict PHP execution only to files from a certain namespace
   (for example, TYPO3 expects all callable functions to be in the
   user\_or tx\_namespace).

Sections below describe currently defined namespaces inside TYPO3.


t3lib
"""""

The t3libnamespace is reserved for common TYPO3 files. These files are
used by both Frontend and Backend. Physically this namespace
corresponds to the t3lib/directory in the TYPO3 directory hierarchy.

All PHP class files in t3libname space start with class.t3lib\_prefix.

The t3lib/directory contains subdirectories. Class and interface files
in these subdirectories have directory name appended to the
t3lib\_prefix and separated from the class name by the underscore
character. For example, files in the t3lib/cache/are named like
class.t3lib\_cache\_exception.php. Files inside t3lib/cache/backendare
named like class.t3lib\_cache\_backend\_abstractbackend.php.

User files are not allowed inside this namespace.


typo3
"""""

This namespace is reserved for TYPO3 Backend files. No user files are
allowed here.

Historically files in this namespace have different prefixes and do
not follow common naming rules.


tslib
"""""

tslibhistorically stands for “TypoScript library”. This namespace is
part of cmsextension. Physically it is located in
typo3/sysext/cms/tslib/directory and contains Frontend page and
content generation files.

Files in this namespace historically may not follow common naming
conventions.

User files are not allowed in this namespace.


tx\_
""""

This namespace is reserved for extensions. Extension PHP class files
must start with class.tx\_prefix, followed by the extension key
without underscores, another underscore and the name of the class in
lower case. The file name ends with :code:`php` extension. For
example, if extension key is test\_ext, the file name will be
class.tx\_testext\_myclass.phpand the name of the class will be
tx\_testext\_myClass.

User files from this namespace commonly found in
typo3conf/ext/directory. Optionally these files can be installed to
the typo3/ext/directory to be shared by many TYPO3 installations.


user\_
""""""

This namespace is used for PHP files without PHP classes or for
extensions local to a single installation. It is not recommended to
create extensions with user\_prefix.

Non–class files contain PHP functions. These functions can be called
by TYPO3 only if they have user\_prefix (the prefix can be changed by
administrator in Install tool). All functions inside such files must
have user\_prefix as well. Usually such files are placed inside
fileadmin/directory or its subdirectory.


ux\_
""""

This name space is reserved for XCLASSfiles. These files usually
appear in extensions.

