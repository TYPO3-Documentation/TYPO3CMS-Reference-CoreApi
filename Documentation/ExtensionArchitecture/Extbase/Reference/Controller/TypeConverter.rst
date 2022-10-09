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

A custom type converter must implement the interface
:php:`\TYPO3\CMS\Extbase\Property\TypeConverterInterface`. In most use cases
it will extend the abstract class
:php:`\TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter`, which
already implements this interface.

All type converters **should** have **no internal state**, such that they
can be used as singletons and multiple times in succession.

The registration and configuration of a type converter is done in the extension's
:file:`ext_localconf.php`:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    <?php

    declare(strict_types=1);

    use MyVendor\MyExtension\TypeConverter\MyDatetimeConverter;
    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    defined('TYPO3') or die();

    // Starting  with TYPO3 v12 extbase type converters are registered in 
    // Configuration/Services.yaml
    if ((new \TYPO3\CMS\Core\Information\Typo3Version())->getMajorVersion() < 12) 
    {
        // Register type converters
        ExtensionUtility::registerTypeConverter(MyDatetimeConverter::class);
    }

..  tip::
    Starting with TYPO3 v12.0 a type converter is registered in the extension's
    :file:`Services.yaml`. See
    :ref:`Type converters in TYPO3 v12 <t3coreapi12:extbase_Type_converters>`.

    To provide compatibility with both TYPO3 v11 and v12 register the type
    converter in the :file:`Services.yaml` and keep the call to
    :php:`ExtensionUtility::registerTypeConverter()` until dropping v11 support.
