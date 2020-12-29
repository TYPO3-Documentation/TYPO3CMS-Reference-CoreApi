.. include:: /Includes.rst.txt
.. _security-general-information:

===================
General Information
===================

.. index::
   pair: Security guidelines; TYPO3 versions
   Security guidelines; Long term support
   Long term support
   see: LTS; Long term support
   LTS
.. _security-typo3-versions:

TYPO3 versions and lifecycle
============================

TYPO3 is offered in Long Term Support (LTS) and Sprint Release versions.

The first versions of each branch are Sprint Release versions. A Sprint Release
version only receives support until the next Sprint Release got published. E.g.
TYPO3 `9.0.0` was the first Sprint Release of the `9` branch and its support
ended when TYPO3 `9.1.0` got released.

An LTS version is planned to be created every 18 months. LTS versions are created
from a branch in order to finalize it: Prior to reaching LTS status, a number of
Sprint Releases has been created from that branch and the release of an LTS version
marks the point after which no new features will be added to this branch. LTS
versions get full support (bug fixes and security fixes) for at least three years.
TYPO3 version 8 (`v8`) and v9 are such LTS versions.

Starting with TYPO3 v7 the minor-versions are skipped in the official
naming. 7 LTS is version` 7.6` internally, 8 LTS is `8.7` and 9 LTS is `9.5`. Versions inside a
major-version have minor-versions as usual (`9.0`, `9.1`, ...) until at some
point the branch receives LTS-status.

Support and security fixes are provided for the current as well as the
preceding LTS release. For example, when TYPO3 v9 is the current LTS release,
TYPO3 v8 is still actively supported, including security updates.

For users of v8 an update to v9 is recommended. All versions below TYPO3 v8 are
outdated and the regular support of these versions has ended, including security updates.
Users of these versions are strongly encouraged to update their systems
as soon as possible.

In cases where users can't yet upgrade to a supported version, the TYPO3 GmbH is offering
an Extended Long Term Support (ELTS) service for up to three years after the regular support has ended.
Subscribers to the ELTS plans receive security and compatibility updates.

Information about ELTS is available at `https://typo3.com/products/extended-support
<https://typo3.com/products/extended-support>`_

LTS and Sprint Releases offer new features and often a modified
database structure. Also the visual appearance and handling of the
backend may be changed and appropriate training for editors may be
required. The content rendering may change, so that updates in
`TypoScript`, templates or `CSS` code may be necessary. With LTS and
Sprint Releases also the system requirements (for example PHP or MySQL
version) may change. For a patch level releases (i.e.
changing from release `9.5.0` to `9.5.1`) the database structure and
backend will usually not change and an update will only require the
new version of the source code.

List of TYPO3 LTS releases:

* v7 (7.6.0 LTS): versions 7.0 through 7.5 do not receive security upgrades any longer
* v8 (8.7.0 LTS): versions 8.0 through 8.6 do not receive security upgrades any longer
* v9 (9.5.0 LTS): versions 9.0 through 9.4 do not receive security upgrades any longer
* v10 (10.4.0 LTS): versions 10.0 through 10.3 do not receive security upgrades any longer


.. _security-difference-core-extensions:

Difference between Core and extensions
======================================

The TYPO3 base system is called the Core. The functionality of the
Core can be expanded, using extensions. A small, selected number of
extensions (the system extensions) are being distributed as part of
the TYPO3 Core. The Core and its system extensions are being developed
by a relatively small team (40-50 people), consisting of experienced
and skilled developers. All code being submitted to the Core is
reviewed for quality by other Core Team members.

Currently there are more than 5500 extensions available in the TYPO3
Extension Repository (TER), written by some 2000 individual
programmers. Since everybody can submit extensions to the TER, the
code quality varies greatly. Some extensions show a very high level of
code quality, while others have been written by amateurs. Most of the
known security issues in TYPO3 have been found in these extensions,
which are not part of the Core system.


.. _security-announcement-updates:

Announcement of updates and security fixes
==========================================

Information about new TYPO3 releases as well as security bulletins are
being announced on the "TYPO3 Announce" mailing list. Every system
administrator who hosts one or more TYPO3 instances, and every TYPO3
integrator who is responsible for a TYPO3 project should subscribe to
this mailing list, as it contains important information. You can
subscribe at `http://lists.typo3.org/cgi-
bin/mailman/listinfo/typo3-announce <http://lists.typo3.org/cgi-
bin/mailman/listinfo/typo3-announce>`_

This is a read-only mailing list, which means that you cannot reply to
a message or post your own messages. The announce list typically does
not distribute more than 3 or 4 mails per month. However it is highly
recommended to carefully read every message that arrives, because they
contain important information about TYPO3 releases and security
bulletins.

Other communication channels such as https://news.typo3.org/, a RSS feed,
an official Twitter account `@typo3\_security <https://twitter.com/typo3_security>`_  etc.
can be used additionally to stay up-to-date on security advisories.

.. index::
   Security guidelines; Security bulletins
   Security bulletins
.. _security-bulletins:


Security bulletins
==================

When security updates for TYPO3 or an extension become available, they
will be announced on the "TYPO3 Announce" mailing list, as described
above, but also published with much more specific details on the
official TYPO3 Security Team website at
`https://typo3.org/help/security-advisories/
<https://typo3.org/help/security-advisories/>`_

Security bulletins for the TYPO3 Core  are separated from security
bulletins for TYPO3 extensions. Every bulletin has a unique advisory
identifier such as TYPO3-CORE-SA-yyyy-nnn (for bulletins applying to
the TYPO3 Core ) and TYPO3-EXT-SA-yyyy-nnn (for bulletins applying to
TYPO3 extensions), where yyyy stands for the appropriate year of
publication and nnn for a consecutively increasing number.

The bulletins contain information about the versions of TYPO3 or
versions of the extension that are affected and the type of security
issue (e.g. information disclosure, cross-site scripting, etc.). The
bulletin does not contain an exploit or a description on how to
(ab)use the security issue.

The severity is an indication on how important the issue is:


.. ### BEGIN~OF~SIMPLE~TABLE ###

.. Note: The exact "styling" of the following table is important.
   There may be no text in the column margin.

============   ======================================================
Severity       Meaning
============   ======================================================
**Critical**   This is a critical security issue and action should be
               taken immediately (on the day of the release).
**High**       This is an important security issue and action should
               be taken as soon as possible.
**Medium**     Your website may be affected by this issue and you
               should consider taking action as soon as feasible.
**Low**        There is a good chance that your site is not affected
               by this issue or that it can be exploited only in
               special circumstances. However, you should check
               whether your site is at risk and consider necessary
               action.
============   ======================================================


.. ###### END~OF~SIMPLE~TABLE ######


For TYPO3 extensions, there are two types of security bulletins:

- Individual Security Bulletin: bulletins issued for extensions that
  have a high number of downloads and are used in many projects.

- Collective Security Bulletins: updates for extensions with a relative
  small number of downloads are published in a collective bulletin. Such
  a bulletin may contain information about 10 or even more extensions.

For some critical security issues the TYPO3 Security Team may decide
to pre-announce a security bulletin on the "TYPO3 Announce" mailing
list. This is to inform system administrators about the date and time
of an upcoming important bulletin, so that they can schedule the
update.

Security issues in the TYPO3 Core  which are only exploitable by users
with administrator privileges (including system components that are
accessible by administrators only, such as the Install Tool) are
treated as normal software "bugs" and are fixed as part of the
standard Core review process. This implies that the development of the
fix including the review and deployment is publicly visible and can be
monitored by everyone.

.. index::
   Security bulletins; Public service announcements
   Public service announcements
   see: PSA; Public service announcements
   PSA

Public service announcements
----------------------------

Important security related information regarding TYPO3 products or the
typo3.org infrastructure are published as so called "Public Service
Announcements" (PSA). Unlike other advisories, a PSA is usually not
accompanied by a software release, but still contain information about
how to mitigate a security related issue.

Topics of these advisories include security issues in third party
software like such as Apache, Nginx, MySQL, PHP, etc. that are related
to TYPO3 products, possible security related misconfigurations in third
party software, possible misconfigurations in TYPO3 products, security
related information about the server infrastructure of typo3.org and
other important recommendations how to securely use TYPO3 products.

.. index::
   Security bulletins; Common vulnerability scoring system
   Common vulnerability scoring system
   see: CVSS; Common vulnerability scoring system
   CVSS

Common vulnerability scoring system (CVSS)
------------------------------------------

Since 2010 the TYPO3 Security Team also publishes a CVSS rating with
every security bulletin. CVSS ("Common Vulnerability Scoring System" is
a free and open industry standard for communicating the characteristics
and impacts of vulnerabilities in Information Technology. It enables
analysts to understand and properly communicate disclosed vulnerabilities
and allows responsible personnel to prioritize risks. Further details
about CVSS are available at `https://www.first.org/cvss/user-guide
<https://www.first.org/cvss/user-guide>`_

