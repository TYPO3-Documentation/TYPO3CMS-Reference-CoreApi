.. include:: /Includes.rst.txt
.. index::
   Extbase; PropertyMapper
.. _extbase_property_mapping:

===================
Property mapping
===================

Extbase provides a property mapper to convert different values, like integers
or arrays, to other types, like strings or objects.

In this example, we provide a string that will be converted to an integer:

.. code-block:: html
   :caption: EXT:my_extension/Classes/Controller/SomeController.php

   // use \TYPO3\CMS\Extbase\Property\PropertyMapper

   $output = $this->propertyMapper->convert('10', 'integer');

Conversion is done by using the :php:`TYPO3\CMS\Extbase\Property\PropertyMapper::convert()`
method.

.. note::
   The :php:`PropertyMapper` has to be injected before it can be used:

   .. code-block:: html
      :caption: EXT:my_extension/Classes/Controller/SomeController.php

      // use \TYPO3\CMS\Extbase\Property\PropertyMapper

      /**
       * @param PropertyMapper $propertyMapper
       */
      public function injectPropertyMapper(PropertyMapper $propertyMapper)
      {
          $this->propertyMapper = $propertyMapper;
      }


How to use property mappers
===========================

This example shows a simple conversion:

.. code-block:: html
   :caption: EXT:my_extension/Classes/Controller/SomeController.php

   // use \TYPO3\CMS\Extbase\Property\PropertyMapper

   $input = [
      'username' => 'This is the user name',
   ];

   $output = $this->propertyMapper->convert (
      $input,
      'TYPO3\CMS\Extbase\Domain\Model\FrontendUser'
   );

The result is a new instance of :php:`TYPO3\CMS\Extbase\Domain\Model\FrontendUser`
with defined property `username`.

.. note::
   The property mapper will not check the validation rules. The result will be
   whatever the input is.


Allow mapping of sub-properties
===============================

It is also possible to map to subtypes. In the above example, the
:php:`FrontendUser` has a sub-property
of type :php:`TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup`. If you want
to map an incoming id, you have to configure the mapper, as by default
it won't map sub properties for security reasons:

.. code-block:: html
   :caption: EXT:my_extension/Classes/Controller/SomeController.php

   // use \TYPO3\CMS\Extbase\Property\PropertyMapper
   // use \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder

    $input = [
        'username' => 'This is the user name',
        'usergroup' => [
            1,
        ],
    ];

    // Get property mapping configuration
    $mappingConfiguration = $this->propertyMappingConfigurationBuilder->build();
    // Adjust configuration to allow mapping of sub property 'usergroup'
    $mappingConfiguration->forProperty('usergroup')
        ->allowAllProperties();

    $output = $this->propertyMapper->convert(
            $input,
            'TYPO3\CMS\Extbase\Domain\Model\FrontendUser',
            $mappingConfiguration
        );

.. note::
   The :php:`PropertyMappingConfigurationBuilder` also has to be injected
   before it can be used.
