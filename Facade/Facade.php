<?php
namespace Olveneer\ActiveRecordBundle\Facade;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Facade
{
    /**
     * @var ContainerInterface
     */
    static protected $container;

    private static function set(ContainerInterface $container)
    {
        self::$container = $container;
    }

    protected static function get()
    {
        if (!self::$container) {
            global $kernel;

            if ($kernel instanceof KernelInterface) {
                self::$container = $kernel->getContainer();
            }
        }

        return self::$container;
    }

    protected static function abstractMirror($obj)
    {
        return call_user_func([$obj, debug_backtrace()[1]['function']], ...debug_backtrace()[1]['args']);
    }
}