:navigation-title: Security Threats

..  include:: /Includes.rst.txt
..  _security-threats:

=========================
Types of Security Threats
=========================

This section provides a brief overview of the most common security
threats to give the reader a basic understanding of them. The sections
for system administrators, TYPO3 integrators and editors explain in
more detail how to secure a system against those threats.

..  index:: pair: Security; Information disclosure
..  _security-information-disclosure:

Information disclosure
======================

This means that the system makes (under certain circumstances)
information available to an outside person. Such information could be
sensitive user data (e.g. names, addresses, customer data, credit card
details, etc.) or details about the system (such as the file system
structure, installed software, configuration options, version numbers,
etc). An attacker could use this information to craft an attack
against the system.

There is a fine line between the protection against information
disclosure and so called "security by obscurity". Latter means, that
system administrators or developers try to protect their
infrastructure or software by hiding or obscuring it. An example would
be to not reveal that TYPO3 is used as the content management system
or a specific version of TYPO3 is used. Security experts say, that
"security by obscurity" is not security, simply because it does not
solve the root of a problem (e.g. a security vulnerability) but tries
to obscure the facts only.

..  index:: pair: Security; Identity theft
..  _security-identity-theft:

Identity theft
==============

Under certain conditions it may be possible that the system reveals
personal data, such as customer lists, e-mail addresses, passwords,
order history or financial transactions. This information can be used
by criminals for fraud or financial gains. The server running a TYPO3
website should be secured so that no data can be retrieved without the
consent of the owner of the website.

..  index::
   SQL; Injection
   pair: Security; SQL injections
..  _security-sql-injection:

SQL injection
=============

With SQL injection the attacker tries to submit modified SQL
statements to the database server in order to get access to the
database. This could be used to retrieve information such as customer
data or user passwords or even modify the database content such as
adding administrator accounts to the user table. Therefore it is
necessary to carefully analyze and filter any parameters that are used
in a database query.


..  index:: pair: Security; Code injection
..  _security-code-injection:

Code injection
==============

Similar to SQL injection described above, "code injection" includes
commands or files from remote instances (RFI: Remote File Inclusion)
or from the local file system (LFI: Local File Inclusion). The fetched
code becomes part of the executing script and runs in the context of
the TYPO3 site (so it has the same access privileges on a server
level). Both attacks, RFI and LFI, are often triggered by improper
verification and neutralization of user input.

Local file inclusion can lead to information disclosure (see above),
for example reveal system internal files which contain configuration
settings, passwords, encryption keys, etc.


..  index:: pair: Security; Authentication bypass
..  _security-authorization-bypass:

Authentication bypass
=====================

In an authorization bypass attack, an attacker exploits
vulnerabilities in poorly designed applications or login forms (e.g.
client-side data input validation). Authentication modules shipped
with the TYPO3 Core  are well-tested and reviewed. However, due to the
open architecture of TYPO3, this system can be extended by alternative
solutions. The code quality and security aspects may vary, see chapter
:ref:`Guidelines for TYPO3 Integrators: TYPO3 extensions
<security-extensions>` for further details.

..  index::
   ! Cross-site scripting
   XSS
   see: XSS; Cross-site scripting
..  _security-xss:

Cross-site scripting (XSS)
==========================

Cross-site scripting occurs when data that is being processed by an
application is not filtered for any suspicious content. It is most
common with forms on websites where a user enters data which is then
processed by the application. When the data is stored or sent back to
the browser in an unfiltered way, malicious code may be executed. A
typical example is a comment form for a blog or guest book. When the
submitted data is simply stored in the database, it will be sent back
to the browser of visitors if they view the blog or guest book
entries. This could be as simple as the inclusion of additional text
or images, but it could also contain JavaScript code of iframes that
load code from a 3rd party website.

Implementing :ref:`Content Security Policy <content-security-policy>` headers
can reduce the risk of cross-site scripting.

..  index::
   ! Cross-site request forgery
   XSRF
   see: XSRF; Cross-site request forgery
..  _security-xsrf:

Cross-site request forgery (XSRF)
=================================

In this type of attack unauthorized commands are sent from a user a
website trusts. Consider an editor that is logged in to an application
(like a CMS or online banking service) and therefore is authorized in
the system. The authorization may be stored in a session cookie in the
browser of the user. An attacker might send an e-mail to the person
with a link that points to a website with prepared images. When the
browser is loading the images, it might actually send a request to the
system where the user is logged in and execute commands in the context
of the logged-in user.

One way to prevent this type of attack is to include a secret token
with every form or link that can be used to check the authentication
of the request.
