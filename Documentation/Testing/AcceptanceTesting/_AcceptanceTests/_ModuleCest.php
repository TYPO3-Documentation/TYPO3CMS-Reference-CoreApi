<?php

declare(strict_types=1);

namespace TYPO3\CMS\Styleguide\Tests\Acceptance\Backend;

use TYPO3\CMS\Styleguide\Tests\Acceptance\Support\BackendTester;

class ModuleCest
{
    /**
     * @param BackendTester $I
     */
    public function _before(BackendTester $I)
    {
        $I->useExistingSession('admin');
    }
}
