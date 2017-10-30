<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests\HttpClient;

use GuzzleHttp\ClientInterface as Guzzle;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Vantoozz\ProxyScraper\HttpClient\GuzzleHttpClient;

/**
 * Class GuzzleHttpClientTest
 * @package Vantoozz\ProxyScraper\UnitTests\HttpClient
 */
final class GuzzleHttpClientTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     */
    public function it_returns_a_string()
    {
        /** @var Guzzle|\PHPUnit_Framework_MockObject_MockObject $guzzle */
        $guzzle = $this->createMock(Guzzle::class);

        /** @var Response|\PHPUnit_Framework_MockObject_MockObject $response */
        $response = $this->createMock(Response::class);

        /** @var StreamInterface|\PHPUnit_Framework_MockObject_MockObject $body */
        $body = $this->createMock(StreamInterface::class);

        $guzzle
            ->expects(static::once())
            ->method('request')
            ->willReturn($response);

        $response
            ->expects(static::once())
            ->method('getBody')
            ->willReturn($body);

        $body
            ->expects(static::once())
            ->method('getContents')
            ->willReturn('some string');

        $client = new GuzzleHttpClient($guzzle);
        static::assertSame('some string', $client->get('http://google.com'));
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     */
    public function it_returns_a_proxied_string()
    {
        /** @var Guzzle|\PHPUnit_Framework_MockObject_MockObject $guzzle */
        $guzzle = $this->createMock(Guzzle::class);

        /** @var Response|\PHPUnit_Framework_MockObject_MockObject $response */
        $response = $this->createMock(Response::class);

        /** @var StreamInterface|\PHPUnit_Framework_MockObject_MockObject $body */
        $body = $this->createMock(StreamInterface::class);

        $guzzle
            ->expects(static::once())
            ->method('request')
            ->willReturn($response);

        $response
            ->expects(static::once())
            ->method('getBody')
            ->willReturn($body);

        $body
            ->expects(static::once())
            ->method('getContents')
            ->willReturn('some string');

        $client = new GuzzleHttpClient($guzzle);
        static::assertSame('some string', $client->getProxied('http://google.com', 'proxy'));
    }

    /**
     * @test
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     * @expectedExceptionMessage error message
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     */
    public function it_throws_http_exception()
    {
        /** @var Guzzle|\PHPUnit_Framework_MockObject_MockObject $guzzle */
        $guzzle = $this->createMock(Guzzle::class);

        $guzzle
            ->expects(static::once())
            ->method('request')
            ->willThrowException(new \RuntimeException('error message'));

        $client = new GuzzleHttpClient($guzzle);
        $client->get('http://google.com');
    }
}
