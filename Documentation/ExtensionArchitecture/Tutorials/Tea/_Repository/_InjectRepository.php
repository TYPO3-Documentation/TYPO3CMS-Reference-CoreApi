<?php

declare(strict_types=1);

namespace TTN\Tea\Controller;

use Psr\Http\Message\ResponseInterface;
use TTN\Tea\Domain\Repository\Product\TeaRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class TeaController extends ActionController
{
    public function __construct(private TeaRepository $teaRepository) {}

    public function indexAction(): ResponseInterface
    {
        $this->view->assign('teas', $this->teaRepository->findAll());
        return $this->htmlResponse();
    }
}
