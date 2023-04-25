.. include:: /Includes.rst.txt

.. index::
   TYPO3_CONF_VARS; MAIL
   TYPO3_CONF_VARS MAIL
.. _typo3ConfVars_mail:

=============
MAIL settings
=============

The following configuration variables can be used to configure settings for
the sending mails by TYPO3:

..  contents::
    :local:

..  note::
    The configuration values listed here are keys in the global PHP array
    :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']`.

    This variable can be set in one of the following files:

    *   :ref:`typo3conf/LocalConfiguration.php <typo3ConfVars-localConfiguration>`
    *   :ref:`typo3conf/AdditionalConfiguration.php <typo3ConfVars-additionalConfiguration>`

.. index::
   TYPO3_CONF_VARS MAIL; format
.. _typo3ConfVars_mail_format:

format
======

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['format']

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

layoutRootPaths
===============

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths']

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

partialRootPaths
================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths']

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

templateRootPaths
=================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']

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

validators
==========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['validators']

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

transport
=========

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']

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
      Sends messages with the Symfony mailer, see
      `Symfony mailer documentation <https://symfony.com/doc/current/mailer.html>`__.
      Configure this mailer with the :ref:`[MAIL][dsn]<typo3ConfVars_mail_dsn>`
      setting.

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

transport_smtp_server
=====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server']

   :type: text
   :Default: 'localhost:25'

   *only with transport=smtp* serverport of mailserver to connect to. port
   defaults to "25".

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_domain
.. _typo3ConfVars_mail_transport_smtp_domain:

transport_smtp_domain
=====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_domain']

   :type: text
   :Default: ''

   Some smtp-relay-servers require the domain to be set from which the sender is
   sending an email. By default, the EsmtpTransport from Symfony will use the
   current domain/IP of the host or container. This will be sufficient for
   most servers, but some servers require that a valid domain is passed. If
   this isn't done, sending emails via such servers will fail.

   Setting a valid SMTP domain can be achieved by setting
   `transport_smtp_domain` in the :file:`LocalConfiguration.php`.
   This will set the given domain to the EsmtpTransport agent and send the
   correct EHLO-command to the relay-server.

   **Configuration Example for GSuite:**

   .. code-block:: php
      :caption: `typo3conf/LocalConfiguration.php`

       return [
           //....
           'MAIL' => [
               'defaultMailFromAddress' => 'webserver@example.org',
               'defaultMailFromName' => 'SYSTEMMAIL',
               'transport' => 'smtp',
               'transport_sendmail_command' => ' -t -i ',
               'transport_smtp_domain' => 'example.org',
               'transport_smtp_encrypt' => '',
               'transport_smtp_password' => '',
               'transport_smtp_server' => 'smtp-relay.gmail.com:587',
               'transport_smtp_username' => '',
           ],
           //....
       ];

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_encrypt
.. _typo3ConfVars_mail_transport_smtp_encrypt:

transport_smtp_encrypt
======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt']

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

transport_smtp_username
=======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username']

   :type: text
   :Default: ''

   *only with transport=smtp* If your SMTP server requires authentication,
   enter your username here.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_password
.. _typo3ConfVars_mail_transport_smtp_password:

transport_smtp_password
=======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password']

   :type: password
   :Default: ''

   *only with transport=smtp* If your SMTP server requires authentication,
   enter your password here.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_restart_threshold
.. _typo3ConfVars_mail_transport_smtp_restart_threshold:

transport_smtp_restart_threshold
================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_restart_threshold']

   :type: text
   :Default: ''

   *only with transport=smtp* Sets the maximum number of messages to send
   before re-starting the transport.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_restart_threshold_sleep
.. _typo3ConfVars_mail_transport_smtp_restart_threshold_sleep:

transport_smtp_restart_threshold_sleep
======================================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_restart_threshold_sleep']

   :type: text
   :Default: ''

   *only with transport=smtp* Sets the number of seconds to sleep
   between stopping and re-starting the transport.

.. index::
   TYPO3_CONF_VARS MAIL; transport_smtp_ping_threshold
.. _typo3ConfVars_mail_transport_smtp_ping_threshold:

transport_smtp_ping_threshold
=============================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_ping_threshold']

   :type: text
   :Default: ''

   *only with transport=smtp* Sets the minimum number of seconds required
   between two messages, before the server is pinged. If the transport
   wants to send a message and the time since the last message exceeds
   the specified threshold, the transport will ping the server first
   (NOOP command) to check if the connection is still alive. Otherwise the
   message will be sent without pinging the server first.

   .. note::
      Do not set the threshold too low, as the SMTP server may drop the
      connection if there are too many non-mail commands
      (like pinging the server with NOOP).

.. index::
   TYPO3_CONF_VARS MAIL; transport_sendmail_command
.. _typo3ConfVars_mail_transport_sendmail_command:

transport_sendmail_command
==========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command']

   :type: text
   :Default: ''

   *only with transport=sendmail* The command to call to send a mail locally.

.. index::
   TYPO3_CONF_VARS MAIL; transport_mbox_file
.. _typo3ConfVars_mail_transport_mbox_file:

transport_mbox_file
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file']

   :type: text
   :Default: ''

   *only with transport=mbox* The file where to write the mails into.
   This file will be conforming the mbox format described in RFC 4155. It is
   a simple text file with a concatenation of all mails. Path must be absolute.

.. index::
   TYPO3_CONF_VARS MAIL; transport_spool_type
.. _typo3ConfVars_mail_transport_spool_type:

transport_spool_type
====================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_type']

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

transport_spool_filepath
========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_filepath']

   :type: text
   :Default: ''

   *only with transport_spool_type=file* Path where messages get temporarily
   stored. Ensure that this is stored outside of your webroot.

.. index::
   TYPO3_CONF_VARS MAIL; dsn
.. _typo3ConfVars_mail_dsn:

dsn
===

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['dsn']

   :type: text
   :Default: ''

   *only with transport=dsn* The DSN configuration of the Symfony mailer
   (for example `smtp://userpass@smtp.example.org:25`). Symfony provides different
   mail transports like SMTP, sendmail or many 3rd party email providers like
   AWS SES, Gmail, MailChimp, Mailgun and more. You can find all supported
   providers in the
   `Symfony mailer documentation <https://symfony.com/doc/current/mailer.html>`__.

   Set :php:`[MAIL][dsn]` to the configuration value described in the
   Symfony mailer documentation (see above).

   Examples:

   *  :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['dsn'] = "smtp://user:pass@smtp.example.org:25"`
   *  :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['dsn'] = "sendmail://default"`

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailFromAddress
.. _typo3ConfVars_mail_defaultMailFromAddress:

defaultMailFromAddress
======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress']

   :type: text
   :Default: ''

   This default email address is used when no other "from" address is
   set for a TYPO3-generated email. You can specify an email address only
   (for example :php:`'info@example.org)'`.

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailFromName
.. _typo3ConfVars_mail_defaultMailFromName:

defaultMailFromName
===================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName']

   :type: text
   :Default: ''

   This default name is used when no other "from" name is set for a
   TYPO3-generated email.

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailReplyToAddress
.. _typo3ConfVars_mail_defaultMailReplyToAddress:

defaultMailReplyToAddress
=========================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailReplyToAddress']

   :type: text
   :Default: ''

   This default email address is used when no other "reply-to" address is set
   for a TYPO3-generated email. You can specify an email address only
   (for example :php:`'info@example.org'`).

.. index::
   TYPO3_CONF_VARS MAIL; defaultMailReplyToName
.. _typo3ConfVars_mail_defaultMailReplyToName:

defaultMailReplyToName
======================

.. confval:: $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailReplyToName']

   :type: text
   :Default: ''

   This default name is used when no other "reply-to" name is set for a
   TYPO3-generated email.
