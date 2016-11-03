<?php
/**
 * User: 'Benjamin Leibinger'
 * Date: 01.11.2016 19:32
 */

namespace Isl\MemcachedBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class IslMemcachedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Check if the Memcache extension is loaded
        if (!extension_loaded('memcached')) {
            throw new \LogicException('Memcached extension is not loaded! To configure pools it MUST be loaded!');
        }

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('isl_memcached.pools_config', $config['pools']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}