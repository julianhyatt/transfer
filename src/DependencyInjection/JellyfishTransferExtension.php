<?php

namespace Jellyfish\Transfer\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class JellyfishTransferExtension extends Extension
{
    /**
     * @param array<array<mixed>> $configs
     * @param ContainerBuilder $container
     * @return void
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config'),
        );
        $loader->load('services.xml');

        $container->setParameter('jellyfish_transfer.namespace_prefix', $config['namespace_prefix']);
    }

    public function getAlias(): string
    {
        return 'jellyfish_transfer';
    }
}
