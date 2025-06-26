:navigation-title: Introduction

..  include:: /Includes.rst.txt
..  _site-package-introduction:

=====================================
Introduction into using site packages
=====================================

..  _site-package-benefits:

Site package benefits
=====================

Developing a website can be approached in different ways. Standard
websites usually consist of HTML documents which contain text and reference
image files, video files, styles, etc. Because it is an enterprise content
management system, TYPO3 features a clean separation between design, content and
functionality and allows developers/integrators to add simple or
sophisticated functionality easily.

..  _site-package-encapsulation:

Encapsulation
-------------

Using extensions is a powerful way to get the most out of TYPO3. Extensions
can be installed, uninstalled and replaced. They can extend the core TYPO3
system with further functions and features. An extension typically
consists of PHP files, and can also contain design templates (HTML,
CSS, JavaScript files, etc.) and global configuration settings. The visual
appearance of a website does not necessarily require any PHP code. However, the
site package extension described in this tutorial contains exactly two PHP files
(plus a handful of HTML/CSS and configuration files) and is an *extension* to
TYPO3. The PHP code can be copied from this tutorial if the reader does not
have any programming knowledge.

..  _site-package-version-controll:

Version control
---------------

In building the site package as an extension, all relevant files are stored in
one place and changes can easily be tracked in a version control system
such as Git. The site package approach is not the only way of creating TYPO3
websites but it is flexible and professional and not overly complicated.

..  _site-package-di:

Dependency management
---------------------

TYPO3 extensions allow dependencies to other extensions and/or the TYPO3 version
to be defined. This is called "Dependency Management" and makes deployment easy
and fail-safe. Most TYPO3 sites are dependent on a number of extensions. Some
examples are "News" or "Powermail". A site package extension which contains
global configuration settings for these extensions will define the dependencies
for you. When the site package extension is installed in an
empty TYPO3 instance, all dependent extensions are automatically downloaded from
the `TYPO3 Extension Repository <https://extensions.typo3.org>`__ and installed.

..  _site-package-separation:

Clean separation from the userspace
-----------------------------------

In a TYPO3 installation that doesn't use extensions, template files are often
stored in the :file:`fileadmin/` directory. Files in
this directory are indexed by TYPO3's :ref:`File Abstraction Layer (FAL) <t3coreapi:fal>` resulting in
possibly irrelevant records in the database. To avoid this the :file:`fileadmin/`
area should be seen as a "userspace" which is only available for editors to
use. Even if access permissions restrict editors from accessing or manipulating
files in :file:`fileadmin/`, site configuration components should
still not be stored in the userspace.

..  _site-package-security:

Security
--------

Files in :file:`fileadmin/` are typically meant to be publicly accessible by
convention. To avoid disclosing sensitive system information (see the
:ref:`TYPO3 Security Guide <t3coreapi:security>` for further details),
configuration files should not be stored in :file:`fileadmin/`.

..  _site-package-deployment:

Deployment
----------

TYPO3 follows the *convention over configuration*
paradigm. If files and directories in the site-package
extension use the naming convention, they are loaded automatically as
soon as the extension is installed/activated. This means the
extension can be easily deployed using Composer.
Deployment can be automated by system administrators.

..  _site-package-distributable:

Distributable
-------------

By virtue of the motto "TYPO3 inspires people to share!", the site package
extension can be shared with the community via the official `TYPO3
Extension Repository <https://extensions.typo3.org>`__ and/or in a publicly
accessible version control system such as `GitHub <https://github.com>`__.

Last, but not least, configuration settings in the site package can
be overwritten using TypoScript setup and constants.
