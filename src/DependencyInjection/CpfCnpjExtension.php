<?php

namespace Dancos\Bundle\CpfCnpjBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class CpfCnpjExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new \Symfony\Component\Config\FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.xml');
    }
}
