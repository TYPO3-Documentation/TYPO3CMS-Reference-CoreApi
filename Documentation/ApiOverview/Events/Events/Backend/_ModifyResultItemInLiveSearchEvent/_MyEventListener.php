<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Search\Event\ModifyResultItemInLiveSearchEvent;
use TYPO3\CMS\Backend\Search\LiveSearch\DatabaseRecordProvider;
use TYPO3\CMS\Backend\Search\LiveSearch\ResultItemAction;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

#[AsEventListener(
    identifier: 'my-extension/add-live-search-result-actions-listener',
)]
final readonly class MyEventListener
{
    private LanguageService $languageService;

    public function __construct(
        private IconFactory $iconFactory,
        LanguageServiceFactory $languageServiceFactory,
        private UriBuilder $uriBuilder,
    ) {
        $this->languageService = $languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
    }

    public function __invoke(ModifyResultItemInLiveSearchEvent $event): void
    {
        $resultItem = $event->getResultItem();
        if ($resultItem->getProviderClassName() !== DatabaseRecordProvider::class) {
            return;
        }

        if (($resultItem->getExtraData()['table'] ?? null) === 'tt_content') {
            /**
             * WARNING: THIS EXAMPLE OMITS ANY ACCESS CHECK FOR SIMPLICITY REASONS - DO NOT USE AS-IS
             */
            $showHistoryAction = (new ResultItemAction('view_history'))
                ->setLabel($this->languageService->sL('LLL:EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf:history'))
                ->setIcon($this->iconFactory->getIcon('actions-document-history-open', IconSize::SMALL))
                ->setUrl((string)$this->uriBuilder->buildUriFromRoute('record_history', [
                    'element' => $resultItem->getExtraData()['table'] . ':' . $resultItem->getExtraData()['uid'],
                ]));
            $resultItem->addAction($showHistoryAction);
        }
    }
}
