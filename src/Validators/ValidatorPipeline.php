<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\Validators;

use Vantoozz\ProxyScraper\Exceptions\ValidationException;
use Vantoozz\ProxyScraper\Proxy;

/**
 * Class ValidatorPipeline
 * @package Vantoozz\ProxyScraper\Filters
 */
final class ValidatorPipeline implements ValidatorInterface
{
    /**
     * @var ValidatorInterface[]
     */
    private $steps = [];

    /**
     * @param ValidatorInterface $step
     * @return void
     */
    public function addStep(ValidatorInterface $step)
    {
        $this->steps[] = $step;
    }

    /**
     * @param Proxy $proxy
     * @return void
     * @throws ValidationException
     */
    public function validate(Proxy $proxy)
    {
        foreach ($this->steps as $step) {
            $step->validate($proxy);
        }
    }
}
