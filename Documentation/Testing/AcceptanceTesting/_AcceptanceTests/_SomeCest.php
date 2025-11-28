<?php

declare(strict_types=1);

namespace TYPO3\CMS\Styleguide\Tests\Acceptance\Backend;

use TYPO3\CMS\Styleguide\Tests\Acceptance\Support\BackendTester;

class SomeCest
{
    /**
     * @param BackendTester $I
     */
    public function _before(BackendTester $I)
    {   // Switch to "content frame", eg the "Records module" content
        $I->switchToContentFrame();

        // Switch to "main frame", the frame with the main modules and top bar
        $I->switchToMainFrame();
    }
}
