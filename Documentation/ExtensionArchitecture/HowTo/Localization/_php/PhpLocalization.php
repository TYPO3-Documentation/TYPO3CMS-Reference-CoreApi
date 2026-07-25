<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Service\TableInformationService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ModuleController extends ActionController
{
    public function __construct(TableInformationService $tableInformationService) {}

    /**
     * Adds a count of entries to the flash message
     */
    public function countAction(string $tablename = 'pages'): ResponseInterface
    {
        $count = $this->tableInformationService->countRecords($tablename);

        $message = LocalizationUtility::translate(
            'record_count_message',
            'examples',
            [$count, $tablename],
        );

        $this->addFlashMessage(
            $message ?? '',
            'Information',
            ContextualFeedbackSeverity::INFO,
        );
        return $this->redirect('flash');
    }
}
