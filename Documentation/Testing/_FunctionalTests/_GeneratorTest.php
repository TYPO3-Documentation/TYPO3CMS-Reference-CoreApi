<?php

namespace TYPO3\CMS\Styleguide\Tests\Functional\TcaDataGenerator;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class GeneratorTest extends FunctionalTestCase
{
    /**
     * Have styleguide loaded
     */
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/styleguide',
    ];

    /**
     * @test
     */
    public function generatorCreatesBasicRecord()
    {
        //...
    }
}
