<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Tests\Acceptance\Support\Helper;

use TYPO3\CMS\Core\Tests\Acceptance\Support\BackendTester;
use TYPO3\TestingFramework\Core\Acceptance\Helper\AbstractPageTree;

/**
 * @see AbstractPageTree
 */
class PageTree extends AbstractPageTree
{
    /**
     * Inject our Core AcceptanceTester actor into PageTree
     *
     * @param BackendTester $I
     */
    public function __construct(BackendTester $I)
    {
        $this->tester = $I;
    }
}
