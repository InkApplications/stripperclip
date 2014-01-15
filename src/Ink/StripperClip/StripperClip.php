<?php

namespace Ink\StripperClip;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class StripperClip
{
    private $container;

    public function __construct(ContainerInterface $container = null)
    {
        if (null === $container) {
            $container = $this->buildDefaultContainer();
        }

        $this->container = $container;
    }

    public function run()
    {
        $app = $this->container->get('stripperclip.application');
        $app->run();
    }

    protected function buildDefaultContainer()
    {
        $container = new ContainerBuilder();
        $configDir = dirname(__FILE__) . '/Resources/config';
        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load('services.yml');

        return $container;
    }
} 
