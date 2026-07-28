<?php

use TYPO3\CMS\Backend\Controller\AbstractLinkBrowserController;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\View\ViewInterface;

class GitHubLinkHandler implements LinkHandlerInterface
{
    protected array $linkAttributes = ['target', 'title', 'class', 'params', 'rel'];

    protected array $linkParts = [];

    protected ViewInterface $view;

    protected array $configuration;

    public function __construct(
        // The page renderer is needed to register the JavaScript
        private readonly PageRenderer $pageRenderer,
    ) {}

    public function initialize(
        AbstractLinkBrowserController $linkBrowser,
        $identifier,
        array $configuration,
    ): void {
        $this->configuration = $configuration;
    }

    public function setView(ViewInterface $view): void
    {
        $this->view = $view;
    }
}
