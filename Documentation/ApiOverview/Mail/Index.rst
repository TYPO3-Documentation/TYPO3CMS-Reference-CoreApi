.. include:: ../../Includes.txt


.. _mail:

========
Mail API
========

Since version 4.5 TYPO3 CMS provides a RFC compliant mailing solution,
based on `SwiftMailer <http://swiftmailer.org/>`_.



.. _mail-configuration:

Configuration
=============

Several settings are available in the Install Tool ("All Configuration")
affecting the sending process. The most important one is
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']`, which can take the
following values:

.. _mail-configuration-mail:

mail
----

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mail';`
   Default and backwards compatible setting. This is the most unreliable option.
   If you are serious about sending mails, consider using "smtp" or "sendmail".

.. _mail-configuration-smtp:

smtp
----

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';`
   Sends messages over SMTP. It can deal with encryption and authentication.
   Works exactly the same on Windows, Unix and MacOS. Requires a mail server
   and the following additional settings:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = '<server:port>';`
   Mailserver name and port to connect to. Port defaults to "25".

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
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = 'ssl'; // ssl, sslv3, tls
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = 'johndoe';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = 'cooLSecret';


.. _mail-configuration-sendmail:

sendmail
--------

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
----

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mbox';`
   This doesn't send any mail out, but instead will write every outgoing mail to a file
   adhering to the RFC 4155 mbox format, which is a simple text file where the mails are
   concatenated. Useful for debugging the mail sending process and on development machines
   which cannot send mails to the outside. The file to write to is defined by:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file'] = '<abs/path/to/mbox/file>';`
   The file where to write the mails into. Path must be absolute.

.. _mail-configuration-classname:

<classname>
-----------

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = '<classname>';`
   Custom class which implements :php:`\Swift_Transport`. The constructor receives all settings from
   the MAIL section to make it possible to add custom settings.



.. _mail-create:

How to create and send mails
============================

This shows how to generate and send a mail in TYPO3::

   // Create the message
   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);

   // Prepare and send the message
   $mail

      // Give the message a subject
      ->setSubject('Your subject')

      // Set the From address with an associative array
      ->setFrom(array('john@doe.com' => 'John Doe'))

      // Set the To addresses with an associative array
      ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))

      // Give it a body
      ->setBody('Here is the message itself')

      // And optionally an alternative body
      ->addPart('<q>Here is the message itself</q>', 'text/html')

      // Optionally add any attachments
      ->attach(\Swift_Attachment::fromPath('my-document.pdf'))

      // And finally do send it
      ->send()
    ;


Or if you prefer, don't concatenate the calls::

   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
   $mail->setSubject('Your subject');
   $mail->setFrom(array('john@doe.com' => 'John Doe'));
   $mail->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'));
   $mail->setBody('Here is the message itself');
   $mail->addPart('<q>Here is the message itself</q>', 'text/html');
   $mail->attach(\Swift_Attachment::fromPath('my-document.pdf'));
   $mail->send();



.. _mail-attachments:

How to add attachments
======================

Here is a code sample for attaching a file to mail::

   // Create the attachment, the content-type parameter is optional
   $attachment = \Swift_Attachment::fromPath('</path/to/image.jpg>', 'image/jpeg');

   // Set the filename (optional)
   $attachment->setFilename('<cool.jpg>');

   // Attach attachment to message
   $mail->attach($attachment);



.. _mail-inline:

How to add inline media
=======================

Here is how to add some inline media like images in a mail::

   // Attach the message with a "cid"
   $cid = $mail->embed(\Swift_Image::fromPath('<path/to/image.png>'));

   // Create HTML body refering to it
   $mail->setBody(
      '<html><head></head><body>' .
      '  Here is an image <img src="' . $cid . '" alt="Image" />' .
      '  Rest of message' .
      ' </body></html>',
      'text/html' //Mark the content-type as HTML
   );



.. _mail-sender:

How to set and use a default sender
===================================

It is possible to define a default email sender ("From:") in the *Install
Tool*::

   $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'john@doe.com';
   $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'] = 'John Doe';

This is how you can use these defaults::

   $from = \TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom();
   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
   $mail->setFrom($from);
   // ...
   $mail->send();



.. _mail-swift:

SwiftMailer documentation
=========================

Please refer to the SwiftMailer documentation for more information about
available methods,

.. seealso::

   - `Swiftmailer: General <http://swiftmailer.org/docs/index.html>`__

   - `Swiftmailer: Content, attachments, basic headers
     <http://swiftmailer.org/docs/messages>`__

   - `Adding and manipulating complex or custom headers
     <http://swiftmailer.org/docs/headers>`__
