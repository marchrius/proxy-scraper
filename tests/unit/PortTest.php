<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Port;

/**
 * Class PortTest
 * @package Vantoozz\ProxyScraper
 */
final class PortTest extends TestCase
{
    /**
     * @test
     * @expectedExceptionMessage Bad port number: -1
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\InvalidArgumentException
     * @return void
     */
    public function it_rejects_negative_port_number()
    {
        new Port(-1);
    }

    /**
     * @test
     * @expectedExceptionMessage Bad port number: 0
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\InvalidArgumentException
     * @return void
     */
    public function it_rejects_zero_as_port_number()
    {
        new Port(0);
    }

    /**
     * @test
     * @expectedExceptionMessage Bad port number: 999999
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\InvalidArgumentException
     * @return void
     */
    public function it_rejects_too_large_port_number()
    {
        new Port(999999);
    }

    /**
     * @test
     * @return void
     */
    public function it_converts_to_string()
    {
        $this->assertSame('1234', (string)new Port(1234));
    }
}
