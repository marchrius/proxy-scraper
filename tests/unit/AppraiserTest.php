<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Appraiser;
use Vantoozz\ProxyScraper\Exceptions\HttpClientException;
use Vantoozz\ProxyScraper\HttpClient\DummyHtmlClient;
use Vantoozz\ProxyScraper\HttpClient\HttpClientInterface;
use Vantoozz\ProxyScraper\Ipv4;
use Vantoozz\ProxyScraper\Port;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Class AppraiserTest
 * @package Vantoozz\ProxyScraper\UnitTests
 */
final class AppraiserTest extends TestCase
{
    /**
     * @test
     * @dataProvider metricsDataProvider
     * @param array $proxied
     * @param array $expected
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     */
    public function it_returns_metrics(array $proxied, array $expected)
    {
        $client = new DummyHtmlClient(
            json_encode(['remote_address' => '127.0.0.1', 'headers' => []]),
            json_encode($proxied)
        );
        $appraiser = new Appraiser($client, 'some url');

        $metrics = [];
        foreach ($appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888))) as $metric) {
            $metrics[$metric->getName()] = $metric->getValue();
        }
        ksort($expected);
        ksort($metrics);

        static::assertSame($expected, $metrics);
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     */
    public function it_validates_response_from_whoami()
    {
        $client = new DummyHtmlClient(
            json_encode(['remote_address' => '127.0.0.1', 'headers' => []]),
            'some string'
        );
        $appraiser = new Appraiser($client, 'some url');

        $expected = ['available' => false];

        $metrics = [];
        foreach ($appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888))) as $metric) {
            $metrics[$metric->getName()] = $metric->getValue();
        }
        ksort($expected);
        ksort($metrics);

        static::assertSame($expected, $metrics);
    }

    /**
     * @test
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     * @expectedExceptionMessage Invalid ipv4 string: some string
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     */
    public function it_throws_exception_on_bad_whoami_response()
    {
        $client = new DummyHtmlClient(
            json_encode(['remote_address' => 'some string', 'headers' => []]),
            'some string'
        );
        $appraiser = new Appraiser($client, 'some url');

        $appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888)))->current();
    }

    /**
     * @test
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     * @expectedExceptionMessage error message
     */
    public function it_throws_exception_on_http_client_exception()
    {
        $client = new class implements HttpClientInterface
        {
            public function get(string $uri): string
            {
                throw new HttpClientException('error message');
            }

            public function getProxied(string $uri, string $proxy): string
            {
                return '';
            }
        };
        $appraiser = new Appraiser($client, 'some url');

        $appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888)))->current();
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     */
    public function it_returns_metric_on_proxied_http_client_exception()
    {
        $client = new class implements HttpClientInterface
        {
            public function get(string $uri): string
            {
                return json_encode(['remote_address' => '127.0.0.1', 'headers' => []]);
            }

            /**
             * @param string $uri
             * @param string $proxy
             * @return string
             * @throws HttpClientException
             */
            public function getProxied(string $uri, string $proxy): string
            {
                throw new HttpClientException('error message');
            }
        };

        $appraiser = new Appraiser($client, 'some url');

        $expected = ['available' => false];

        $metrics = [];
        foreach ($appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888))) as $metric) {
            $metrics[$metric->getName()] = $metric->getValue();
        }
        ksort($expected);
        ksort($metrics);

        static::assertSame($expected, $metrics);
    }


    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\AppraiserException
     */
    public function it_returns_failed_https_metric()
    {


        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->createMock(HttpClientInterface::class);

        $client
            ->expects(static::once())
            ->method('get')
            ->willReturn(json_encode(['remote_address' => '127.0.0.1', 'headers' => []]));

        $client
            ->expects(static::at(1))
            ->method('getProxied')
            ->willReturn(json_encode(['remote_address' => '127.0.0.2', 'headers' => []]));

        $client
            ->expects(static::at(2))
            ->method('getProxied')
            ->willThrowException(new HttpClientException('error message'));

        $appraiser = new Appraiser($client, 'some url');

        $expected = ['available' => true, 'anonymity' => 'elite', 'https' => false];

        $metrics = [];
        foreach ($appraiser->appraise(new Proxy(new Ipv4('8.8.8.8'), new Port(8888))) as $metric) {
            $metrics[$metric->getName()] = $metric->getValue();
        }
        ksort($expected);
        ksort($metrics);

        static::assertSame($expected, $metrics);
    }

    /**
     * @return array
     */
    public function metricsDataProvider()
    {
        return [
            [
                ['remote_address' => '127.0.0.1', 'headers' => []],
                ['available' => true, 'anonymity' => 'transparent', 'https' => true],
            ],
            [
                ['remote_address' => '127.0.0.2', 'headers' => []],
                ['available' => true, 'anonymity' => 'elite', 'https' => true],
            ],
            [
                ['remote_address' => '127.0.0.2', 'headers' => ['X-Real-Ip' => '127.0.0.1']],
                ['available' => true, 'anonymity' => 'transparent', 'https' => true],
            ],
            [
                ['remote_address' => '127.0.0.2', 'headers' => ['X-Real-Ip' => '127.0.0.3']],
                ['available' => true, 'anonymity' => 'anonymous', 'https' => true],
            ],
            [
                [],
                ['available' => false],
            ],
            [
                ['remote_address' => 123, 'headers' => 123],
                ['available' => false],
            ],
            [
                ['remote_address' => '127.0.0.1', 'headers' => 123],
                ['available' => false],
            ],
        ];
    }
}
