..  include:: /Includes.rst.txt
..  index:: Extbase; Type converters
..  _extbase-type-converters:

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

..  _extbase-type-converters-custom:

Custom type converters
======================

A custom type converter must implement the interface
:php:`\TYPO3\CMS\Extbase\Property\TypeConverterInterface`. In most use cases
it will extend the abstract class
:php:`\TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter`, which
already implements this interface.

All type converters **should** have **no internal state**, such that they
can be used as singletons and multiple times in succession.

The registration and configuration of a type converter is done in the extension's
:file:`Services.yaml`:

..   code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      MyVendor\MyExtension\Property\TypeConverter\MyCustomDateTimeConverter:
        tags:
          - name: extbase.type_converter
            priority: 10
            target: \DateTime
            sources: integer,string

For conversions of Extbase controller action parameters into Extbase domain
model objects the incoming data is usually a numeric type, but in case of an update
action it might as well be an array containing its ID as property `__identifier`.

Thus the configuration should list :php:`array` as one of its sources:

..   code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    services:
      MyVendor\MyExtension\Property\TypeConverter\MyCustomModelObjectConverter:
        tags:
          - name: extbase.type_converter
            priority: 10
            target: MyVendor\MyExtension\Domain\Model\MyCustomModel
            sources: integer,string,array
