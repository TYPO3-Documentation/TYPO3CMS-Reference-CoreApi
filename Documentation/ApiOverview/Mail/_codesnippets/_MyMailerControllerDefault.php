<?php

use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\MailUtility;

final readonly class MyMailerController
{
    public function __construct(
        private MailerInterface $mailer,
    ) {}

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMail(MailMessage $email)
    {
        // As getSystemFrom() returns an array we need to use the setFrom method
        $email->setFrom(MailUtility::getSystemFrom());
        $this->mailer->send($email);
    }
}
