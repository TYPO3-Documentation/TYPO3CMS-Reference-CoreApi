<?php

declare(strict_types=1);

namespace TYPO3\CMS\Backend\Tests\Functional\Domain\Repository\Localization;

use TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class LocalizationRepositoryTest extends FunctionalTestCase
{
    /**
     * @var LocalizationRepository
     */
    protected $subject;

    /**
     * Sets up this test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/be_users.csv');
        $this->setUpBackendUser(1);
        Bootstrap::initializeLanguageObject();

        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3/sysext/backend/Tests/Functional/Domain/Repository/Localization/Fixtures/DefaultPagesAndContent.csv');

        $this->subject = new LocalizationRepository();
    }

    // ...
}
