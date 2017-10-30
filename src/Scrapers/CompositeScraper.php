<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Scrapers;

use Vantoozz\ProxyScraper\Exceptions\ScraperException;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Class CompositeScraper
 * @package Vantoozz\ProxyScrapper\Scrapers
 */
final class CompositeScraper implements ScraperInterface
{
    /**
     * @var ScraperInterface[]
     */
    private $scrapers = [];

    /**
     * @var callable
     */
    private $exceptionHandler;

    /**
     * @return \Generator|Proxy[]
     * @throws \Vantoozz\ProxyScraper\Exceptions\ScraperException
     */
    public function get(): \Generator
    {
        foreach ($this->scrapers as $scraper) {
            try {
                yield from $scraper->get();
            } catch (ScraperException $e) {
                $this->handleScraperException($e);
            }
        }
    }

    /**
     * @param ScraperInterface $scraper
     * @return void
     */
    public function addScraper(ScraperInterface $scraper)
    {
        $this->scrapers[] = $scraper;
    }

    /**
     * @param callable $exceptionHandler
     * @return void
     */
    public function handleScraperExceptionWith(callable $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @param ScraperException $e
     * @throws ScraperException
     * @return void
     */
    private function handleScraperException(ScraperException $e)
    {
        if (!is_callable($this->exceptionHandler)) {
            throw $e;
        }
        call_user_func($this->exceptionHandler, $e);
    }
}
