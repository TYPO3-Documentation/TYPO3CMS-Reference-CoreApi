<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function listAction(): ResponseInterface
    {
        $conferences = $this->conferenceRepository->findAll();

        // Link to the detail action on the same plugin/page,
        // using the first conference as an example
        $uri = $this->uriBuilder->uriFor(
            'show',                                  // action name — no 'Action' suffix
            ['conference' => $conferences->getFirst()],
            'Conference',                            // controller name
        );

        $this->view->assign('conferences', $conferences);
        $this->view->assign('detailUri', $uri);
        return $this->htmlResponse();
    }
}
