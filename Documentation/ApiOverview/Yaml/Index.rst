.. include:: /Includes.rst.txt
.. index:: 
   ! YAML
   pair: API; YAML
.. _yaml-api:

========
YAML API
========

YAML is used in TYPO3 for various configurations; most notable are

* :ref:`Event listeners <EventDispatcher>` in :file:`Configuration/Services.yaml`
* :ref:`Dependency injection <DependencyInjection>` information in :file:`Configuration/Services.yaml`
* :ref:`Site configuration <sitehandling>` in :file:`sites/<identifier>/config.yaml`
* System extension :ref:`form <form:start>` configuration
* System extension :ref:`rte_ckeditor  <ckedit:start>` configuration


.. index:: YamlFileLoader
.. _yamlFileLoader:

YamlFileLoader
==============

`TYPO3`:pn: is using a custom YAML loader for handling YAML in TYPO3 based on the `Symfony`:pn: YAML package. It's located at
:php:`\TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader` and can be used when YAML parsing is required.

The `TYPO3 Core`:pn: YAML resolves environment variables. Resolving of variables in the loader can be enabled or
disabled via flags. For example, when editing the site configuration through the backend interface the resolving
of environment variables needs to be disabled to be able to add environment configuration through
the interface.

The format for environment variables is :yaml:`%env(ENV_NAME)%`. Environment variables may be used to replace
complete values or parts of a value.

The YAML Loader class has two flags: :yaml:`PROCESS_PLACEHOLDERS` and :yaml:`PROCESS_IMPORTS`.

* :yaml:`PROCESS_PLACEHOLDERS` decides whether or not placeholders (`%abc%`) will be resolved.
* :yaml:`PROCESS_IMPORTS` decides whether or not imports (`imports` key) will be resolved.

Use the method :php:`YamlFileLoader::load()`
to make use of the loader in your extensions::

   use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;

   // ...

   YamlFileLoader::load(string $fileName, int $flags = self::PROCESS_PLACEHOLDERS | self::PROCESS_IMPORTS)

Configuration files can make use of import functionality to reference to the contents of different files.

Examples:

.. code-block:: yaml

   imports:
     - { resource: "EXT:rte_ckeditor/Configuration/RTE/Processing.yaml" }
     - { resource: "misc/my_options.yaml" }
     - { resource: "../path/to/something/within/the/project-folder/generic.yaml" }



.. index:: YAML; Custom placeholder

Custom placeholder processing
-----------------------------

It is possible to register custom placeholder processors to allow fetching data from
different sources. To do so, register a custom processor via :file:`LocalConfiguration.php`:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['yamlLoader']['placeholderProcessors'][\Vendor\MyExtension\PlaceholderProcessor\CustomPlaceholderProcessor::class] = [];

There are some options available to sort or disable placeholder processors if necessary:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['yamlLoader']['placeholderProcessors'][\Vendor\MyExtension\PlaceholderProcessor\CustomPlaceholderProcessor::class] = [
      'before' => [
         \TYPO3\CMS\Core\Configuration\Processor\Placeholder\ValueFromReferenceArrayProcessor::class
      ],
      'after' => [
         \TYPO3\CMS\Core\Configuration\Processor\Placeholder\EnvVariableProcessor::class
      ],
      'disabled' => false,
   ];

New placeholder processors must implement the :php:`\TYPO3\CMS\Core\Configuration\Processor\Placeholder\PlaceholderProcessorInterface`
An implementation may look like the following:

.. code-block:: php

   class ExamplePlaceholderProcessor implements PlaceholderProcessorInterface
   {
      public function canProcess(string $placeholder, array $referenceArray): bool
      {
         return strpos($placeholder, '%example(') !== false;
      }

      public function process(string $value, array $referenceArray)
      {
         // do some processing
         $result = $this->getValue($value);

         // Throw this exception if the placeholder can't be substituted
         if ($result === null) {
            throw new \UnexpectedValueException('Value not found', 1581596096);
         }
         return $result;
      }

      private function getValue(string $value): ?string
      {
         // implement logic to fetch specific values from an external service
         // or just add simple mapping logic - whatever is appropriate
         $aliases = [
            'foo' => 'F-O-O',
            'bar' => 'ARRRRR',
         ];
         return $aliases[$value] ?? null;
      }
   }


This may be used for example in the site configuration:

.. code-block:: yaml

   someVariable: '%example(somevalue)%'
   anotherVariable: 'inline::%example(anotherValue)%::placeholder'

If a new processor returns a string or number, it may also be used inline as above.
If it returns an array, it cannot be used inline since the whole content will be replaced with the new value.
