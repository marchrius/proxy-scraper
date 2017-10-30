<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests\Scrapers;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Proxy;
use Vantoozz\ProxyScraper\Scrapers\TextScraper;

/**
 * Class TextScraperTest
 * @package Vantoozz\ProxyScraper\Scrapers
 */
final class TextScraperTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_returns_a_proxy()
    {
        $scraper = new TextScraper("222.111.222.111:8118\n111.222.111.222:8118");
        $proxy = $scraper->get()->current();

        $this->assertInstanceOf(Proxy::class, $proxy);
        $this->assertSame('222.111.222.111:8118', (string)$proxy);
    }

    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_skips_bad_rows()
    {
        $scraper = new TextScraper('2312318');

        $this->assertNull($scraper->get()->current());
    }
}
