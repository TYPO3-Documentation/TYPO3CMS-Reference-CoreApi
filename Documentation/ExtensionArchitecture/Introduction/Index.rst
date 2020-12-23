.. include:: /Includes.rst.txt

.. _extension-architecture-introduction:

Introduction
============

`TYPO3 CMS`:pn: is entirely built around the concept of extensions. The `Core`:pn:
is entirely comprised of extensions, called "system extensions".
Some are required and will always be activated. Others can be activated
or deactivated at will.

Many more extensions - developed by the community - are available in the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/>`_.

Yet more extensions are not officially published and are available straight
from source code repositories like `GitHub <https://github.com/>`_.

It is also possible to set up `TYPO3 CMS`:pn: using `Composer`:pn:. This opens
the possibility of including any library published on
`Packagist <https://packagist.org/>`_.

`TYPO3`:pn: can be extended in nearly any direction without losing
backwards compatibility. The Extension API provides a powerful
framework for easily adding, removing, installing and developing such
extensions to `TYPO3`:pn:.

"*Extensions*" is a general term in TYPO3 which covers many kinds of
additions to `TYPO3`:pn:. The main types are:

- **Plugins** which play a role on the website itself, for example a discussion
  board, guestbook, shop, etc. Therefore plugins are content elements, that can
  be placed on a page like a text element or an image.

- **Modules** are backend applications which have their own entry in the
  main menu. They require a backend login and work inside the framework
  of the backend. We might also call something a module if it exploits
  any connectivity of an existing module, that is if it simply adds
  itself to the function menu of existing modules. A module is an
  extension in the backend.

- **Distributions** are fully packaged`TYPO3 CMS`:pn: web installations,
  complete with files, templates, extensions, etc. Distributions are
  covered :ref:`in their own chapter <distribution>`.

.. _extensions-and-core:

Extensions and the `Core`:pn:
-----------------------------

Extensions are designed in a way so that extensions can supplement the
`Core`:pn: seamlessly. This means that a TYPO3 system will appear as "a
whole" while actually being composed of the `Core`:pn: application *and* a
set of extensions providing various features. This philosophy allows
`TYPO3`:pn: to be developed by many individuals without losing fine control
since each developer will have a special area (typically a system
extension) of responsibility which is effectively encapsulated.

So, at one end of the spectrum system extensions make up what is
known as "TYPO3" to the outside world. At the other end, extensions
can be entirely specific to a given project and contain only files and functionality
related to a single implementation.


.. index:: System extensions
.. _extensions-core:

Notable system extensions
-------------------------

This section describes the main system extensions, their use and
what main resources and libraries they contain. The system extensions
are located in directory :file:`typo3/sysext`.

`core`
  As its name implies, this extension is crucial to the working of`TYPO3 CMS`:pn:.
  It defines the main database tables (backend users, backend groups, pages and all the
  "sys\_*" tables. It also contains the default global configuration
  (in :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`). Last
  but not least, it delivers a huge number of base PHP classes, far too many
  to describe here.

backend
  This system extension provides all that is necessary to run the`TYPO3 CMS`:pn:
  backend. This means quite a few PHP classes, a lot of controllers and `Fluid`:pn: templates.

frontend
  This system extension contains all the tools for performing rendering in
  the frontend, i.e. the actual web site. It is mostly comprised of PHP classes,
  in particular those in :file:`typo3/sysext/frontend/Classes/ContentObject`,
  which are used for rendering the various content objects (one class per object
  type, plus a number of base and utility classes).

`Extbase`:pn:
  `Extbase`:pn: is an MVC framework, with the "View" part being actually the system extension "fluid".
  Not all of the`TYPO3 CMS`:pn: backend is written in `Extbase`:pn:, but some modules are.

`Fluid`:pn:
  `Fluid`:pn: is a templating engine. It forms the "View" part of the MVC framework.
  The templating engine itself is provided as `Fluid`:pn:  standalone which can be used
  in other frameworks or as a standalone templating engine.
  This system extension provides a number of classes and many `ViewHelpers`:pn:
  (in :file:`typo3/sysext/fluid/Classes/ViewHelpers`), which
  extend the basic templating features of standalone `Fluid`:pn:. `Fluid`:pn: can be used in conjunction
  with `Extbase`:pn: (where it is the default template engine), but also in non-extbase extensions.

install
  This system extension is the package containing the`TYPO3 CMS`:pn: Install Tool.

