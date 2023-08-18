<?php

namespace App\Tests;

use App\LibraryRPN;
use Exception;
use PHPUnit\Framework\TestCase;

class LibraryRPNTest extends TestCase
{
    /**
     * @dataProvider additionalProvider
     * @throws Exception
     */
    public function testCalcFunc($string, $expected)
    {
        $rpn = new LibraryRPN($string);
        $this->assertSame($expected, $rpn->getResult());
    }

    public function additionalProvider(): array
    {
        return [
            ["7 2 3 * -", 1.0],
            ["1 2 + 4 * 3 +", 15.0],
        ];
    }
}
