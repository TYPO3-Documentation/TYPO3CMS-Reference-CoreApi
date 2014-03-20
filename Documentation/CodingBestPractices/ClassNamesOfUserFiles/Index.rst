.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _class-names:

Class names of user files
^^^^^^^^^^^^^^^^^^^^^^^^^

Until TYPO3 CMS 4.7, the TYPO3 Core used a certain naming pattern for
PHP class names. Although no longer in use in the Core itself, it still
*is* usable for code in user files - and, as detailed below, in parts
still *mandatory*.

The following requirements serve the purpose to restrict PHP execution
only to files of a certain group (for example, TYPO3 expects all
callable functions to be in classes or functions starting with
:code:`user_` or :code:`tx_`).


tx\_
""""

Class names starting with :code:`tx_` are reserved for extensions.
Extension PHP class files, which are based on the :code:`tslib_pibase`
class, must start with :code:`class.tx_` prefix, followed by the
extension key without underscores, another underscore and the name of
the class in lowercase. The file name ends with the extension
:code:`php`. For example, if the extension key is :code:`test_ext`,
the file name will be :code:`class.tx_testext_myclass.php` and the name
of the class will be :code:`tx_testext_myClass`.

User files with these class names are commonly found in the
:code:`typo3conf/ext/` directory. Optionally these files can be
installed to the :code:`typo3/ext/` directory to be shared by many
TYPO3 installations.


Tx\_
""""

Class names starting with :code:`Tx_` are reserved for extensions.
Extension PHP class files, which are based on :code:`extbase`, use
these rules: The class name starts with :code:`Tx_` prefix, followed by
the extension key with first letter in uppercase and without
underscores, another underscore and the name of the class with the
first letter of the single words in uppercase. The file name ends with
the extension :code:`php`. For example, if the extension key is
:code:`test_ext`, the file name will be :code:`MyClass.php` and the
name of the class will be :code:`Tx_Testext_MyClass`.

User files with these class names are commonly found in the
:code:`typo3conf/ext/` directory. Optionally these files can be
installed to the :code:`typo3/ext/` directory to be shared by many
TYPO3 installations.


user\_
""""""

Class names starting with :code:`user_` are used for PHP files, which
in turn should be used in user functions in TYPO3. They can also be
used for extensions, which are local to a single installation, although
the :code:`user_` prefix is not recommended here.

Non–class files contain PHP functions. These functions can be called
by TYPO3 only if the files have the :code:`user_` prefix (the prefix
can be changed by the administrator in the Install Tool). All functions
or classes inside such files must have the :code:`user_` prefix as
well. Usually such files are placed inside the :code:`fileadmin/`
directory or its subdirectories.


ux\_
""""

Class names starting with :code:`ux_` are reserved for XCLASS files.
These files usually appear in extensions.

