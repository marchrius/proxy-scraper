<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;
use Vantoozz\ProxyScraper\Exceptions\ScraperException;
use Vantoozz\ProxyScraper\HttpClient\GuzzleHttpClient;
use Vantoozz\ProxyScraper\Scrapers;

require_once __DIR__ . '/../vendor/autoload.php';

$httpClient = new GuzzleHttpClient(new GuzzleClient([
    'connect_timeout' => 2,
    'timeout' => 3,
]));
$scraper = new Scrapers\FoxToolsScraper($httpClient);

foreach ($scraper->get() as $proxy) {
    echo (string)$proxy . "\n";
}