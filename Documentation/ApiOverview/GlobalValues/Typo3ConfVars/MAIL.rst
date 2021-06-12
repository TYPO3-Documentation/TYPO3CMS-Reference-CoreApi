.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; MAIL
   TYPO3_CONF_VARS MAIL
.. _typo3ConfVars_mail:

===================================
$GLOBALS['TYPO3_CONF_VARS']['MAIL']
===================================

.. index::
   TYPO3_CONF_VARS MAIL; format
.. _typo3ConfVars_mail_format:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['format']
=============================================

.. confval:: format

   :type: dropdown
   :Default: 'both'
   :allowedValues:
      html
         Send emails only in HTML format
      txt
         Send emails only in plain text format
      both
         Send emails in HTML and plain text format

   The :ref:`Mailer API<mail>` allows to send out templated emails, which can be configured
   on a system-level to send out HTML-based emails or plain text emails, or
   emails with both variants.

.. index::
   TYPO3_CONF_VARS MAIL; layoutRootPaths
.. _typo3ConfVars_mail_layoutRootPaths:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths']
======================================================

.. confval:: layoutRootPaths

   :type: array
   :Default:
      .. code-block:: php

         [
            0 => 'EXT:core/Resources/Private/Layouts/',
            10 => 'EXT:backend/Resources/Private/Layouts/'
         ]

   List of paths to look for layouts for templated emails. Should be specified
   as .txt and .html files.

.. index::
   TYPO3_CONF_VARS MAIL; partialRootPaths
.. _typo3ConfVars_mail_partialRootPaths:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths']
=======================================================

.. confval:: partialRootPaths

   :type: array
   :Default:
      .. code-block:: php

         [
            0 => 'EXT:core/Resources/Private/Partials/',
            10 => 'EXT:backend/Resources/Private/Partials/'
         ]

   List of paths to look for partials for templated emails. Should be
   specified as .txt and .html files.

.. index::
   TYPO3_CONF_VARS MAIL; templateRootPaths
.. _typo3ConfVars_mail_templateRootPaths:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']
========================================================

.. confval:: templateRootPaths

   :type: array
   :Default:
      .. code-block:: php

         [
            0 => 'EXT:core/Resources/Private/Templates/Email/',
            10 => 'EXT:backend/Resources/Private/Templates/Email/'
         ]

   List of paths to look for template files for templated emails. Should be
   specified as .txt and .html files.

.. index::
   TYPO3_CONF_VARS MAIL; validators
.. _typo3ConfVars_mail_validators:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['validators']
=================================================

.. confval:: validators

   :type: array
   :Default: :php:`[\Egulias\EmailValidator\Validation\RFCValidation::class]`

   List of validators used to validate an email address.

   Available validators are:

   *  :php:`\Egulias\EmailValidator\Validation\DNSCheckValidation`
   *  :php:`\Egulias\EmailValidator\Validation\SpoofCheckValidation`
   *  :php:`\Egulias\EmailValidator\Validation\NoRFCWarningsValidation`

   or by implementing a custom validator.

.. index::
   TYPO3_CONF_VARS MAIL; transport
.. _typo3ConfVars_mail_transport:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']
================================================

.. confval:: transport

   :type: text
   :Default: 'sendmail'

   smtp
      Sends messages over the (standardized) Simple Message Transfer Protocol.
      It can deal with encryption and authentication. Most flexible option,
      requires a mail server and configurations in transport_smtp_* settings
      below. Works the same on Windows, Unix and MacOS.

   sendmail
      Sends messages by communicating with a locally installed MTA -
      such as sendmail. See setting transport_sendmail_command bellow.

   dsn
      Sends messages with the Symfony Mailer. Configure
      :ref:`[MAIL][dsn]<typo3ConfVars_mail_dsn>` setting below.

   mbox
      This doesnt send any mail out, but instead will write every outgoing mail
      to a file adhering to the RFC 4155 mbox format, which is a simple text
      file where the mails are concatenated. Useful for debugging the mail
      sending process and on development machines which cannot send mails to the
      outside. Configure the file to write to in the transport_mbox_file
      setting below

   *classname*
      Custom class which implements Swift_Transport. The constructor
      receives all settings from the MAIL section to make it possible to
      add custom settings.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_server
.. _typo3ConfVars_mail_transport_smtp_server:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server']
============================================================

.. confval:: transport_smtp_server

   :type: text
   :Default: 'localhost:25'

   *only with transport=smtp* serverport of mailserver to connect to. port
   defaults to "25".

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_encrypt
.. _typo3ConfVars_mail_transport_smtp_encrypt:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt']
=============================================================

.. confval:: transport_smtp_encrypt

   :type: bool
   :Default: false

   *only with transport=smtp* Connects to the server using SSL/TLS
   (disables STARTTLS which is used by default if supported by the server).
   Must not be enabled when connecting to port 587, as servers will use
   STARTTLS (inner encryption) via SMTP instead of SMTPS. It will automatically
   be enabled if port is 465.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_username
.. _typo3ConfVars_mail_transport_smtp_username:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username']
==============================================================

.. confval:: transport_smtp_username

   :type: text
   :Default: ''

   *only with transport=smtp* If your SMTP server requires authentication,
   enter your username here.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_password
.. _typo3ConfVars_mail_transport_smtp_password:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password']
==============================================================

.. confval:: transport_smtp_password

   :type: password
   :Default: ''

   *only with transport=smtp* If your SMTP server requires authentication,
   enter your password here.

.. index::
   TYPO3_CONF_VARS MAIL; transport_sendmail_command
.. _typo3ConfVars_mail_transport_sendmail_command:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command']
=================================================================

.. confval:: transport_sendmail_command

   :type: text
   :Default: ''

   *only with transport=sendmail* The command to call to send a mail locally.

.. index::
   TYPO3_CONF_VARS MAIL; transport_mbox_file
.. _typo3ConfVars_mail_transport_mbox_file:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file']
==========================================================

.. confval:: transport_mbox_file

   :type: text
   :Default: ''

   *only with transport=mbox* The file where to write the mails into.
   This file will be conforming the mbox format described in RFC 4155. It is
   a simple text file with a concatenation of all mails. Path must be absolute.

.. index::
   TYPO3_CONF_VARS MAIL; transport_spool_type
.. _typo3ConfVars_mail_transport_spool_type:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_type']
===========================================================

.. confval:: transport_spool_type

   :type: text
   :Default: ''

   file
      Messages get stored to the file system till they get sent through
      the command swiftmailerspoolsend.
   memory
      Messages get send at the end of the running process.
   *classname*
      Custom class which implements the Swift_Spool interface.

.. index::
   TYPO3_CONF_VARS MAIL; transport_spool_filepath
.. _typo3ConfVars_mail_transport_spool_filepath:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_filepath']
===============================================================

.. confval:: transport_spool_filepath

   :type: text
   :Default: ''

   *only with transport_spool_type=file* Path where messages get temporarily
   stored. Ensure that this is stored outside of your webroot.

.. index::
   TYPO3_CONF_VARS MAIL; dsn
.. _typo3ConfVars_mail_dsn:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['dsn']
==========================================

.. confval:: dsn

   :type: text
   :Default: ''

   *only with transport=dsn* The DSN configuration of the Symfony mailer
   (eg. smtp//userpass@smtp.example.com25). For 3rd party transports you
   have to add additional dependencies. See
   `Symfony mailer <https//symfony.com/doc/current/mailer.html>`__ for more
   details.

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailFromAddress
.. _typo3ConfVars_mail_defaultMailFromAddress:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress']
=============================================================

.. confval:: defaultMailFromAddress

   :type: text
   :Default: ''

   This default email address is used when no other "from" address is
   set for a TYPO3-generated email. You can specify an email address only
   (eg. :php:`'info@example.org)'`.

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailFromName
.. _typo3ConfVars_mail_defaultMailFromName:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName']
==========================================================

.. confval:: defaultMailFromName

   :type: text
   :Default: ''

   This default name is used when no other "from" name is set for a
   TYPO3-generated email.

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailReplyToAddress
.. _typo3ConfVars_mail_defaultMailReplyToAddress:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailReplyToAddress']
================================================================

.. confval:: defaultMailReplyToAddress

   :type: text
   :Default: ''

   This default email address is used when no other "reply-to" address is set
   for a TYPO3-generated email. You can specify an email address only
   (eg. :php:`'info@example.org'`).

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailReplyToName
.. _typo3ConfVars_mail_defaultMailReplyToName:

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailReplyToName']
=============================================================

.. confval:: defaultMailReplyToName

   :type: text
   :Default: ''

   This default name is used when no other "reply-to" name is set for a
   TYPO3-generated email.
