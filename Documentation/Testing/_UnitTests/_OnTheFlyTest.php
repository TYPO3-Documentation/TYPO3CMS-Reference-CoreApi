<?php

namespace TYPO3\CMS\Backend\Tests\Unit\Form\FormDataGroup;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Backend\Form\FormDataGroup\OnTheFly;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class OnTheFlyTest extends UnitTestCase
{
    protected OnTheFly $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new OnTheFly();
    }

    #[Test]
    public function compileThrowsExceptionWithEmptyOnTheFlyList(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionCode(1441108674);
        $this->subject->compile([]);
    }
}
