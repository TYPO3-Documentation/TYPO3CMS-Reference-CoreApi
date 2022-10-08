.. include:: /Includes.rst.txt
.. index::
   Extbase; Type converters
.. _extbase_Type_converters:

===============
Type converters
===============

Type converters are commonly used when it is necessary to convert from one type
into another. They are usually applied in the Extbase controller in the
:php:`initialize<actionName>Action()` method.

For example a date might be given as string in some language,
:php:`"Freitag, 7. Oktober 2022"` or as UNIX time stamp: :php:`1665159559`.
Your action method, however, expects a :php:`\DateTime` object. Extbase tries to
match the data coming from the frontend automatically.

When matching the data formats is expected to fail you can use one of the type
converters provided by Extbase or implement a type converter yourself
by extending :php:`TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter`.

You can find the type converters provided by Extbase in the directory
`EXT:extbase/Classes/Property/TypeConverter
<https://github.com/TYPO3/typo3/tree/main/typo3/sysext/extbase/Classes/Property/TypeConverter>`__.

Custom type converters
======================

..  versionchanged:: 12.0
    Starting with TYPO3 12.0 a type converter does not have to be registered
    via the now deprecated method :php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter()`.
    Remove calls to this method when dropping TYPO3 v11 support. It will be
    removed with TYPO3 13. Register a type converter in your extension's
    :file:`Services.yaml` instead.

A custom type converter must extend the abstract class
:php:`TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter` and
implement the method :php:`convertFrom()`, which is defined in the interface
:php:`TYPO3\CMS\Extbase\Property\TypeConverterInterface`.

All type converters **should** have **no internal state**, such that they
can be used as singletons and multiple times in succession.

The registration and configuration of a type converter is done in the extension's
file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sevices.yaml

    services:
      MyVendor\MyExtension\Property\TypeConverter\MyBooleanConverter:
        tag:
          - name: extbase.type_converter
            priority: 10
            target: boolean
            sources: boolean,string
