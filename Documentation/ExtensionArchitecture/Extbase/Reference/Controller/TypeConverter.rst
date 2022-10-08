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
:php:`"October 7th, 2022"` or as UNIX time stamp: :php:`1665159559`.
Your action method, however, expects a :php:`\DateTime` object. Extbase tries to
match the data coming from the frontend automatically.

When matching the data formats is expected to fail you can use one of the type
converters provided by Extbase or implement a type converter yourself
by implementing the interface
:php:`\TYPO3\CMS\Extbase\Property\TypeConverterInterface`.

You can find the type converters provided by Extbase in the directory
`EXT:extbase/Classes/Property/TypeConverter
<https://github.com/TYPO3/typo3/tree/main/typo3/sysext/extbase/Classes/Property/TypeConverter>`__.

Custom type converters
======================

..  versionchanged:: 12.0
    Starting with TYPO3 v12.0 a type converter does not have to be registered
    via the now deprecated method :php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter()`.
    Remove calls to this method when dropping TYPO3 v11 support. This method will be
    removed with TYPO3 v13.0. Register a type converter in your extension's
    :file:`Services.yaml` instead.

A custom type converter must implement the interface
:php:`\TYPO3\CMS\Extbase\Property\TypeConverterInterface`. In most use cases
it will extend the abstract class
:php:`\TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter`, which
already implements this interface.

All type converters **should** have **no internal state**, such that they
can be used as singletons and multiple times in succession.

The registration and configuration of a type converter is done in the extension's
file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sevices.yaml

    services:
      MyVendor\MyExtension\Property\TypeConverter\MyCustomDateTimeConverter:
        tag:
          - name: extbase.type_converter
            priority: 10
            target: \DateTime
            sources: int,string
