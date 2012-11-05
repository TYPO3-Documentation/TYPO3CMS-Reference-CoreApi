.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _typo3-versions:
.. _typo3-lifecycle:


TYPO3 versions and lifecycle
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TYPO3 uses a system of major, minor and revision numbers for
individual releases. For example, in release 4.6.0 the major version
is 4, the minor version is 6 and the revision is 0. When considering
the major and minor numbers, support and security fixes are provided
for the current release as well as the two preceding releases. For
example, when version 4.6.x is the current release, versions 4.5.x and
4.4.x are still actively supported, including security updates.

Major and minor releases offer new features and often a modified
database structure. Also the visual appearance and handling of the
backend may be changed and appropriate training for editors may be
required. The content rendering may change, so that updates in
TypoScript, templates or CSS code may be necessary. With major and
minor releases also the system requirements (for example PHP or MySQL
version) may change. For revisions within a minor release (i.e.
changing from release 4.6.0 to 4.6.1) the database structure and
backend will usually not change and an update will only require the
new version of the source code.

A TYPO3 version which shows two minor versions below the current
release is classified as a deprecated version. For example when
version 4.6 is the current release, this is version 4.4.x. For users
of this version an update to the latest stable version is recommended.
All versions below a deprecated version are outdated and the support
of these versions has ended, including security updates. Users of
these versions are strongly encouraged to update their systems as soon
as possible.

