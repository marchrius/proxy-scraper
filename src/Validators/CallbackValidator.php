<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Validators;

use Vantoozz\ProxyScraper\Exceptions\ValidationException;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Class CallbackValidator
 * @package Vantoozz\ProxyScraper\Validators
 */
final class CallbackValidator implements ValidatorInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * CallbackValidator constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Proxy $proxy
     * @return void
     */
    public function validate(Proxy $proxy)
    {
        call_user_func($this->callback, $proxy);
    }
}
