<?php

namespace LongitudeOne\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SettingsExtension extends Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
//        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
//        $loader->load('settings.yaml');

//        $configuration = $this->getConfiguration($configs, $container);
//        $config = $this->processConfiguration($configuration, $configs);
    }
}