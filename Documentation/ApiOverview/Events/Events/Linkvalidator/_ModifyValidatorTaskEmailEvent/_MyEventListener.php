<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Linkvalidator\EventListener;

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Linkvalidator\Event\ModifyValidatorTaskEmailEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-validation-task-email',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyValidatorTaskEmailEvent $event): void
    {
        $linkAnalyzerResult = $event->getLinkAnalyzerResult();
        $fluidEmail = $event->getFluidEmail();
        $modTSconfig = $event->getModTSconfig();

        if ($modTSconfig['mail.']['fromname'] === 'John Smith') {
            $fluidEmail->assign('myAdditionalVariable', 'foobar');
        }

        $fluidEmail->subject(
            $linkAnalyzerResult->getTotalBrokenLinksCount() . ' new broken links',
        );

        $fluidEmail->to(new Address('custom@mail.com'));
    }
}
