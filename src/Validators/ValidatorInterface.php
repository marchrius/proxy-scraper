<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Validators;

use Vantoozz\ProxyScraper\Exceptions\ValidationException;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Interface ValidatorInterface
 * @package Vantoozz\ProxyScraper\Filters
 */
interface ValidatorInterface
{
    /**
     * @param Proxy $proxy
     * @return void
     * @throws ValidationException
     */
    public function validate(Proxy $proxy);
}
