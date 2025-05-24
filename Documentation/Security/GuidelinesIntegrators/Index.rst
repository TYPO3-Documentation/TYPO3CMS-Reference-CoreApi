:navigation-title: Integration

..  include:: /Includes.rst.txt
..  index:: Security guidelines; Integrators
..  _security-integrators:

=========================================
Security guidelines for TYPO3 integrators
=========================================

TYPO3 integrators are responsible for configuring and customizing the system,
installing extensions, and managing backend access. Their work plays a critical
role in the overall security of a TYPO3 site.

This chapter outlines key responsibilities and security recommendations for
TYPO3 integrators.


Please see the chapters below for further security related topics of interest
for integrators:

..  toctree::
    :titlesonly:
    :caption: Further topics

    InstallTool
    GlobalTypo3Options
    SecurityWarningsAfterLogin
    ReportsAndLogs
    AccessPrivileges
    Extensions
    Typoscript
    ContentElements

..  index::
   Security guidelines; User roles
   Security guidelines; Integrator role
..  _security-integrator-definition:

Role definition
===============

A TYPO3 integrator develops the template for a website, selects,
imports, installs and configures extensions and sets up access rights
and permissions for editors and other backend users. An integrator
usually has "administrator" access to the TYPO3 system, should have a
good knowledge of the general architecture of TYPO3 (frontend,
backend, extensions, TypoScript, TSconfig, etc.) and should be able to
configure a TYPO3 system properly and securely.

Integrators know how to use the Install Tool, the meaning of
configurations in :file:`config/system/settings.php` and the basic
structure of files and directories used by TYPO3.

The installation of TYPO3 on a web server or the configuration of the
server itself is not part of an integrator's duties but of a :ref:`system
administrator <security-administrators>`. An integrator does not develop
extensions but should have basic programming skills and database knowledge.

The TYPO3 integrator knows how to configure a TYPO3 system, handed
over from a system administrator after the installation. An integrator
usually consults and trains editors (end-users of the system, e.g. a
client) and works closely together with system administrators.

The role of a TYPO3 integrator often overlaps with a system
administrator and often one person is in both roles.


..  index:: Security guidelines; General rules
..  _security-integrator-rules:

General rules
=============

All :ref:`general rules <security-administrators>` for a system administrator
also apply for a TYPO3 integrator. One of the most important rules is to change the
username and password of the "admin" account immediately after a TYPO3 system
was handed over from a system administrator to an integrator, if not
already done. The same applies to the Install Tool password, see
below.

In addition, the following general rules apply for a TYPO3 integrator:

#.  Ensure backend users only have the permissions they need to do their
    work, nothing more – and especially no administrator privileges, see
    explanations below.

#.  Ensure, the TYPO3 sites they are responsible for, always run a stable
    and secure TYPO3 Core  version and always and only contain secure extensions
    (integrators update them immediately if a vulnerability has been
    discovered).

#.  Stay informed about TYPO3 Core  updates. Integrators should know the
    changes when new TYPO3 major versions are released and should be aware
    of the impacts and risks of an update.

#.  Integrators check for extension updates regularly and/or they know how
    to configure a TYPO3 system to notify them about new extension
    versions.
