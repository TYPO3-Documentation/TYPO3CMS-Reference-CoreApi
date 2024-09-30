<?php

namespace TYPO3\CMS\Styleguide\Tests\Functional\TcaDataGenerator;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class GeneratorTest extends FunctionalTestCase
{
    /**
     * Have styleguide loaded
     */
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/styleguide',
    ];

    #[Test]
    public function generatorCreatesBasicRecord(): void
    {
        //...
    }
}
