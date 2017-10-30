<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests\Scrapers;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Exceptions\HttpClientException;
use Vantoozz\ProxyScraper\HttpClient\HttpClientInterface;
use Vantoozz\ProxyScraper\Proxy;
use Vantoozz\ProxyScraper\Scrapers\ProxyDbScraper;

/**
 * Class ProxyDbScraperTest
 * @package Vantoozz\ProxyScraper\Scrapers
 */
final class ProxyDbScraperTest extends TestCase
{
    /**
     * @test
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\ScraperException
     * @expectedExceptionMessage error message
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_throws_an_exception_on_http_client_error()
    {
        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $httpClient */
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects(static::once())
            ->method('get')
            ->willThrowException(new HttpClientException('error message'));

        $scraper = new ProxyDbScraper($httpClient);
        $scraper->get()->current();
    }

    /**
     * @test
     * @expectedException \Vantoozz\ProxyScraper\Exceptions\ScraperException
     * @expectedExceptionMessage some text
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_throws_an_exception_on_non_html_response()
    {
        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $httpClient */
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects(static::once())
            ->method('get')
            ->willReturn('some text');

        $scraper = new ProxyDbScraper($httpClient);
        $scraper->get()->current();
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_returns_a_proxy()
    {
        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $httpClient */
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects(static::once())
            ->method('get')
            ->willReturn('<table><tbody><tr><td>46.101.55.200:8118</td></tr></table>');

        $scraper = new ProxyDbScraper($httpClient);
        $proxy = $scraper->get()->current();

        $this->assertInstanceOf(Proxy::class, $proxy);
        $this->assertSame('46.101.55.200:8118', (string)$proxy);
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_skips_bad_rows()
    {
        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $httpClient */
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects(static::exactly(21))
            ->method('get')
            ->willReturn('<table><tbody><tr><td>bad proxy string</td></tr></table>');

        $scraper = new ProxyDbScraper($httpClient);

        $this->assertNull($scraper->get()->current());
    }
}
