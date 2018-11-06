<?php
namespace Olveneer\ActiveRecordBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Container
{
    /**
     * @var ContainerInterface
     */
    static protected $container;

    public static function set(ContainerInterface $container)
    {
        self::$container = $container;
    }
}