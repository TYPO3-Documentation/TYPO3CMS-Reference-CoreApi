<?php

use Psr\Http\Message\ResponseInterface;
use TTN\Tea\Domain\Repository\Product\TeaRepository;

class TeaController extends ActionController
{
    private TeaRepository $teaRepository;

    public function __construct(TeaRepository $teaRepository)
    {
        $this->teaRepository = $teaRepository;
    }

    public function indexAction(): ResponseInterface
    {
        $this->view->assign('teas', $this->teaRepository->findAll());
        return $this->htmlResponse();
    }
}
