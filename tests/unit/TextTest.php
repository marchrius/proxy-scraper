<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Text;

/**
 * Class TextTest
 * @package Vantoozz\ProxyScraper\UnitTests
 */
final class TextTest extends TestCase
{
    /**
     * @test
     * @dataProvider htmlDataProvider
     * @param string $string
     * @param bool $expected
     * @return void
     */
    public function it_detects_html(string $string, bool $expected)
    {
        $this->assertEquals((new Text($string))->isHtml(), $expected);
    }

    /**
     * @return array
     */
    public function htmlDataProvider(): array
    {
        return [
            ['<p>some text</p>', true],
            ['some text', false],
        ];
    }
}
