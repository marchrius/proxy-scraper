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
$url = "https://www.zara.com/it/it/uomo-l534.html?v1=434788";
$okProxy = "";
try {
    foreach ($scraper->get() as $proxy) {
        if ($okProxy != "") continue;
        echo (string)$proxy . "\n";
        $client = new GuzzleClient(
            [
                'proxy' => (string)$proxy
            ]
        );

        try {
            $client->get($url);
        } catch (\Exception $e) {
            continue;
        }
        $okProxy = (string)$proxy;
    }
} catch (ScraperException $e) {
    echo "[Error]: " . $e->getMessage();
}

$client = new GuzzleClient([
    'proxy' => $okProxy
]);

try {
    $response = $client->get($url);
} catch (\Exception $e) {

}

echo $response->getStatusCode() == 200 ? "Ok" : $response->getStatusCode();

$contents = $response->getBody()->getContents();

echo $contents;
