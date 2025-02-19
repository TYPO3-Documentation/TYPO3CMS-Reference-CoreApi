..  include:: /Includes.rst.txt
..  index::
    ! YAML
    pair: API; YAML
..  _yaml-api:

========
YAML API
========

YAML is used in TYPO3 for various configurations; most notable are

*   :ref:`Event listeners <EventDispatcher>` in :file:`Configuration/Services.yaml`
*   :ref:`Dependency injection <DependencyInjection>` information in
    :file:`Configuration/Services.yaml`
*   :ref:`Site configuration <sitehandling>` in :file:`sites/<identifier>/config.yaml`
*   System extension :doc:`form <ext_form:Index>` configuration
*   System extension :doc:`rte_ckeditor <ext_rte_ckeditor:Index>` configuration


..  index:: YamlFileLoader
..  _yamlFileLoader:

YamlFileLoader
==============

TYPO3 is using a custom YAML loader for handling YAML in TYPO3 based on the
`symfony/yaml`_ package. It is located at
:php:`\TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader` and can be used when
YAML parsing is required.

..  _symfony/yaml: https://symfony.com/doc/current/components/yaml.html

The TYPO3 Core YAML file loader resolves environment variables. Resolving of
variables in the loader can be enabled or disabled via flags. For example, when
editing the site configuration through the backend interface the resolving of
environment variables needs to be disabled to be able to add environment
configuration through the interface.

The format for environment variables is :yaml:`%env(ENV_NAME)%`. Environment
variables may be used to replace complete values or parts of a value.

The YAML loader class has two flags: :php:`PROCESS_PLACEHOLDERS` and
:php:`PROCESS_IMPORTS`.

*   :php:`PROCESS_PLACEHOLDERS` decides whether or not placeholders (`%abc%`)
    will be resolved.
*   :php:`PROCESS_IMPORTS` decides whether or not imports (`imports` key) will
    be resolved.

Use the method :php:`YamlFileLoader::load()` to make use of the loader in your
extensions:

..  code-block:: php
    :caption: EXT:some_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;

    // ...

    (new YamlFileLoader())
        ->load(string $fileName, int $flags = self::PROCESS_PLACEHOLDERS | self::PROCESS_IMPORTS)

Configuration files can make use of import functionality to reference to the
contents of different files.

Example:

..  code-block:: yaml

    imports:
        - { resource: "EXT:rte_ckeditor/Configuration/RTE/Processing.yaml" }
        - { resource: "misc/my_options.yaml" }
        - { resource: "../path/to/something/within/the/project-folder/generic.yaml" }
        - { resource: "./**/*.yaml", glob: true }
        - { resource: "EXT:core/Tests/**/Configuration/**/SiteConfigs/*.yaml", glob: true }

The YAML file loader supports importing of files with `glob`_ patterns.
To enable globbing, set the option :yaml:`glob: true` on the import level.

The files are imported in the order they appear in the importing file. It used to be
the reverse order, take care when updating projects from before v12!

..  _glob: https://www.php.net/manual/en/function.glob.php

..  index:: YAML; Custom placeholder

Custom placeholder processing
-----------------------------

It is possible to register custom placeholder processors to allow fetching data
from different sources. To do so, register a custom processor via
:file:`config/system/settings.php`:

..  code-block:: php
    :caption: config/system/settings.php | typo3conf/system/settings.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['yamlLoader']['placeholderProcessors']
        [\Vendor\MyExtension\PlaceholderProcessor\CustomPlaceholderProcessor::class] = [];

There are some options available to sort or disable placeholder processors, if
necessary:

..  code-block:: php
    :caption: config/system/settings.php | typo3conf/system/settings.php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['yamlLoader']['placeholderProcessors']
        [\Vendor\MyExtension\PlaceholderProcessor\CustomPlaceholderProcessor::class] = [
            'before' => [
                \TYPO3\CMS\Core\Configuration\Processor\Placeholder\ValueFromReferenceArrayProcessor::class
            ],
            'after' => [
                \TYPO3\CMS\Core\Configuration\Processor\Placeholder\EnvVariableProcessor::class
            ],
            'disabled' => false,
        ];

New placeholder processors must implement the
:php:`\TYPO3\CMS\Core\Configuration\Processor\Placeholder\PlaceholderProcessorInterface`.
An implementation may look like the following:

..  literalinclude:: _ExamplePlaceholderProcessor.php
    :caption: EXT:my_extension/Classes/Configuration/Processor/Placeholder/ExamplePlaceholderProcessor.php

This may be used, for example, in the site configuration:

..  code-block:: yaml
    :caption: config/sites/<some_site>/config.yaml

    someVariable: '%example(somevalue)%'
    anotherVariable: 'inline::%example(anotherValue)%::placeholder'

If a new processor returns a string or number, it may also be used inline as
above. If it returns an array, it cannot be used inline since the whole content
will be replaced with the new value.
