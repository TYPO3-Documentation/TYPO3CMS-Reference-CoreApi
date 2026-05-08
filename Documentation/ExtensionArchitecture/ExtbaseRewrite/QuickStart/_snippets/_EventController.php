<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\EventRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class EventController extends ActionController
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $this->view->assign('events', $this->eventRepository->findAll());
        return $this->htmlResponse();
    }

    public function showAction(
        \MyVendor\MyExtension\Domain\Model\Event $event,
    ): ResponseInterface {
        $this->view->assign('event', $event);
        return $this->htmlResponse();
    }
}
