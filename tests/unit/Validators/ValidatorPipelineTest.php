<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\UnitTests\Validators;

use PHPUnit\Framework\TestCase;
use Vantoozz\ProxyScraper\Ipv4;
use Vantoozz\ProxyScraper\Port;
use Vantoozz\ProxyScraper\Proxy;
use Vantoozz\ProxyScraper\Validators\CallbackValidator;
use Vantoozz\ProxyScraper\Validators\ValidatorPipeline;

/**
 * Class ValidatorPipelineTest
 * @package Vantoozz\ProxyScraper\UnitTests\Validators
 */
final class ValidatorPipelineTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws \Vantoozz\ProxyScraper\Exceptions\ValidationException
     */
    public function it_calls_all_steps()
    {
        $calls = 0;
        $pipeline = new ValidatorPipeline;
        $pipeline->addStep(new CallbackValidator(function () use (&$calls) {
            $calls++;
        }));
        $pipeline->addStep(new CallbackValidator(function () use (&$calls) {
            $calls++;
        }));
        $pipeline->validate(new Proxy(new Ipv4('127.0.0.1'), new Port(8888)));

        static::assertSame(2, $calls);
    }
}
