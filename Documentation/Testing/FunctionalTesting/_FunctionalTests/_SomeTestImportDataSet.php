<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SomeTest extends FunctionalTestCase
{
    #[Test]
    public function importData(): void
    {
        // Load a CSV file relative to test case file
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/pages.csv');
        // Load a CSV file of some extension
        $this->importCSVDataSet('EXT:frontend/Tests/Functional/Fixtures/pages-title-tag.csv');
        // Load a CSV file provided by the typo3/testing-framework package
        $this->importCSVDataSet('PACKAGE:typo3/testing-framework/Resources/Core/Functional/Fixtures/pages.csv');
    }
}
