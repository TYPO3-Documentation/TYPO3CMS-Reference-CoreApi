.. include:: ../../Includes.txt


.. _mail:

========
Mail API
========

.. versionadded:: 10.2

   Symfony mailer and mime support was added with this change:
   :doc:`t3core:Changelog/10.0/Feature-88643-NewMailAPIBasedOnSymfonymailerAndSymfonymime`

.. versionadded:: 10.3

   TYPO3 now supports sending template-based emails for multi-part and HTML-based
   emails out-of-the-box. The email contents are built with Fluid Templating Engine.
   :doc:`t3core:Changelog/master/Feature-90266-Fluid-basedTemplatedEmails`

TYPO3 CMS provides a RFC-compliant mailing solution based on
`symfony/mailer <https://symfony.com/doc/current/components/mailer.html>`__
for sending emails and
`symfony/mime <https://symfony.com/doc/current/components/mime.html>`__
for creating email messages.

TYPO3’s backend functionality already ships with a default layout for templated emails,
which can be tested out in TYPO3’s install tool test email functionality.

.. contents:: Table of Contents
   :depth: 1
   :local:


.. _mail-configuration:

Configuration
=============

Several settings are available in the "Configure Installation-Wide Options"
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']`.


.. _mail-configuration-format:

format
------

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['format']` can be `both`,
`plain` or `html`. This option can be overridden by Extension authors
in their use cases.

.. _mail-configuration-fluid:

Fluid paths
-----------

All Fluid-based template paths can be configured via

* :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths']`
* :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths']`
* :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']`

where TYPO3 reserves all array keys below 100 for internal purposes.

If you want to provide custom templates or layouts, set this in your LocalConfiguration.php / AdditionalConfiguration.php file::

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][700] = 'EXT:my_site_extension/Resources/Private/Templates/Email';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths'][700] = 'EXT:my_site_extension/Resources/Private/Layouts';

.. _mail-configuration-transport:

transport
---------

The most important configuration option for sending emails is
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']`, which can take the
following values:

.. _mail-configuration-smtp:

smtp
~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';`
   Sends messages over SMTP. It can deal with encryption and authentication.
   Works exactly the same on Windows, Unix and MacOS. Requires a mail server
   and the following additional settings:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = '<server:port>';`
   Mail server name and port to connect to. Port defaults to "25".

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = '<transport protocol>';`
   Connect to the server using the specified transport protocol. Requires openssl library.
   Usually available: ssl, sslv2, sslv3, tls. Check :php:`stream_get_transports()`.

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username] = '<username>';`
   If your SMTP server requires authentication, the username.

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password] = '<password>';`
   If your SMTP server requires authentication, the password.

Example::

  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = 'localhost';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = 'tls'; // ssl, sslv3, tls
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = 'johndoe';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = 'cooLSecret';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'bounces@example.org';  // fetches all 'returning' emails



.. _mail-configuration-sendmail:

sendmail
~~~~~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'sendmail';`
   Sends messages by communicating with a locally installed MTA - such as sendmail.
   This may require setting the additional option:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command'] = '<command>';`
   The command to call to send a mail locally. The default works on most modern
   UNIX based mail servers (sendmail, postfix, exim).

   Example::

      $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'sendmail';
      $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command'] = '/usr/sbin/sendmail -bs';


.. _mail-configuration-mbox:

mbox
~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mbox';`
   This doesn't send any mail out, but instead will write every outgoing mail to a file
   adhering to the RFC 4155 mbox format, which is a simple text file where the mails are
   concatenated. Useful for debugging the mail sending process and on development machines
   which cannot send mails to the outside. The file to write to is defined by:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file'] = '</abs/path/to/mbox/file>';`
   The file where to write the mails into. Path must be absolute.

.. _mail-configuration-classname:

<classname>
~~~~~~~~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = '<classname>';`
   Custom class which implements
   :php:`\Symfony\Component\Mailer\Transport\TransportInterface`.
   The constructor receives all settings from the ``MAIL`` section to make it
   possible to add custom settings.



.. _mail-create:

How to Create and Send Mails
============================

Both :php:`\TYPO3\CMS\Core\Mail\MailMessage` and :php:`\TYPO3\CMS\Core\Mail\FluidEmail` inherit
from :php:`Symfony\Component\Mime\Email` and have a similar API. **FluidEmail** is specific
for sending emails based on Fluid.

.. _mail-fluid-email:

Send email with `FluidEmail`
----------------------------

This sends an email using an existing Fluid template :file:`TipsAndTricks.html`.
Make sure the paths are setup as described in :ref:`mail-configuration-fluid`.

.. code-block:: php

   $email = GeneralUtility::makeInstance(FluidEmail::class);
   $email
       ->to('contact@acme.com')
       ->from(new Address('jeremy@acme.com', 'Jeremy'))
       ->subject('TYPO3 loves you - here is why')
       ->setFormat('html') // only HTML mail
       ->setTemplate('TipsAndTricks')
       ->assign('mySecretIngredient', 'Tomato and TypoScript');
   GeneralUtility::makeInstance(Mailer::class)->send($email);

Defining a custom email subject in a custom Fluid template:

.. code-block:: html

   <f:section name="Subject">New Login at "{typo3.sitename}"</f:section>

Building templated emails with Fluid also allows to define the language key,
and use this within the Fluid template:

.. code-block:: php

   $email = GeneralUtility::makeInstance(FluidEmail::class);
   $email
       ->to('contact@acme.com')
       ->assign('language', 'de');

In Fluid, you can now use the defined language key ("language"):

.. code-block:: html

   <f:translate languageKey="{language}" id="LLL:my_ext/Resources/Private/Language/emails.xml:subject" />

Send email with `MailMessage`
-----------------------------

This shows how to generate and send a mail in TYPO3::

   // Create the message
   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);

   // Prepare and send the message
   $mail

      // Defining the "From" email address and name as an object
      // (email clients will display the name)
      ->from(new \Symfony\Component\Mime\Address('john@doe.com', 'John Doe'))

      // Set the "To" addresses
      ->to(
         new \Symfony\Component\Mime\Address('receiver@example.org', 'Max Mustermann'),
         new \Symfony\Component\Mime\Address('other@domain.org')
      )

      // Give the message a subject
      ->subject('Your subject')

      // Give it the text message
      ->text('Here is the message itself')

      // And optionally a HTML message
      ->html('<q>Here is the message itself</q>')

      // Optionally add any attachments
      ->attachFromPath('/path/to/my-document.pdf')

      // And finally send it
      ->send()
    ;



Or if you prefer, don't concatenate the calls::

   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
   $mail->from(new \Symfony\Component\Mime\Address('john@doe.com', 'John Doe'));
   $mail->to(
      new \Symfony\Component\Mime\Address('receiver@example.org', 'Max Mustermann'),
      new \Symfony\Component\Mime\Address('other@domain.org')
   );
   $mail->subject('Your subject');
   $mail->text('Here is the message itself');
   $mail->html('<q>Here is the message itself</q>');
   $mail->attachFromPath('/path/to/my-document.pdf');
   $mail->send();


.. note::

   Before TYPO3 v10 the :php:`MailMessage` class only had methods like
   :php:`->setTo()`, :php:`setFrom()`, :php:`->setSubject()` etc.
   Now the class inherits from :php:`\Symfony\Component\Mime\Email` which
   provides the methods from the example. To make migration from older TYPO3
   versions easier the previous methods still exist. The use of
   :php:`MailMessage` in own extensions is recommended.


.. _mail-attachments:

How to Add Attachments
======================

Attach files that exist in your file system::

   // Attach file to message
   $mail->attachFromPath('/path/to/documents/privacy.pdf');

   // Optionally you can tell email clients to display a custom name for the file
   $mail->attachFromPath('/path/to/documents/privacy.pdf', 'Privacy Policy');

   // Alternatively attach contents from a stream
   $mail->attach(fopen('/path/to/documents/contract.doc', 'r'));



.. _mail-inline:

How to Add Inline Media
=======================

Add some inline media like images in a mail::

   // Get the image contents from a PHP resource
   $mail->embed(fopen('/path/to/images/logo.png', 'r'), 'logo');

   // Get the image contents from an existing file
   $mail->embedFromPath('/path/to/images/signature.png', 'footer-signature');

   // reference images using the syntax 'cid:' + "image embed name"
   $mail->html('<img src="cid:logo"> ... <img src="cid:footer-signature"> ...');



.. _mail-sender:

How to Set and Use a Default Sender
===================================

It is possible to define a default email sender ("From:") in the *Install
Tool*::

   $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'john@doe.com';
   $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'] = 'John Doe';

This is how you can use these defaults::

   $from = \TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom();

   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);

   // As getSystemFrom() returns an array we need to use the setFrom method
   $mail->setFrom($from);
   // ...
   $mail->send();

In case of the problem "Mails are not sent" in your extension, try to set a
``ReturnPath:``. Start as before but add::

   // you will get a valid Email Adress from  'defaultMailFromAddress' or if not set from PHP settings or from system.
   // if result is not a valid email, the final result will be no-reply@example.com..
   $returnPath = \TYPO3\CMS\Core\Utility\MailUtility::getSystemFromAddress();
   if ($returnPath != "no-reply@example.com") {
       $mail->setReturnPath($returnPath);
   }
   $mail->send();

.. _mail-symfony-mime:

Symfony Documentation
=====================

Please refer to the Symfony documentation for more information about
available methods.

.. seealso::

   - `The Mime Component <https://symfony.com/doc/current/components/mime.html>`__

   - `Sending Emails with Mailer <https://symfony.com/doc/current/mailer.html>`__
