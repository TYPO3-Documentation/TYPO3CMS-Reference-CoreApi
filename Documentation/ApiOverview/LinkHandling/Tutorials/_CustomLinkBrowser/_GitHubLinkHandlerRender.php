<?php

use Psr\Http\Message\ServerRequestInterface;

class GitHubLinkHandler implements LinkHandlerInterface
{
    public function render(ServerRequestInterface $request): string
    {
        $this->pageRenderer->loadJavaScriptModule('@t3docs/examples/github_link_handler.js');
        $this->view->assign('project', $this->configuration['project']);
        $this->view->assign('action', $this->configuration['action']);
        $this->view->assign('linkParts', $this->linkParts);
        $this->view->assign('issue', $this->linkParts['issue'] ?? '');

        return $this->view->render('LinkBrowser/GitHub');
    }
}
