<?php

declare(strict_types=1);

namespace Services\tests;

use PHPUnit\Framework\TestCase;
use Services\ConverterRot;


class ConverterRotTest extends TestCase
{
    private $ConverterRot;

    public function setUp(): void
    {

        $this->ConverterRot = new ConverterRot();
    }

    public function tearDown(): void
    {
        // Clean up any resources used during testing
    }

    public function testExpected(): void
    {
        $result = $this->ConverterRot->handle('dsadas');
        $this->assertSame('qfnqnf', $result);
    }

}
