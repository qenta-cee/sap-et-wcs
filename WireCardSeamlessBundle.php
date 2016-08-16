<?php

namespace WireCardSeamlessBundle;

use WireCardSeamlessBundle\DependencyInjection\WireCardSeamlessExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WireCardSeamlessBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
       parent::build($container);

       $WireCardSeamless = new WireCardSeamlessExtension();
       $container->registerExtension($WireCardSeamless);
       $container->loadFromExtension($WireCardSeamless->getAlias());
    }
}
