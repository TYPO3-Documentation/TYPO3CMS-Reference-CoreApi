.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _encrypted-client-server-connection:

Encrypted client/server communication
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


.. _data-classification:

Data classification
"""""""""""""""""""

It depends on the nature of the data but in general "sensitive"
information could be: user logins, passwords, user details (such as
names, addresses, contact details, etc.), email addresses and other
data which are not public. Medical, financial data (e.g. credit card
details, account numbers, access codes, etc.) and others, are
confidential by their nature and must not be transmitted unencrypted
at all.

In most cases, a data assessment should be undertaken to classify the
data according to several traits relating to use, legal requirements,
and value. The outcome of this assessment can be a categorization
based on a data classification model, which then defines how to
protect the data.


.. ### BEGIN~OF~SIMPLE~TABLE ###

.. Note: The exact "styling" of the following table is important.
   There may be no text in the column margins.
   Indentation of each single line must be done with exactly the right
   number of spaces. This makes changing parts of text unnecessarily hard.
   The comment in the first cell is needed; without it the whole header
   row would not be displayed.

========================  ================  =========================  ===========================  ====================
 .. Comment (invisible)   Public            Public Restricted          Organization Confidential    Organization Secret
========================  ================  =========================  ===========================  ====================
**Type**                  non-sensitive     externally sensitive       internally sensitive         extremely sensitive
**Disclosure impact**     none              limited                    significant                  sever
**Access restrictions**   none              low (e.g. username/        high (e.g. public/private    very high
                                            password)                  key + geolocation)
**Data transport**        unencrypted       unencrypted but protected  encrypted                    highly encrypted
**Storage requirements**  none              unencrypted but protected  encrypted                    highly encrypted
========================  ================  =========================  ===========================  ====================

.. ###### END~OF~SIMPLE~TABLE ######


The secure and maybe encrypted storage of sensitive data should also
be considered.

The most secure first paradigm in most cases is: do neither transmit
nor store any sensitive data if not absolutely required.


.. _encryption-frontend:

Frontend
""""""""

Secure Sockets Layer (SSL) is an industry standard and the current
security technology for establishing an encrypted link between a
browser (client) and a web server. This protocol provides encrypted,
authenticated communications across the Internet and ensures that all
data passed between client and server remains private and integral. It
is based on a public/private key technology and uses certificates
which typically contain the domain name and details about the website
operator (e.g. company name, address, geographical location, etc.).
Recent discussions are questioning the organizational concept behind
SSL certificates and the "chain of trust", but the fact is that SSL is
the de facto standard today and still is considered secure from a
technical perspective.

Whenever sensitive data is transferred between a client (the visitor
of the website) and the server (TYPO3 website), a SSL encrypted
connection should be used.

When using payment gateways to process payments for online shops for
example, most financial institutions (e.g. credit card vendors)
require appropriate security actions. Check the policies of the
gateway operator and card issuers before you institute online payment
solutions.


.. _encryption-backend:

Backend
"""""""

A risk of unencrypted client/server communication is that an attacker
could eavesdrop the data transmission and "sniff" sensitive
information such as access details. Unauthorized access to the TYPO3
backend, especially with an administrator user account, has a
significant impact on the security of your website. It is clear that
the use of SSL for the backend of TYPO3 improves the security.

TYPO3 supports a SSL encrypted backend and offers some specific
configuration options for this purpose, see configuration option
"lockSSL" in chapter "Guidelines for TYPO3 integrators".

However, the access details used for the login are transferred between
the client and the server when submitting the login form only. After a
successful login, a session ensures that the user remains
authenticated. This results in the conclusion, that only the login
procedure should be protected, not the following client/server
communication necessarily – assuming no sensitive information are
accessed from or stored in the backend.

The TYPO3 core extension "rsaauth" addresses this requirement, see
"security-related core extensions" in chapter "Guidelines for TYPO3
integrators".


.. _encryption-other-services:

Other services
""""""""""""""

An encrypted communication between client and server for other
services than the TYPO3 frontend and backend should be considered,
too. For example, it is highly recommended to use encrypted services
such as SSH (secure shell), SFTP (SSH file transfer protocol) or FTPS
(FTP-Secure) instead of FTP, where data is transferred unencrypted.

