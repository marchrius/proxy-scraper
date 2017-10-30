<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\IntegrationTests\Scrapers;

use Vantoozz\ProxyScraper\IntegrationTests\IntegrationTest;
use Vantoozz\ProxyScraper\Scrapers\SocksProxyScraper;

/**
 * Class SocksProxyScraperTest
 * @package Vantoozz\ProxyScraper\Scrapers
 */
final class SocksProxyScraperTest extends IntegrationTest
{
    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function it_works()
    {
        $scrapper = new SocksProxyScraper($this->httpClient());

        $proxies = iterator_to_array($scrapper->get());
        $this->assertGreaterThanOrEqual(50, count($proxies));
    }
}
