<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Item;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\PageTitle\RecordTitleProvider;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class ItemController extends ActionController
{
    public function __construct(
        private readonly RecordTitleProvider $recordTitleProvider,
    ) {}

    public function showAction(Item $item): ResponseInterface
    {
        $this->recordTitleProvider->setTitle($item->getTitle());
        $this->view->assign('item', $item);
        return $this->htmlResponse();
    }
}
