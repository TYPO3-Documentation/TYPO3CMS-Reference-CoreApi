:navigation-title: Editor security

..  include:: /Includes.rst.txt
..  index:: Security guidelines; Editors
..  _security-editors:

===============================
Security guidelines for editors
===============================

While editors typically do not handle technical setup, their habits and
awareness directly affect the security of the system.

..  contents:: Table of contents

..  index::
    pair: Security guidelines; User roles
    pair: Security guidelines; Editor role
..  _security-editor-definition:

Role definition
===============

Typically, a software development company or web design agency
develops the initial TYPO3 website for the client. After the delivery,
approval and training, the client is able to edit the content and
takes the role of an editor. All technical administration, maintenance
and update tasks often stay at the developer as the provider of the
system. This may vary depending on the relation and contracts between
developer and client of course.

Editors are predominantly responsible for the content of the website.
They log in to the backend of TYPO3 (the administration interface)
using their username and password. Editors add, update and remove
pages as well as content on pages. They upload files such as images or
PDF documents, create internal and external links and add/edit
multimedia elements. The terminology "content" applies to all editable
texts, images, tables, lists, possibly forms, etc. Editors sometimes
translate existing content into different languages and prepare and/or
publish news.

Depending on the complexity and setup of the website, editors possibly
work in specific "workspaces" (e.g. a draft workspace) with or without
the option to publish the changes to the "live" site. It is not
required for an editor to see the entire page tree and some areas of
the website are often not accessible and not writable for editors.

Advanced tasks of editors are for example the compilation and
publishing of newsletters, the maintenance of frontend user records
and/or export of data (e.g. online shop orders).

Editors usually do not change the layout of the website, they do not
set up the system, new backend user accounts, new site functionality
(for example, they do not install, update or remove extensions), they
do not need to have programming, database or HTML knowledge and they
do not configure the TYPO3 instance by changing TypoScript code or templates.


..  _security-editor-rules:

General rules
=============

The :ref:`General Guidelines <security-general-guidelines>` also apply to editors
– especially the section "Secure passwords" and "Operating system and browser version".

Due to the fact that editors do not change the configuration of the
system, there are only a few things editors should be aware of. As a
general rule, you should contact the person, team or agency who/which
is responsible for the system (usually the provider of the TYPO3
instance, a TYPO3 integrator or system administrator) if you determine
a system setup that does not match with the guidelines described here.


..  index:: pair: Security guidelines; Backend access
..  _security-backend-access:

Backend access
==============

Username
--------

Generic usernames such as "editor", "webmaster", "cms" or similar are
not recommended. Shared user accounts are not recommended either:
every person should have its own login (e.g. as first name + dot +
last name). The maximum number of backend user accounts is not artificially
limited in TYPO3 and they should not add additional costs.


Password
--------

Please read the :ref:`chapter about secure passwords <security-secure-passwords>`.
If your current TYPO3 password does not match the rules explained above, change your
password to a secure one as soon as possible. You should be able to
change your password in the *User settings* menu, reachable by clicking on your
user name in the :ref:`top bar <backend-modules-structure>`:

..  include:: /Images/AutomaticScreenshots/Security/ChangePassword.rst.txt


Administrator privileges
------------------------

If you are an editor for a TYPO3 website (and not a system
administrator or integrator), you should ensure that you do not have
administrator privileges. Some TYPO3 providers fear the effort to
create a proper editor account, because it involves quite a number of
additional configuration steps. If you, as an editor, should have an
account with administrator privileges, it is often an indication of a
misconfiguration.

As an indicator, if you see a section :guilabel:`Administration`
or even a section :guilabel:`System` in the :ref:`Module menu <backend-modules-structure>` ,
you definitely have the wrong permissions as an editor and you
should get in touch with the system provider to solve this issue.

..  include:: /Images/AutomaticScreenshots/AdminTools/EditorAdminPrivileges.rst.txt


Notify at login
---------------

TYPO3 offers the feature to notify backend users by email, when
somebody logs in from your account. If you set this option in your
user settings, you will receive an email from TYPO3 each time you (or
"someone") logs in using your login details. Receiving such a
notification is an additional security measure because you will know
if someone else picked up your password and uses your account.

..  include:: /Images/AutomaticScreenshots/Security/NotifyOnLogin.rst.txt

Assuming you have activated this feature and you got a notification
email but you have not logged in and you suspect that someone misuses
your credentials, get in touch with the person or company who hosts
and/or administrates the TYPO3 site immediately. You should discuss
the situation and the next steps, possibly to change the password as
soon as possible.


Lock to IP address(es)
----------------------

Some TYPO3 instances are maintained by a selected group of editors who
only work from a specific IP range or (in an ideal world) from one
specific IP address only – an office network with a static public IP
address is a typical example.

In this case, it is recommended to lock down user accounts to
these/this address(es) only, which would block any login attempt from
someone coming from an unauthorized IP address.

Implementing this additional login limitation is the responsibility of
the person or company who hosts and/or administers the TYPO3 site.
Discuss the options with them.


..  _security-restrict-to-required-functions:

Restriction to required functions
=================================

Some people believe that having more access privileges in a system is
better than having essential privileges only. This is not true from a
security perspective due to several reasons. Every additional
privilege introduces not only new risks to the system but also requires
more responsibility as well as security awareness from the user.

In most cases editors should prefer having access to functions and
parts of the website they really need to have and therefore you, as an
editor, should insist on correct and restricted access permissions.

Similar to the explanations above: too extensive and unnecessary
privileges are an indication of a badly configured system and
sometimes a lack of professionalism of the system administrator,
hosting provider or TYPO3 integrator.


..  index:: Security guidelines; Secure connections
..  _security-secure-connection:

Secure connection
=================

You should always use the secure, encrypted connection between your computer
and the TYPO3 backend. This is done by using the prefix `https://` instead of
`http://` at the beginning of the website address (URL). Nowadays, both the TYPO3
backend and frontend should be always - and exclusively - accessible via
`https://` only and invalid certificates are no longer acceptable. Please clarify
with the system administrator if no encrypted connection is available.

Under specific circumstances, a secure connection is technically
possible but an invalid SSL certificate causes a warning message. In
this case you may want to check the details of the certificate and let
the hosting provider fix this.


..  _security-logout:

Logout
======

When you finished your work as an editor in TYPO3, make sure to
explicitly logout from the system. This is very important if you are
sharing the computer with other people, such as colleagues, or if you
use a public computer in a library, hotel lobby or internet café. As
an additional security measure, you may want to clear the browser
cache and cookies after you have logged out and close the browser
software.

In the standard configuration of TYPO3 you will automatically be
logged out after 8 hour of inactivity or when you access TYPO3 with
a different IP address.
