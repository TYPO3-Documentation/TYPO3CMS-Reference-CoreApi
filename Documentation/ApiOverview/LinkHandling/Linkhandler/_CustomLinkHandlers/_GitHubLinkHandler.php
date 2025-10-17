<?php

namespace T3docs\Examples\LinkHandler;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Backend\Controller\AbstractLinkBrowserController;
use TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

#[Autoconfigure(public: true)]
final class GitHubLinkHandler implements LinkHandlerInterface
{
    protected $linkAttributes = ['target', 'title', 'class', 'params', 'rel'];
    protected $configuration;
    private array $linkParts;

    public function __construct(
        private readonly PageRenderer $pageRenderer,
        private readonly ViewFactoryInterface $viewFactory,
    ) {}

    /**
     * Initialize the handler
     *
     * @param AbstractLinkBrowserController $linkBrowser
     * @param string $identifier
     * @param array $configuration Page TSconfig
     */
    public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Checks if this is the handler for the given link
     *
     * Also stores information locally about currently linked issue
     *
     * @param array $linkParts Link parts as returned from TypoLinkCodecService
     *
     * @return bool
     */
    public function canHandleLink(array $linkParts)
    {
        if (isset($linkParts['url']['github'])) {
            $this->linkParts = $linkParts;
            return true;
        }
        return false;
    }

    /**
     * Format the current link for HTML output
     *
     * @return string
     */
    public function formatCurrentUrl(): string
    {
        return $this->linkParts['url']['github'];
    }

    /**
     * Render the link handler
     */
    public function render(ServerRequestInterface $request): string
    {
        $this->pageRenderer->loadJavaScriptModule('@vendor/my-extension/GitHubLinkHandler.js');
        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: ['EXT:my_extension/Resources/Private/Templates/LinkBrowser'],
            partialRootPaths: ['EXT:my_extension/Resources/Private/Partials/LinkBrowser'],
            layoutRootPaths: ['EXT:my_extension/Resources/Private/Layouts/LinkBrowser'],
            request: $request,
        );
        $view = $this->viewFactory->create($viewFactoryData);
        $view->assign('project', $this->configuration['project']);
        $view->assign('action', $this->configuration['action']);
        $view->assign('github', !empty($this->linkParts) ? $this->linkParts['url']['github'] : '');
        return $view->render('GitHub');
    }

    /**
     * @return string[] Array of body-tag attributes
     */
    public function getBodyTagAttributes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getLinkAttributes()
    {
        return $this->linkAttributes;
    }

    /**
     * @param string[] $fieldDefinitions Array of link attribute field definitions
     * @return string[]
     */
    public function modifyLinkAttributes(array $fieldDefinitions)
    {
        return $fieldDefinitions;
    }

    /**
     * We don't support updates since there is no difference to simply set the link again.
     *
     * @return bool
     */
    public function isUpdateSupported()
    {
        return false;
    }
}
