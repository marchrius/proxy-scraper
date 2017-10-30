<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\SystemTests\ProxiesMiner;

/**
 * Interface ProxiesMinerInterface
 * @package Vantoozz\ProxyScraper\SystemTests\ScrapersProxiesMiner
 */
interface ProxiesMinerInterface
{
    /**
     * @return array
     */
    public function getProxies(): array;
}