..  include:: /Includes.rst.txt
..  index::
    Extension development; File name conventions
    Path; EXT:{extkey}/Configuration
..  _extension-files-configuration:
..  _extension-configuration-files:

======================
:file:`Configuration`
======================

The folder :file:`EXT:my_extension/Configuration/` may contain
configuration of different types.

Some of the sub directories in here have reserved names with special meanings.

All files in this directory and in the sub directories :file:`TCA` and :
file:`Backend` are automatically included during the TYPO3 bootstrap.

The following files and folders are commonly found in the :file:`Configuration`
folder:

..  code-block:: none
    :caption: Common content of the configuration folder

    $ tree local_packages/my_extension/Configuration/
    ├── Backend
    │    ├── AjaxRoutes.php
    │    └── Routes.php
    ├── Extbase
    │    └── Persistence
    │         └── Classes.php
    ├── FlexForms
    │    ├── MyFlexForm1.xml
    │    ├── ...
    │    └── MyFlexFormN.xml
    ├── RTE
    │    └── MyRteConfig.yaml
    ├── TCA
    │    ├── Overrides
    │    │    ├── pages.php
    │    │    ├── sys_template.php
    │    │    ├── tt_content.php
    │    │    ├── ...
    │    │    └── tx_otherextension_sometable.php
    │    ├── tx_myextension_domain_model_something.php
    │    ├── ...
    │    └── tx_myextension_sometable.php
    ├── TSconfig
    │    ├── Page
    │    └── User
    ├── TypoScript
    │    ├── Subfolder1
    │    ├── ...
    │    ├── constants.typoscript
    │    └── setup.typoscript
    ├── Yaml
    │    ├── MySpecialConfig.yaml
    │    └── MyFormSetup.yaml
    ├── Icons.php
    ├── page.tsconfig
    ├── RequestMiddlewares.php
    └── Services.yaml


..  toctree::
    :titlesonly:
    :caption: Sub folders of Configuration
    :glob:

    */Index


..  toctree::
    :titlesonly:
    :caption: Files directly under Configuration
    :glob:

    *
