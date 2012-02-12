<?php

namespace Mopa\BootstrapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Mopa\BootstrapBundle\DependencyInjection\Compiler\NavbarPass;

class MopaBootstrapBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NavbarPass());
    }
}
