.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Extensions
.. _security-extensions:

================
TYPO3 extensions
================

As already mentioned above, most of the security issues have been
discovered in TYPO3 extensions, not in the TYPO3 Core . Due to the fact
that everybody can publish an extension in the TYPO3 repository, you
never know how savvy and experienced the programmer is and how the
code was developed from a security perspective.

The following sections deal with extensions in general, the risks and
the basic countermeasures to address security related issues.


Stable and reviewed extensions
==============================

Only a small percentage of the extensions available in the TER have
been reviewed by the TYPO3 Security team. This does not imply that
extensions without such an audit are insecure, but they probably have
not been checked for potential security issues by an independent 3rd
party (such as the TYPO3 Security Team).

The status of an extension (`alpha`, `beta`, `stable`, etc.) should
also give you an indication in which state the developer claims the
extension is. However, this classification is an arbitrary setting by
the developer and may not reflect the real status and/or opinions of
independent parties.

Always keep in mind that an extension may not perform the
functionality that it pretends to do: An attacker could write an
extension that contains malicious code or functions and publish it
under a promising name. It is also possible that a well-known,
harmless extension will be used for an attack in the future by
introducing malicious code with an update. In a perfect world, every
updated version would be reviewed and checked, but it is
understandable that this approach is unlikely to be practical in most
installations.

Following the guidelines listed below would improve the level of
security, but the trade-off would be more effort in maintaining your
website and a delay of updating existing extensions, which would
possibly be against the :ref:`react quickly <security-react-quickly>` paradigm.
Thus, it depends on the specific case and project, and the intention
of listing the points below is more to raise the awareness of possible
risks.

* Do not install extensions or versions marked as `alpha` or `obsolete`:
  The developer classified the code as a early version, preview,
  prototype, proof-of-concept and/or as not maintained – nothing you
  should install on a production site.

- Be very careful when using extensions or versions marked as `beta`:
  According to the developer, this version of the extension is still in
  development, so it is unlikely that any security-related tests or
  reviews have been undertaken so far.

- Be careful with extensions and versions marked as `stable`, but not
  reviewed by the TYPO3 Security Team.

- Check every extension and extension update before you install it on a
  production site and review it in regards to security, see
  :ref:`Use staging servers for developments and tests <security-staging-servers>`.


Executable binaries shipped with extensions
===========================================

TYPO3 extensions (:file:`.zip` files) are packages, which may contain any kind
of data/files. This can be readable PHP or Javascript source code, as well as
binary files like compiled executables, e.g. Unix/Linux ELF files or Microsoft
Windows .exe files.

Executing these files on a server is a security risk, because it can not
be verified what these files really do (unless they are
reverse-engineered or dissected likewise). Thus it is highly recommended
**not** to use any TYPO3 extensions, which contain executable binaries.
Binaries should only come from trusted and/or verified sources such as
the vendor of your operating system - which also ensures, these binaries
get updated in a timely manner, if a security vulnerability is
discovered in these components.


Remove unused extensions and other code
=======================================

TYPO3 distinguishes between "imported" and "loaded" extensions.
Imported extensions exist in the system and are ready to be integrated
into TYPO3 but they are not installed yet. Loaded extensions are
available for being used (or are being used automatically, depending
on their nature), so they are "installed".

A dangerous and loaded extension is able to harm your system in
general because it becomes part of the system (functions are
integrated into the system at runtime). Even extensions which are not
loaded (but only "imported") include a kind of risk because their code
may contain malicious or vulnerable functions which in theory could be
used to attack the system.

As a general rule, it is highly recommended you remove all code from
the system that is not in use. This includes TYPO3 extensions, any
TypoScript (see below), PHP scripts as well as all other functional
components. In regards to TYPO3 extensions, you should remove unused
extensions from the system (not only unload/deinstall them). The
*Extension Manager* offers an appropriate function for this - an
administrator backend account is required.


.. _security-extensions-low-level:

Low-level extensions
====================

So called "low-level" extensions provide "questionable" functionality
to a level below what a standard CMS would allow you to access. This
could be for example direct read/write access to the file system or
direct access to the database (see :ref:`Guidelines for System
Administrators: Database access <security-database-access>`). If a TYPO3 integrator
or a backend user (e.g. an editor) depends on those extensions, it is most
likely that a misconfiguration of the system exists in general.

TYPO3 extensions like `phpMyAdmin`, various file browser/manager
extensions, etc. may be a good choice for a development or test
environment but are definitely out of place at production sites.

Extensions that allow editors to include PHP code must be avoided, too.


Check for extension updates regularly
=====================================

The importance of the knowledge that security updates are available
has been discussed above (see :ref:`TYPO3 security-bulletins
<security-bulletins>`). It is also essential to know how to check for
extension updates: the *Extension Manager* (EM) is a TYPO3 backend module
accessible for backend users with administrator privileges.
A manual check for extension updates is available in this module.

The EM uses a cached version of the extension list from the TYPO3
Extension Repository (TER) to compare the extensions currently
installed and the latest versions available. Therefore, you should
retrieve an up-to-date version of the extension list from TER before
checking for updates.

If extension updates are available, they are listed together with a
short description of changes (the "upload comment" provided by the
extension developers) and you can download/install the updates if
desired. Please note that under certain circumstances, new versions
may behave differently and a test/review is sometimes useful,
depending on the nature and importance of your TYPO3 instance.
Often a new version of an extension published by the developer is not
security-related.

A scheduler task is available that lets you update the extension list
automatically and periodically (e.g. once a day). In combination with
the task "System Status Update (reports)", it is possible to get a
notification by email when extension updates are available.


Security-related extensions
===========================

TYPO3 extensions which are not part of the Core (and so are not
official system extensions) are out of scope of this document, due to
the fact that this Security Guide focuses on a TYPO3 standard setup.

However, there is a wide range of very useful TYPO3 extensions
available in the TYPO3 Extension Repository (TER) which increase the
level of security and/or support system administrators and TYPO3
integrators to monitor their TYPO3 installations, check for
security-related issues, access additional reports and be notified in
various ways.

Searching for relevant keywords such as "security", "monitoring" or a
specific technology (e.g. "intrusion detection") or a security threat
(e.g. "XSS", "SQL injection") or similar shows some results, which
could be reviewed and tested.

Please note that these extensions are often not developed/maintained
by TYPO3 Core  developers and the code quality may vary. Also, check
for extensions reviewed by the Security Team and the date of the last
update.
