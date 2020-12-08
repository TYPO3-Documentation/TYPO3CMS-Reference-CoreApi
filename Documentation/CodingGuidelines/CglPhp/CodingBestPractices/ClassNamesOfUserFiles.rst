.. include:: /Includes.rst.txt


.. index::
   single: Coding Guidelines; Namespaces

.. _cgl-namespaces-class-names:

========================================
Namespaces and Class Names of User Files
========================================

The namespace and class names of user files follow the same rules as
class names of the TYPO3 Core files do.

The namespace declaration of each user file should show where the file
belongs inside its extension. The namespace starts with
:code:`"Vendor\MyNamespace\"`, where "Vendor" is your vendor name and
"MyNamespace" is the extension name in UpperCamelCase. Then follows the
name of the subfolder of :file:`Classes/`, in which the file is located
(if any). E.g. the file
:file:`typo3conf/ext/realurl/Classes/Controller/AliasesController.php`
with the class :php:`AliasesController` is in the namespace
":php:`DmitryDulepov\Realurl\Controller`".

User files with these class names are commonly found in the
:file:`typo3conf/ext/` directory. Optionally these files can be
installed to the :file:`typo3/ext/` directory to be shared by many
TYPO3 installations.
