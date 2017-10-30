<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\SystemTests\Reports;

/**
 * Class ReportsPipeline
 * @package Vantoozz\ProxyScraper\SystemTests\Reports
 */
final class ReportsPipeline implements ReportInterface
{
    /**
     * @var ReportInterface[]
     */
    private $reports = [];

    /**
     * @param ReportInterface $report
     * @return void
     */
    public function addReport(ReportInterface $report)
    {
        $this->reports[] = $report;
    }

    /**
     * @param array $proxies
     * @return void
     */
    public function run(array $proxies)
    {
        foreach ($this->reports as $report) {
            $report->run($proxies);
        }
    }
}