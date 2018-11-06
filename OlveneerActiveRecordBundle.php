<?php

namespace Olveneer\ActiveRecordBundle;

use Olveneer\ActiveRecordBundle\DependencyInjection\Container;
use Olveneer\ActiveRecordBundle\DependencyInjection\ContainerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OlveneerActiveRecordBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new ContainerPass());
    }
}
