<?php

namespace MyVendor\MyExtension\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class SomeTest extends FunctionalTestCase
{
    protected array $pathsToLinkInTestInstance = [
        'typo3/sysext/impexp/Tests/Functional/Fixtures/Folders/fileadmin/user_upload/typo3_image2.jpg' => 'fileadmin/user_upload/typo3_image2.jpg',
    ];
    public function testSomethingWithFiles()
    {
        //...
    }
}
