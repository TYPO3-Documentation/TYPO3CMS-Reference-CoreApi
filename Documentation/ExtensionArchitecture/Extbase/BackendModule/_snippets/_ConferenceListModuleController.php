<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\ConferenceDemand;
use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Module\ModuleData;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

class ConferenceModuleController extends ActionController
{
  protected ?ModuleData $moduleData = null;
  protected ?ModuleTemplate $moduleTemplate = null;

  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly ConferenceRepository $conferenceRepository,
    protected readonly ExtensionConfiguration $extensionConfiguration,
  ) {}

  #[\Override]
  protected function initializeAction(): void
  {
    // The constructor runs before the request is known. Everything that
    // depends on the request is set up here, before each action.
    $this->moduleData = $this->request->getAttribute('moduleData');
    $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
  }

  public function listAction(
    ?ConferenceDemand $demand = null,
    int $currentPage = 1,
    string $operation = '',
  ): ResponseInterface {
    if ($operation === 'reset-filters') {
      $this->moduleData->set('demand', []);
      $demand = null;
    }
    if ($demand === null) {
      $demand = ConferenceDemand::fromArray(
        (array)$this->moduleData->get('demand', []),
      );
    } else {
      $this->moduleData->set('demand', $demand->toArray());
    }
    // set() only changes this request. Store the module data in the
    // user's settings so the filters are still there next time.
    $this->getBackendUser()->pushModuleData(
      $this->moduleData->getModuleIdentifier(),
      $this->moduleData->toArray(),
    );

    $conferences = $this->conferenceRepository->findDemanded($demand);
    $paginator = new QueryResultPaginator($conferences, $currentPage, 25);

    $this->moduleTemplate->assignMultiple([
      'demand' => $demand,
      'paginator' => $paginator,
      'pagination' => new SimplePagination($paginator),
      'newRecordPid' => $this->getNewRecordPid(),
    ]);
    return $this->moduleTemplate->renderResponse('ConferenceModule/List');
  }

  protected function getNewRecordPid(): int
  {
    // A single page. Extension configuration values are strings.
    return (int)$this->extensionConfiguration->get('my_extension', 'newRecordPid');
  }

  protected function getBackendUser(): BackendUserAuthentication
  {
    return $GLOBALS['BE_USER'];
  }
}
