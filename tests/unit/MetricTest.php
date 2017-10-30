<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Metric;

/**
 * Class MetricTest
 * @package Vantoozz\ProxyScraper\UnitTests
 */
final class MetricTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_returns_name()
    {
        $metric = new Metric('some_name', 123);
        static::assertSame('some_name', $metric->getName());
    }

    /**
     * @test
     * @return void
     */
    public function it_returns_value()
    {
        $metric = new Metric('some_name', 123);
        static::assertSame(123, $metric->getValue());
    }

    /**
     * @test
     * @return void
     */
    public function it_converts_to_a_string()
    {
        $metric = new Metric('some_name', 123);
        static::assertSame('some_name: 123', (string)$metric);
    }
}
