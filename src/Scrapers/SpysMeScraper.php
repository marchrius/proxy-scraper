<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Scrapers;

/**
 * Class SpysMeScraper
 * @package Vantoozz\ProxyScraper\Scrapers
 */
final class SpysMeScraper extends RemoteTextScraper
{
    /**
     * @return string
     */
    protected function remoteTextUrl(): string
    {
        return 'http://spys.one/pl.txt';
    }
}
