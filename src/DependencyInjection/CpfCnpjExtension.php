<?php

namespace Dancos\Bundle\CpfCnpjBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CpfCnpjExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        // $loader->load('services.yaml');

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.xml');
    }
}
