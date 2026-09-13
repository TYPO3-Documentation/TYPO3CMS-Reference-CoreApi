<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyClass
{
  public function sendMail(): void
  {
    $email = new FluidEmail();
    $email
        ->to('contact@example.org')
        ->from(new Address('jeremy@example.org', 'Jeremy'))
        ->subject('TYPO3 loves you - here is why')
        // Send HTML and plaintext mail
        ->format(FluidEmail::FORMAT_BOTH)
        ->setTemplate('TipsAndTricks')
        ->assign('mySecretIngredient', 'Tomato and TypoScript');
    GeneralUtility::makeInstance(MailerInterface::class)->send($email);
  }
}
