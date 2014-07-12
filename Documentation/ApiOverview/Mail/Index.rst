.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt






.. _mail:

Mail API
--------

Since version 4.5 TYPO3 CMS provides a RFC compliant mailing solution,
based on `SwiftMailer <http://swiftmailer.org/>`_.


.. _mail-configuration:

Configuration
^^^^^^^^^^^^^

Several settings are available in the Install Tool ("All Configuration")
affecting the sending process. The most important one is
**$TYPO3_CONF_VARS['MAIL']['transport']**, which can take the following values:

.. t3-field-list-table::
 :header-rows: 1

 - :Value,20: Value
   :Description,80: Description

 - :Value: mail
   :Description:
         Default and backwards compatible setting. This is the most unreliable option.
         If you are serious about sending mails, consider using "smtp" or "sendmail".

 - :Value: smtp
   :Description:
         Sends messages over SMTP. It can deal with encryption and authentication.
         Works exactly the same on Windows, Unix and MacOS.
         Requires a mail server and the following additional settings:

         - *$TYPO3_CONF_VARS['MAIL']['transport_smtp_server']*: `server:port` of mailserver
           to connect to. Port defaults to "25".

         - *$TYPO3_CONF_VARS['MAIL']['transport_smtp_encrypt']*: Connect to the server using
           encryption and TLS. Requires openssl library.

         - *$TYPO3_CONF_VARS['MAIL']['transport_smtp_username]*: If your SMTP server
           requires authentication, the username.

         - *$TYPO3_CONF_VARS['MAIL']['transport_smtp_password]*: If your SMTP server
           requires authentication, the password.

 - :Value: sendmail
   :Description:
         Sends messages by communicating with a locally installed MTA - such as sendmail.
         This may require setting the additional option:

         - *$TYPO3_CONF_VARS['MAIL']['transport_sendmail_command']*: The command to call
           to send a mail locally. The default works on most modern UNIX based mail server
           (sendmail, postfix, exim).

 - :Value: mbox
   :Description:
         This doesn't send any mail out, but instead will write every outgoing mail to a file
         adhering to the RFC 4155 mbox format, which is a simple text file where the mails are concatenated.
         Useful for debugging the mail sending process and on development machines
         which cannot send mails to the outside. The file to write to is defined by:

         - *$TYPO3_CONF_VARS['MAIL']['transport_mbox_file']*: The file where to write the mails into.
           Path must be absolute.


.. _mail-create:

Creating mails
^^^^^^^^^^^^^^

This is how to generate and send a mail in TYPO3 (starting with 4.5):

.. code-block:: php

   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
   $mail->setFrom(array($email => $name))
        ->setTo(array($email => $name))
        ->setSubject($subject)
        ->setBody($body)
        ->send();

Or if you prefer, don't concatenate the calls:

.. code-block:: php

   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
   $mail->setFrom(array($email => $name));
   $mail->setTo(array($email => $name));
   $mail->setSubject($subject);
   $mail->setBody($body);
   $mail->send();


.. _mail-attachments:

Adding Attachments
^^^^^^^^^^^^^^^^^^

Here a code sample for attaching a file to mail:

.. code-block:: php

   	// Create the attachment
   	// * Note that you can technically leave the content-type parameter out
   $attachment = \Swift_Attachment::fromPath('/path/to/image.jpg', 'image/jpeg');

   	// (optional) setting the filename
   $attachment->setFilename('cool.jpg');

   	// Attach it to the message
   $mail->attach($attachment);


.. _mail-inline:

Adding inline media
^^^^^^^^^^^^^^^^^^^

Here is how to add some inline media (e.g. images) in a mail:

.. code-block:: php

   	// Attach the message with a "cid"
   $cid = $mail->embed(Swift_Image::fromPath('image.png'));

   	// Create a HTML body refering to it
   $mail->setBody(
   	'<html><head></head><body>' .
   		'  Here is an image <img src="' . $cid . '" alt="Image" />' .
   		'  Rest of message' .
   		' </body></html>',
   	'text/html' //Mark the content-type as HTML
   );


.. _mail-sender:

Default sender
^^^^^^^^^^^^^^

It is possible to define a default email sender ("From:") in the Install Tool,
with the following settings:

- :code:`$TYPO3_CONF_VARS['MAIL']['defaultMailFromAddress']`
- :code:`$TYPO3_CONF_VARS['MAIL']['defaultMailFromName']`

To make use of these settings in your extension, use the following code:

.. code-block:: php

   $from = \TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom();
   $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
   $mail->setFrom($from);
   ...


.. _mail-swift:

SwiftMailer documentation
^^^^^^^^^^^^^^^^^^^^^^^^^

For more information about available methods,
please refer to SwiftMailer documentation, in particular:

- http://swiftmailer.org/docs/messages: Content, attachments, basic headers
- http://swiftmailer.org/docs/headers: Adding and manipulating complex or custom headers
