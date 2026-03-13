:navigation-title: Classes

..  include:: /Includes.rst.txt
..  _extension-classes:
..  index:: Path; EXT:{extkey}/Classes

==========================================
Extension folder `Classes` for PHP classes
==========================================

Contains all the PHP classes in an extension, with one class per file. Should have subfolders like
:code:`Controller/`, :code:`Domain/`, :code:`Service/` or :code:`View/`.
For more details on class file naming and PHP namespaces, see chapter
:ref:`namespaces <namespaces>`.

Typical PHP classes in this folder:

..  typo3:file:: SomeController.php
    :scope: extension
    :composerPath: /Classes/Controller/
    :classicPath: /Classes/Controller/
    :regex: /^.*\/Classes\/Controller\/.*Controller\.php$/
    :shortDescription: Contains MVC Controller classes.

    Contains MVC Controller classes. In Extbase extensions the classes inherit
    from :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.

    See also chapter `Extbase Controller <https://docs.typo3.org/permalink/t3coreapi:extbase-controller>`_.

..  typo3:file:: Something.php
    :scope: extension
    :composerPath: /Classes/Domain/Model/
    :classicPath: /Classes/Domain/Model/
    :regex: /^.*\/Domain\/Model\/.*\.php$/
    :shortDescription: Contains MVC Domain model classes.

    Contains MVC Domain model classes. In Extbase they inherit from
    :php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`. See also
    `Extbase Model <https://docs.typo3.org/permalink/t3coreapi:extbase-model>`_.

..  typo3:file:: SomethingRepository.php
    :scope: extension
    :composerPath: /Classes/Domain/Repository/
    :classicPath: /Classes/Domain/Repository/
    :regex: /^.*\/Domain\/Repository\/.*Repository\.php$/
    :shortDescription: Contains data repository classes.

    Contains data repository classes. In Extbase a repository inherits from
    :php:`\TYPO3\CMS\Extbase\Persistence\Repository`. See also
    `Extbase Repository <https://docs.typo3.org/permalink/t3coreapi:extbase-repository>`_.

..  typo3:file:: MyViewHelper.php
    :scope: extension
    :composerPath: /Classes/ViewHelpers/
    :classicPath: /Classes/ViewHelpers/
    :regex: /^.*\/ViewHelpers\/.*\.php/
    :shortDescription: Helper classes used in Fluid templates.

    Helper classes used in Fluid templates. See also
    `Developing a custom ViewHelper <https://docs.typo3.org/permalink/t3coreapi:fluid-custom-viewhelper>`_.
