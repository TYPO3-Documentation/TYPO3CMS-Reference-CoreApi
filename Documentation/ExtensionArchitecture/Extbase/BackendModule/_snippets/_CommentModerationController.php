<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Comment;
use MyVendor\MyExtension\Domain\Repository\CommentRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Module\ModuleData;
use TYPO3\CMS\Backend\Template\Components\ComponentFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Http\AllowedMethodsTrait;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Attribute\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CommentModerationController extends ActionController
{
  use AllowedMethodsTrait;

  protected const ALL_LANGUAGES = -1;
  protected const TABLE = 'tx_myextension_domain_model_comment';

  protected ?ModuleData $moduleData = null;
  protected ?ModuleTemplate $moduleTemplate = null;
  protected int $pageId = 0;

  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly ComponentFactory $componentFactory,
    protected readonly IconFactory $iconFactory,
    protected readonly CommentRepository $commentRepository,
  ) {}

  #[\Override]
  protected function initializeAction(): void
  {
    $this->moduleData = $this->request->getAttribute('moduleData');
    $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    $this->pageId = (int)($this->request->getQueryParams()['id'] ?? 0);
  }

  public function listAction(?int $language = null): ResponseInterface
  {
    if ($this->pageId === 0) {
      $this->moduleTemplate->addFlashMessage(
        'Select a page in the page tree to moderate its comments.',
        'No page selected',
        ContextualFeedbackSeverity::INFO,
        false,
      );
      return $this->moduleTemplate->renderResponse('CommentModeration/List');
    }

    /** @var SiteInterface $site */
    $site = $this->request->getAttribute('site');
    $languages = $site->getAvailableLanguages(
      $this->getBackendUser(),
      true,
      $this->pageId,
    );
    $language ??= (int)$this->moduleData->get('language', 0);
    if (!isset($languages[$language])) {
      $language = (int)array_key_first($languages);
    }
    $this->moduleData->set('language', $language);
    $this->getBackendUser()->pushModuleData(
      $this->moduleData->getModuleIdentifier(),
      $this->moduleData->toArray(),
    );
    $this->addLanguageSelector($languages, $language);

    $languageAspect = $language === self::ALL_LANGUAGES
      ? null
      : LanguageAspectFactory::createFromSiteLanguage($languages[$language]);
    $this->moduleTemplate->assign(
      'comments',
      $this->commentRepository->findForModeration($languageAspect),
    );
    return $this->moduleTemplate->renderResponse('CommentModeration/List');
  }

  /**
   * @param array<int, SiteLanguage> $languages
   */
  protected function addLanguageSelector(array $languages, int $active): void
  {
    $selector = $this->componentFactory->createDropDownButton()
      ->setLabel('Language')
      ->setShowLabelText(true)
      ->setShowActiveLabelText(true);
    foreach ($languages as $languageId => $siteLanguage) {
      $selector->addItem(
        $this->componentFactory->createDropDownRadio()
          // Keeps the selected page
          ->setHref(
            $this->uriBuilder->reset()->uriFor('list', ['language' => $languageId]),
          )
          ->setLabel($siteLanguage->getTitle())
          ->setIcon(
            $this->iconFactory->getIcon($siteLanguage->getFlagIdentifier()),
          )
          ->setActive($languageId === $active),
      );
    }
    $this->moduleTemplate->getDocHeaderComponent()->setLanguageSelector($selector);
  }

  public function answerAction(
    Comment $comment,
    #[IgnoreValidation]
    ?Comment $answer = null,
  ): ResponseInterface {
    $this->moduleTemplate->assignMultiple([
      'comment' => $comment,
      'answer' => $answer ?? new Comment(),
    ]);
    return $this->moduleTemplate->renderResponse('CommentModeration/Answer');
  }

  protected function initializeCreateAnswerAction(): void
  {
    $this->assertAllowedHttpMethod($this->request, 'POST');
  }

  public function createAnswerAction(
    Comment $comment,
    Comment $answer,
  ): ResponseInterface {
    if (!$this->mayAnswer($comment)) {
      $this->addFlashMessage(
        'You are not allowed to add comments on this page.',
        'Answer not saved',
        ContextualFeedbackSeverity::ERROR,
      );
      return $this->redirect('list');
    }

    $answer->setReplyTo($comment);
    $answer->setAuthor((string)$this->getBackendUser()->getUserName());
    // Otherwise the first storagePid, possibly a parent folder
    $answer->setPid((int)$comment->getPid());
    $this->commentRepository->add($answer);

    $this->addFlashMessage('The answer has been saved.');
    return $this->redirect('list');
  }

  protected function mayAnswer(Comment $comment): bool
  {
    $backendUser = $this->getBackendUser();
    $page = BackendUtility::getRecord('pages', (int)$comment->getPid());
    return $backendUser->check('tables_modify', self::TABLE)
      && $page !== null
      && $backendUser->doesUserHaveAccess($page, Permission::CONTENT_EDIT);
  }

  protected function getBackendUser(): BackendUserAuthentication
  {
    return $GLOBALS['BE_USER'];
  }
}
