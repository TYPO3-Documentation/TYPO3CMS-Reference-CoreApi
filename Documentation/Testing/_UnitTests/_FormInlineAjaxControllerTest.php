<?php

namespace TYPO3\CMS\Core\Tests\Unit\Utility;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Controller\FormInlineAjaxController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FormInlineAjaxControllerTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createActionThrowsExceptionIfContextIsEmpty(): void
    {
        $requestProphecy = $this->prophesize(ServerRequestInterface::class);
        $requestProphecy->getParsedBody()->shouldBeCalled()->willReturn(
            [
                'ajax' => [
                    'context' => '',
                ],
            ],
        );
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1489751361);
        (new FormInlineAjaxController())->createAction($requestProphecy->reveal());
    }
}
