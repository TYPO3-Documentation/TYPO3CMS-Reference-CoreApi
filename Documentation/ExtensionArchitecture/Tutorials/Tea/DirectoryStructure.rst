..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Directory structure
..  _extbase_tutorial_tea_directury_structure:

============================
Create a directory structure
============================

Extbase requires or defaults to a certain directory structure. It is considered
best practise to always stick to this structure.

On the first level `EXT:tea <https://github.com/TYPO3-Documentation/tea>`__ has the following structure:

..  code-block:: none
    :caption: Directory structure of EXT:tea

    $ tree /path/to/extension/tea
    ├── Classes
    ├── Configuration
    ├── Documentation
    ├── Resources
    ├── Tests
    ├── composer.json
    ├── ext_emconf.php
    ├── ...
    └── README.md

Directory :file:`Classes`
-------------------------

The folder :file:`Classes` should contain all PHP classes provided by the
extension. Otherwise they are not available in the default
:ref:`autoloading <autoload>`.

See also the general chapter on the folder :ref:`extension-classes`.

In the :file:`composer.json` we have defined that all PHP classes are
automatically loaded from the :file:`Classes` directory (and additionally
in file:`ext_emconf.php` for legacy installations):

..  tabs::

    ..  group-tab:: Composer

        ..  code-block:: json
            :caption: EXT:tea/composer.json, extract
            :emphasize-lines: 4

            {
                "autoload": {
                    "psr-4": {
                        "TTN\\Tea\\": "Classes/"
                    }
                }
            }

    ..  group-tab:: Legacy

        ..  code-block:: php
            :caption: EXT:tea/ext_emconf.php, extract
            :emphasize-lines: 4

            $EM_CONF[$_EXTKEY] = [
                'autoload' => [
                    'psr-4' => [
                        'TTN\\Tea\\' => 'Classes/',
                    ],
                ],
            ];

The key of the psr-4 array, here :php:`'TTN\\Tea\\'` defines the namespace
that all classes in this directory must be situated in to be found by
the :ref:`PSR-4 autoloading <autoload>`.

The folder :file:`Classes` contains several subfolders:

..  code-block:: none
    :caption: Directory structure of EXT:tea

    $ tree path/to/extension/tea
    ├── Classes
        ├── Controller
        ├── Domain
        |   ├── Model
        |   └── Repository
        └──  ViewHelpers

Extbase is based on the pattern Model-View-Controller (MVC). And you can already
find directories for the **model** and the **controller** here.

In most cases the **view** is handled by classes provided by the framework
and configured via templating. Therefore there is no folder for the view as a
whole.

Additional logic needed for the view can be provided by **ViewHelpers** and
should be stored in the according folder.

..  note::
    ViewHelpers are a feature of the Fluid templating engine. See also the
    chapter :ref:`fluid-custom-viewhelper`.

Directory :file:`Configuration`
-------------------------------

See also the general chapter on the folder :ref:`extension-configuration-files`.

The folder :file:`Configuration` contains several subfolders:

..  code-block:: none
    :caption: Directory structure of EXT:tea

    $ tree path/to/extension/tea
    ├── Configuration
        ├── FlexForms
        ├── TCA
        |   └── Overrides
        ├── TsConfig
        |   ├── Page
        |   └── User
        ├── TypoScript
        |   ├── constants.typoscript
        |   └── setup.typoscript
        └──  Services.yaml

:file:`Configuration/FlexForms`
    Contains the configuration of additional input fields to
    configure plugins in the format :ref:`FlexForm <flexforms>`.
:file:`Configuration/TCA`
    Contains the :ref:`TYPO3 configuration array (TCA) <t3tca:introduction>`
    as PHP arrays.
:file:`Configuration/TCA/Overrides`
    Can be used to extend the TCA of other extensions. They can be extended
    by direct array manipulation or (preferred if possible) by calls to
    API functions.
:file:`Configuration/TsConfig`
    Contains :doc:`TSconfig <t3tsconfig:Index>` configurations for the TYPO3
    backend on page or user level in the syntax of TypoScript. This extension
    does not feature TSconfig, therefore the folder is only a placeholder here.
:file:`Configuration/TypoScript`
    Contains :ref:`TypoScript <typoscript-syntax-about>` configurations for
    the frontend. In some contexts the configuration contained here is also
    considered in the backend.
:file:`Configuration/Services.yaml`
    Is used to configure technical aspects of the extension including
    automatic wiring, automatic configuration and options for
    :ref:`dependency injection <Dependency-Injection>`. See also
    :ref:`extension-configuration-services-yaml`.

Directory :file:`Documentation`
-------------------------------

The folder :file:`Documentation` contains the files from which the
documentation is rendered. See :ref:`extension-files-documentation`.

Directory :file:`Resources`
---------------------------

See also the general chapter on the folder :ref:`extension-Resources`.

The folder :file:`Resources` contains two sub folders that are
further divided:

..  code-block:: none
    :caption: Directory structure of EXT:tea

    $ tree /path/to/extension/tea
    ├── Resources
        ├── Private
        |   ├── Language
        |   ├── Layouts
        |   ├── Partials
        |   └── Templates
        └── Public
            ├── CSS
            ├── Icons
            ├── Images
            └── JavaScript


:file:`Resources/Private`
    All resource files that do not have to be loaded directly by a browser
    **should** go in this directory. This includes Fluid templating files
    and localization files.
:file:`Resources/Public`
    All resource files have to be loaded directly by a browser
    **must** go in this directory. Otherwise they are not accessible
    depending on the setup of the installation.

Directory :file:`Tests`
-----------------------

Contains the automatic tests. This topic is not covered by this tutorial.

..  hint::
    If you want to learn more about automatic code checks
    see the :doc:`documentation of tea <ext_tea:Index>` and the chapter on
    :ref:`Testing <testing>` in this manual.
