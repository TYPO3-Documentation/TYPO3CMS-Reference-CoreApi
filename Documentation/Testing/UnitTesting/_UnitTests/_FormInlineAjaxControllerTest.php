<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Backend\Controller\FormInlineAjaxController;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FormInlineAjaxControllerTest extends UnitTestCase
{
    #[Test]
    public function getInlineExpandCollapseStateArraySwitchesToFallbackIfTheBackendUserDoesNotHaveAnUCInlineViewProperty(): void
    {
        $backendUser =
            $this->createMock(BackendUserAuthentication::class);

        $mockObject = $this->getAccessibleMock(
            FormInlineAjaxController::class,
            ['getBackendUserAuthentication'],
            [],
            '',
            false,
        );
        $mockObject->method('getBackendUserAuthentication')
            ->willReturn($backendUser);
        $result = $mockObject
            ->_call('getInlineExpandCollapseStateArray');

        self::assertEmpty($result);
    }
}
