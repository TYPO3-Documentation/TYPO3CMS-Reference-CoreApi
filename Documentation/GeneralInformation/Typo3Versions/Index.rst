.. include:: ../../Includes.txt


.. _typo3-versions:
.. _typo3-lifecycle:


TYPO3 CMS versions and lifecycle
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TYPO3 CMS uses a principle of major, minor and revision numbers for
individual releases. For example, in release 4.7.0 the major version
is 4, the minor version is 7 and the revision is 0. When considering
the major and minor numbers, support and security fixes are provided
for the current release as well as the two preceding releases. For
example, when version 4.7.x was the current release, versions 4.6.x and
4.5.x were still actively supported, including security updates.

This schema also applies to TYPO3 CMS version 6.0.0 and above.
Please note that TYPO3 CMS version 5 never existed as explained in an
article at:
`http://typo3.org/news/article/from-47-to-60-a-brief-history-of-typo3-versioning/
<http://typo3.org/news/article/from-47-to-60-a-brief-history-of-typo3-versioning/>`_

Major and minor releases offer new features and often a modified
database structure. Also the visual appearance and handling of the
backend may be changed and appropriate training for editors may be
required. The content rendering may change, so that updates in
TypoScript, templates or CSS code may be necessary. With major and
minor releases also the system requirements (for example PHP or MySQL
version) may change. For revisions within a minor release (i.e.
changing from release 6.0.0 to 6.0.1) the database structure and
backend will usually not change and an update will only require the
new version of the source code. The terminology "patch" is sometimes
used instead of revision, for example: "major, minor and patch" number.

A TYPO3 CMS version which shows two minor versions below the current
release is classified as a deprecated version. For example when
version 6.0 is the current release, the deprecated is version 4.6.x.
For users of this version an update to the latest stable version is
recommended. All versions below a deprecated version are outdated and
the support of these versions has ended, including security updates.
Users of these versions are strongly encouraged to update their systems
as soon as possible.

LTS ("Long Term Support") versions are an exception: these versions get
full support (bug fixes and security fixes) for at least three years.
TYPO3 CMS version 4.5, 6.2 and 7 are such LTS versions.
Starting with TYPO3 CMS 7 LTS the minor-versions are skipped in the official
naming. So 7 LTS is 7.6 internally. Versions inside a major-version have
minor-versions as usual (7.0, 7.1, ...) until at some point it receives
LTS-status.

