<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\SystemTests\Reports;

/**
 * Interface ReportInterface
 * @package Vantoozz\ProxyScraper\SystemTests\Reports
 */
interface ReportInterface
{
    /**
     * @param array $proxies
     * @return void
     */
    public function run(array $proxies);
}