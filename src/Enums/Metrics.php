<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Enums;

/**
 * Class Metrics
 * @package Vantoozz\ProxyScraper\Enums
 */
abstract class Metrics
{
    const AVAILABLE = 'available';
    const ANONYMITY = 'anonymity';
    const RESPONSE_TIME = 'response_time';
    const HTTPS = 'https';
}
