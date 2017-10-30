<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Ipv4;
use Vantoozz\ProxyScraper\Metric;
use Vantoozz\ProxyScraper\Port;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Class ProxyTest
 * @package Vantoozz\ProxyScraper
 */
final class ProxyTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_converts_to_string()
    {
        $proxy = new Proxy(new Ipv4('192.168.0.1'), new Port(1234));
        $this->assertSame('192.168.0.1:1234', (string)$proxy);
    }

    /**
     * @test
     * @return void
     */
    public function it_returns_ipv4()
    {
        $ipv4 = new Ipv4('192.168.0.1');
        $proxy = new Proxy($ipv4, new Port(1234));
        $this->assertSame($ipv4, $proxy->getIpv4());
    }

    /**
     * @test
     * @return void
     */
    public function it_returns_port()
    {
        $port = new Port(1234);
        $proxy = new Proxy(new Ipv4('192.168.0.1'), $port);
        $this->assertSame($port, $proxy->getPort());
    }

    /**
     * @test
     * @return void
     */
    public function it_stores_metrics()
    {
        $one = new Metric('one', 111);
        $two = new Metric('two', 222);

        $proxy = new Proxy(new Ipv4('8.8.8.8'), new Port(8888));

        $proxy->addMetric($one);
        $proxy->addMetric($two);

        $this->assertSame([$one, $two], $proxy->getMetrics());
    }
}
