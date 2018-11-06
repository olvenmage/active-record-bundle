<?php

namespace Olveneer\ActiveRecordBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ContainerPass  implements CompilerPassInterface
{
    /**
     * Registers all services with the 'olveneer.component' tag as valid components.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $containerService = $container->findDefinition(Container::class);
        
        $containerService->addMethodCall('set', [new Reference('service_container')]);
    }
}