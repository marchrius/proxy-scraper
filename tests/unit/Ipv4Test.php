<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Ipv4;

/**
 * Class Ipv4Test
 * @package Vantoozz\ProxyScraper
 */
final class Ipv4Test extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_converts_to_string()
    {
        $this->assertSame('127.0.0.1', (string)new Ipv4('127.0.0.1'));
    }

    /**
     * @test
     * @expectedExceptionMessage Invalid ipv4 string: some string
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\InvalidArgumentException
     * @return void
     */
    public function it_rejects_not_ip4v()
    {
        new Ipv4('some string');
    }

    /**
     * @test
     * @expectedExceptionMessage Invalid ipv4 string: 0:0:0:0:0:0:0:1
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\InvalidArgumentException
     * @return void
     */
    public function it_rejects_ipv6_addresses()
    {
        new Ipv4('0:0:0:0:0:0:0:1');
    }
}
