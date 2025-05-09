..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Directory structure
..  _extbase_tutorial_tea_directory_structure:

============================
Create a directory structure
============================

Extbase requires a particular directory structure. It is considered
best practice to always stick to this structure.

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

The :file:`Classes/` folder should contain all the PHP classes provided by the
extension. Otherwise they will not be available in the default
:ref:`autoloading <autoload>`. (See documentation on the :ref:`extension-classes` folder).


In the :file:`composer.json <extension-composer-json>` we define that all PHP classes are
automatically loaded from the :file:`Classes/` directory (also
defined in file:`ext_emconf.php` in Classic mode installations):

..  tabs::

    ..  group-tab:: Composer

        .. include:: /CodeSnippets/Tutorials/Tea/ComposerJsonAutoload.rst.txt

    ..  group-tab:: Classic mode installation (no Composer)

        .. include:: /CodeSnippets/Tutorials/Tea/ExtEmconfAutoload.rst.txt

The key of the psr-4 array, here :php:`'TTN\\Tea\\'`, defines the namespace
for all classes in order to be found by
:ref:`PSR-4 autoloading <autoload>`.

The :file:`Classes/` folder contains subfolders:

..  code-block:: none
    :caption: Directory structure of EXT:tea

    $ tree path/to/extension/tea
    ├── Classes
        ├── Controller
        ├── Domain
        |   ├── Model
        |   └── Repository
        └──  ViewHelpers

Extbase is based on the pattern Model-View-Controller (MVC) so we have
**model** and **controller** directories.

In most cases the **view** is handled by classes provided by the framework
and configured via templating. Therefore a view folder is not required.

Additional logic needed for the view can be provided by **ViewHelpers** and
should be stored in the respective viewhelper folder.

..  note::
     :ref:`ViewHelpers <fluid-custom-viewhelper>` are a feature of the Fluid templating engine.

Directory :file:`Configuration`
-------------------------------

See also documentation on the :ref:`extension-configuration-files` folder.

The :file:`Configuration` folder contains several subfolders:

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

:file:`Configuration/FlexForms/`
    Contains the configuration of additional input fields to
    configure plugins using the :ref:`FlexForm <flexforms>` format.
:file:`Configuration/TCA/`
    Contains the :ref:`TYPO3 configuration array (TCA) <t3tca:introduction>`
    (PHP arrays).
:file:`Configuration/TCA/Overrides/`
    Can be used to extend the TCA of other extensions. They can be extended
    by direct array manipulation or preferably by calls to
    API functions.
:file:`Configuration/TsConfig/`
    Contains :ref:`TSconfig <t3tsref:typoscript-syntax-using-setting>` configuration for the TYPO3
    backend on page or user level in TypoScript syntax. Our extension
    does not contain TSconfig, so the folder is only a placeholder here.
:file:`Configuration/TypoScript/`
    Contains :ref:`TypoScript <typoscript>` configuration for
    the frontend. In some contexts the configuration contained here is also
    used in the backend.
:file:`Configuration/Services.yaml`
    Is used to configure technical aspects of the extension, including
    automatic wiring, automatic configuration and options for
    :ref:`dependency injection <Dependency-Injection>`. See also
    :ref:`extension-configuration-services-yaml`.

Directory :file:`Documentation/`
-------------------------------

The :file:`Documentation/` folder contains files from which
documentation is rendered. See :ref:`extension-files-documentation`.

Directory :file:`Resources/`
---------------------------

See also documentation on the :ref:`extension-Resources` folder.

The :file:`Resources/` folder contains two sub folders that are
further divided up:

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
    All resource files that are not directly loaded by the browser
    **should** go in this directory. This includes Fluid templating files
    and localization files.
:file:`Resources/Public`
    All resource files that are directly loaded by the browser
    **must** go in this directory. Otherwise they are not accessible
    (depending on the setup of the installation).

Directory :file:`Tests/`
-----------------------

Contains automatic tests (topic not covered by this tutorial).

..  hint::
    If you want to learn more about automatic code checks
    see :doc:`documentation of tea <ttn/tea:Index>` and the chapter on
    :ref:`Testing <testing>` in this manual.
