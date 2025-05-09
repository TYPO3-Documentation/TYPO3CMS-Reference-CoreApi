..  include:: /Includes.rst.txt
..  index:: Mail
..  _mail:

========
Mail API
========

TYPO3 provides a RFC-compliant mailing solution based on
`symfony/mailer <https://symfony.com/doc/current/components/mailer.html>`__
for sending emails and
`symfony/mime <https://symfony.com/doc/current/components/mime.html>`__
for creating email messages.

TYPO3’s backend functionality already ships with a default layout for templated emails,
which can be tested out in TYPO3’s install tool test email functionality.

..  contents:: Table of Contents
    :depth: 1
    :local:


..  index::
    pair: Mail; Configuration
    TYPO3_CONF_VARS; MAIL
..  _mail-configuration:

Configuration
=============

Several settings are available via :guilabel:`Admin Tools > Settings > Configure
Installation-Wide Options > Mail` which are stored into
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']`. See :ref:`typo3ConfVars_mail` for
an overview of all settings.

..  note::
    If you want to send emails using Microsoft 365 or Office 365, you have to
    configure a connector first, as described in the article
    `Configure a connector to send mail using Microsoft 365 or Office 365 SMTP relay`_.

..  _Configure a connector to send mail using Microsoft 365 or Office 365 SMTP relay: https://learn.microsoft.com/en-us/exchange/mail-flow-best-practices/how-to-set-up-a-multifunction-device-or-application-to-send-email-using-microsoft-365-or-office-365#option-3-configure-a-connector-to-send-mail-using-microsoft-365-or-office-365-smtp-relay


..  _mail-configuration-format:

Format
------

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['format']` can be `both`, `plain` or
`html`. This option can be overridden in the project's
:file:`config/system/settings.php` or :file:`config/system/additional.php` files.

..  _mail-configuration-fluid:

Fluid paths
-----------

All Fluid-based template paths can be configured via

*   :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths']`
*   :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths']`
*   :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']`

where TYPO3 reserves all array keys below `100` for internal purposes.

If you want to provide custom templates or layouts, set this in your
:file:`config/system/settings.php` / :file:`config/system/additional.php` file:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][700]
        = 'EXT:my_site_package/Resources/Private/Templates/Email';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths'][700]
        = 'EXT:my_site_extension/Resources/Private/Layouts';

..  _mail-configuration-fluid-example:

Minimal example for a Fluid-based email template
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

**Directory Structure:**

..  directory-tree::
    :show-file-icons: true

    *  EXT:my_site_package/

        *   Resources

            *   Private

                *   Templates

                    *   Email

                        *   MyCustomEmail.html

**`MyCustomEmail.html`:**

..  code-block:: html
    :caption: EXT:my_site_package/Resources/Private/Templates/Email/MyCustomEmail.html

    <f:layout name="SystemEmail" />

    <f:section name="Subject">
        My Custom Subject
    </f:section>

    <f:section name="Main">
        Hello, this is a custom email template!
    </f:section>

..  _mail-configuration-transport:

transport
---------

The most important configuration option for sending emails is
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']`, which can take the
following values:

..  _mail-configuration-smtp:

smtp
~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';`
    Sends messages over SMTP. It can deal with encryption and authentication.
    Works exactly the same on Windows, Unix and MacOS. Requires a mail server
    and the following additional settings:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = '<server:port>';`
    Mail server name and port to connect to. Port defaults to `25`.

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = <bool>;`
    Determines whether the transport protocol should be encrypted. Requires
    OpenSSL library. Defaults to :php:`false`.
    If :php:`false`, symfony/mailer will use STARTTLS.

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username] = '<username>';`
    The username, if your SMTP server requires authentication.

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password] = '<password>';`
    The password, if your SMTP server requires authentication.

Example:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = 'localhost';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = 'johndoe';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = 'cooLSecret';
    // Fetches all 'returning' emails:
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'bounces@example.org';



..  _mail-configuration-sendmail:

sendmail
~~~~~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'sendmail';`
    Sends messages by communicating with a locally installed MTA - such as sendmail.
    This may require setting the additional option:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command'] = '<command>';`
    The command to call to send an email locally. The default works on most
    modern Unix-based mail servers (sendmail, postfix, exim).

    Example:

    ..  code-block:: php
        :caption: config/system/additional.php | typo3conf/system/additional.php

        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'sendmail';
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command'] = '/usr/sbin/sendmail -bs';


    ..  attention::

        Depending on the configuration of the server and the TYPO3 instance, it
        may not be possible to send emails to BCC recipients. The configuration
        of the :php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command']`
        value is crucial.

        TYPO3 recommends the parameter :php:`-bs` (instead of :php:`-t -i`). The
        parameter :php:`-bs` tells TYPO3 to use the SMTP standard and that way
        the BCC recipients are properly set.
        `Symfony <https://symfony.com/doc/current/mailer.html#using-built-in-transports>`__
        refers to the problem of using the :php:`-t` parameter as well. Since
        :issue:`65791` the :php:`transport_sendmail_command` is automatically
        set from the PHP runtime configuration and saved. Thus, if you have
        problems with sending emails to BCC recipients, check the above
        mentioned configuration.


..  _mail-configuration-mbox:

mbox
~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mbox';`
    This doesn't send any email out, but instead will write every outgoing email
    to a file adhering to the `RFC 4155 mbox format
    <https://www.rfc-editor.org/rfc/rfc4155.html>`__, which is a simple text
    file where the emails are concatenated. Useful for debugging the email
    sending process and on development machines which cannot send emails to the
    outside. The file to write to is defined by:

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file'] = '</abs/path/to/mbox/file>';`
    The file where to write the emails into. The path must be absolute.

..  _mail-configuration-classname:

<classname>
~~~~~~~~~~~

:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = '<classname>';`
    Custom class which implements
    :php:`\Symfony\Component\Mailer\Transport\TransportInterface`.
    The constructor receives all settings from the ``MAIL`` section to make it
    possible to add custom settings.


..  _mail-validators:

Validators
----------

..  versionadded:: 11.0

Using additional validators can help to identify if a provided email address
is valid or not. By default, the validator
:php:`\Egulias\EmailValidator\Validation\RFCValidation` is used. The following
validators are available:

- :php:`\Egulias\EmailValidator\Validation\DNSCheckValidation`
- :php:`\Egulias\EmailValidator\Validation\SpoofCheckValidation`
- :php:`\Egulias\EmailValidator\Validation\NoRFCWarningsValidation`

Additionally, it is possible to provide an own implementation by implementing
the interface :php:`\Egulias\EmailValidator\Validation\EmailValidation`.

If multiple validators are provided, each validator must return :php:`true`.

Example:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['validators'] = [
        \Egulias\EmailValidator\Validation\RFCValidation::class,
        \Egulias\EmailValidator\Validation\DNSCheckValidation::class
    ];


..  index::
    Mail; Spooling
    Mail; transport_spool_type
..  _mail-spooling:

Spooling
========

The default behavior of the TYPO3 mailer is to send the email messages
immediately. However, you may want to avoid the performance hit of the
communication to the email server, which could cause the user to wait for the
next page to load while the email is being sent. This can be avoided by choosing
to "spool" the emails instead of sending them directly.


Spooling in memory
------------------

..  code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_type'] = 'memory';

When you use spooling to store the emails to memory, they will get sent right
before the kernel terminates. This means the email only gets sent if the whole
request got executed without any unhandled exception or any errors.


Spooling using files
--------------------

..  code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_type'] = 'file';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_spool_filepath'] = '/folder/of/choice';

When using the filesystem for spooling, you need to define in which folder TYPO3
stores the spooled files. This folder will contain files for each email in the
spool. So make sure this directory is writable by TYPO3 and not accessible to
the world (outside of the webroot).

Additional notes about the mail spool path:

*   If the path is absolute, the path must either start with the root path of
    the TYPO3 project or the public web folder path
*   If the path is relative, the public web path is prepended to the path
*   The path must not contain symlinks (important for environments with auto
    deployment)
*   The path must not contain ``//``, ``..`` or ``\``

Sending spooled mails
---------------------

To send the spooled emails you need to run the following CLI command:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 mailer:spool:send

    ..  group-tab:: Classic mode installation (no Composer)

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 mailer:spool:send

This command can be set up to be run periodically using the
:doc:`TYPO3 Scheduler <ext_scheduler:Index>`.

..  index::
    Mail; How to create mails
    Mails; How to send mails
..  _mail-create:

How to create and send emails
=============================

There are two ways to send emails in TYPO3 based on the Symfony API:

1. With :ref:`Fluid <mail-fluid-email>`, using :php:`\TYPO3\CMS\Core\Mail\FluidEmail`
2. :ref:`Without Fluid <mail-mail-message>`, using :php:`\TYPO3\CMS\Core\Mail\MailMessage`

:php:`\TYPO3\CMS\Core\Mail\MailMessage` and :php:`\TYPO3\CMS\Core\Mail\FluidEmail`
inherit from :php:`Symfony\Component\Mime\Email` and have a similar API.
**FluidEmail** is specific for sending emails based on Fluid.

Either method can be used to send emails with HTML content, text content or both
(HTML and text).


..  index:: Mail; FluidEmail
..  _mail-fluid-email:

Send email with `FluidEmail`
----------------------------

This sends an email using a Fluid template :file:`TipsAndTricks.html`, make
sure the paths are setup as described in :ref:`mail-configuration-fluid`:

..  code-block:: php

    use Symfony\Component\Mime\Address;
    use TYPO3\CMS\Core\Mail\FluidEmail;
    use TYPO3\CMS\Core\Mail\MailerInterface;

    $email = new FluidEmail();
    $email
        ->to('contact@example.org')
        ->from(new Address('jeremy@example.org', 'Jeremy'))
        ->subject('TYPO3 loves you - here is why')
        ->format(FluidEmail::FORMAT_BOTH) // send HTML and plaintext mail
        ->setTemplate('TipsAndTricks')
        ->assign('mySecretIngredient', 'Tomato and TypoScript');
    GeneralUtility::makeInstance(MailerInterface::class)->send($email);


..  versionchanged:: 12.1
    Until TYPO3 v12.0 the :php:`\TYPO3\CMS\Core\Mail\Mailer` class
    implementation has to be retrieved/injected to send an email. Since TYPO3
    v12.1 it is recommended to use :php:`\TYPO3\CMS\Core\Mail\MailerInterface`
    instead to be able to use :ref:`custom mailer implementations
    <register-custom-mailer>`.

A file :file:`TipsAndTricks.html` must exist in one of the paths defined in
:php:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']` for sending the
HTML content. For sending plaintext content, a file :file:`TipsAndTricks.txt`
should exist.

Defining a custom email subject in a custom Fluid template:

..  code-block:: html

    <f:section name="Subject">New Login at "{typo3.sitename}"</f:section>

Building templated emails with Fluid also allows to define the language key,
and use this within the Fluid template:

..  code-block:: php

    $email = new FluidEmail();
    $email
        ->to('contact@example.org')
        ->assign('language', 'de');

In Fluid, you can now use the defined language key ("language"):

..  code-block:: html

    <f:translate languageKey="{language}" id="LLL:EXT:my_ext/Resources/Private/Language/emails.xml:subject" />

..  _mail-fluid-email-set-request:

Set the current request object for `FluidEmail`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In order to use ViewHelpers that need a valid current request, such as :ref:`t3viewhelper:typo3-fluid-uri-page`,
pass the current request to the FluidEmail instance:


..  code-block:: php

    use TYPO3\CMS\Core\Mail\FluidEmail;

    $email = new FluidEmail();
    $email->setRequest($this->request);

Read more aboout :ref:`Getting the PSR-7 request object <getting-typo3-request-object>` in different
contexts. In a context where no valid request object can be retrieved, such as in a
:ref:`Console command <t3coreapi:symfony-console-commands>` the affected ViewHelpers cannot be used.

Trying to use these ViewHelpers without a valid request throws an :doc:`error <t3exceptions:Exceptions/1639819269>`
like the following:

..  code-block:: text
    :caption: Example error output

    [ERROR] The rendering context of ViewHelper f:link.page is missing a valid request object.

..  index:: Mail; MailMessage
..  _mail-mail-message:

Send email with `MailMessage`
-----------------------------

:php:`MailMessage` can be used to generate and send an email without using
Fluid:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    use Symfony\Component\Mime\Address;
    use TYPO3\CMS\Core\Mail\MailMessage;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    // Create the message
    $mail = GeneralUtility::makeInstance(MailMessage::class);
    $email = new MailMessage();

    // Prepare and send the message
    $mail
        // Defining the "From" email address and name as an object
        // (email clients will display the name)
        ->from(new Address('john.doe@example.org', 'John Doe'))

        // Set the "To" addresses
        ->to(
            new Address('receiver@example.org', 'Max Mustermann'),
            new Address('other@example.org')
        )

        // Give the message a subject
        ->subject('Your subject')

        // Give it the text message
        ->text('Here is the message itself')

        // And optionally an HTML message
        ->html('<p>Here is the message itself</p>')

        // Optionally add any attachments
        ->attachFromPath('/path/to/my-document.pdf')

        // And finally send it
        ->send()
    ;



Or, if you prefer, do not concatenate the calls:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    use Symfony\Component\Mime\Address;
    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Mail\MailMessage;

    $email = new MailMessage();
    $mail->from(new Address('john.doe@example.org', 'John Doe'));
    $mail->to(
        new Address('receiver@example.org', 'Max Mustermann'),
        new Address('other@example.org')
    );
    $mail->subject('Your subject');
    $mail->text('Here is the message itself');
    $mail->html('<p>Here is the message itself</p>');
    $mail->attachFromPath('/path/to/my-document.pdf');
    $mail->send();


..  note::
    Before TYPO3 v10 the :php:`MailMessage` class only had methods like
    :php:`->setTo()`, :php:`setFrom()`, :php:`->setSubject()` etc.
    Now the class inherits from :php:`\Symfony\Component\Mime\Email` which
    provides the methods from the example. To make migration from older TYPO3
    versions easier the previous methods still exist. The use of
    :php:`MailMessage` in own extensions is recommended.


..  index:: Mail; Attachments
..  _mail-attachments:

How to add attachments
======================

Attach files that exist in your file system:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    // Attach file to message
    $mail->attachFromPath('/path/to/documents/privacy.pdf');

    // Optionally you can tell email clients to display a custom name for the file
    $mail->attachFromPath('/path/to/documents/privacy.pdf', 'Privacy Policy');

    // Alternatively attach contents from a stream
    $mail->attach(fopen('/path/to/documents/contract.doc', 'r'));



..  index:: Mail; Inline media
..  _mail-inline:

How to add inline media
=======================

Add some inline media like images in an email:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    // Get the image contents from a PHP resource
    $mail->embed(fopen('/path/to/images/logo.png', 'r'), 'logo');

    // Get the image contents from an existing file
    $mail->embedFromPath('/path/to/images/signature.png', 'footer-signature');

    // reference images using the syntax 'cid:' + "image embed name"
    $mail->html('<img src="cid:logo"> ... <img src="cid:footer-signature"> ...');


..  index::
    Mail; Default sender
    TYPO3_CONF_VARS; MAIL defaultMailFromAddress
..  _mail-sender:

How to set and use a default sender
===================================

It is possible to define a default email sender ("From:") in
:guilabel:`Admin Tools > Settings > Configure Installation-Wide Options`:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'john.doe@example.org';
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'] = 'John Doe';

This is how you can use these defaults:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    use TYPO3\CMS\Core\Mail\MailMessage;
    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Utility\MailUtility;

    $from = MailUtility::getSystemFrom();
    $email = new MailMessage();

    // As getSystemFrom() returns an array we need to use the setFrom method
    $email->setFrom($from);
    // ...
    $email->send();

In case of the problem "Mails are not sent" in your extension, try to set a
``ReturnPath:``. Start as before but add:

..  code-block:: php
    :caption: EXT:site_package/Classes/Utility/MyMailUtility.php

    use TYPO3\CMS\Core\Utility\MailUtility;

    // You will get a valid email address from 'defaultMailFromAddress' or if
    // not set from PHP settings or from system.
    // If result is not a valid email address, the final result will be
    // no-reply@example.org.
    $returnPath = MailUtility::getSystemFromAddress();
    if ($returnPath != "no-reply@example.org") {
        $mail->setReturnPath($returnPath);
    }
    $mail->send();


..  index::
    Mail; Custom mailer
..  _register-custom-mailer:

Register a custom mailer
========================

..  versionadded:: 12.1

To be able to use a custom mailer implementation in TYPO3, the interface
:php:`\TYPO3\CMS\Core\Mail\MailerInterface` is available, which extends
:php:`\Symfony\Component\Mailer\MailerInterface`. By default,
:php:`\TYPO3\CMS\Core\Mail\Mailer` is registered as implementation.

After implementing your custom mailer, add the following lines into the
:file:`Configuration/Services.yaml` file to ensure that your custom
mailer is used.

..  code-block:: yaml
    :caption: EXT:site_package/Configuration/Services.yaml

    TYPO3\CMS\Core\Mail\MailerInterface:
        alias: MyVendor\SitePackage\Mail\MyCustomMailer


PSR-14 events on sending messages
=================================

Some PSR-14 events are available:

-   :ref:`AfterMailerInitializationEvent` to add custom mailing settings.
-   :ref:`BeforeMailerSentMessageEvent` to manipulate messages before they are
    sent by the mailer.
-   :ref:`AfterMailerSentMessageEvent` to further process a sent message.


..  index:: pair: Mail; Symfony
..  _mail-symfony-mime:

Symfony mail documentation
==========================

Please refer to the Symfony documentation for more information about
available methods.

.. seealso::

   - `The Mime Component <https://symfony.com/doc/current/components/mime.html>`__

   - `Sending Emails with Mailer <https://symfony.com/doc/current/mailer.html>`__
