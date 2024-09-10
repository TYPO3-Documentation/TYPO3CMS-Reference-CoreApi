<?php

namespace T3docs\Examples\LinkHandler;

// use ...
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Controller\AbstractLinkBrowserController;
use TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class GitHubLinkHandler implements LinkHandlerInterface
{
    protected $linkAttributes = ['target', 'title', 'class', 'params', 'rel'];
    protected StandaloneView $view;
    protected $configuration;
    private IconFactory $iconFactory;
    private AbstractLinkBrowserController $linkBrowser;
    private array $linkParts;

    /**
     * Initialize the handler
     *
     * @param AbstractLinkBrowserController $linkBrowser
     * @param string $identifier
     * @param array $configuration Page TSconfig
     */
    public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration)
    {
        $this->linkBrowser = $linkBrowser;
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->getRequest()->setControllerExtensionName('examples');
        $this->view->setTemplateRootPaths([GeneralUtility::getFileAbsFileName('EXT:examples/Resources/Private/Templates/LinkBrowser')]);
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
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    public function render(ServerRequestInterface $request): string
    {
        GeneralUtility::makeInstance(PageRenderer::class)
            ->loadRequireJsModule('TYPO3/CMS/Examples/GitHubLinkHandler');

        $this->view->assign('project', $this->configuration['project']);
        $this->view->assign('action', $this->configuration['action']);
        $this->view->assign('github', !empty($this->linkParts) ? $this->linkParts['url']['github'] : '');
        return $this->view->render('GitHub');
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
