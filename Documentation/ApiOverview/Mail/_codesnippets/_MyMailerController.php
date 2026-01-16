<?php

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

final readonly class MyMailerController
{
    public function __construct(
        private MailerInterface $mailer,
    ) {}

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMail()
    {
        $email = new MailMessage();
        // Prepare and send the message
        $email
            // Defining the "From" email address and name as an object
            // (email clients will display the name)
            ->from(new Address('john.doe@example.org', 'John Doe'))

            // Set the "To" addresses
            ->to(
                new Address('receiver@example.org', 'Max Mustermann'),
                new Address('other@example.org'),
            )

            // Give the message a subject
            ->subject('Your subject')

            // Give it the text message
            ->text('Here is the message itself')

            // And optionally an HTML message
            ->html('<p>Here is the message itself</p>')

            // Optionally add any attachments
            ->attachFromPath('/path/to/my-document.pdf');
        // And finally send it
        $this->mailer->send($email);
    }
}
