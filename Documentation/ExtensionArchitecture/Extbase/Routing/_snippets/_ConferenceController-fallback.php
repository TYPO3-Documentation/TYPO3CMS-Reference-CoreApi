<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Conference;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConferenceController extends ActionController
{
    public function showAction(?Conference $conference = null): ResponseInterface
    {
        if ($conference === null) {
            $this->addFlashMessage(
                'The requested conference could not be found.',
                '',
                ContextualFeedbackSeverity::WARNING,
            );
            return $this->redirect('list');
        }

        $this->view->assign('conference', $conference);
        return $this->htmlResponse();
    }
}
