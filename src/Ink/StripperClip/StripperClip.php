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
        $this->container = $container;
    }

    public function run()
    {
        echo 'Loading...';

        $app = $this->getContainer()->get('stripperclip.application');
        $app->prepare();

        echo 'Done.';
        echo "\r\033[K";
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

    protected final function getContainer()
    {
        if (null === $this->container) {
            $this->container = $this->buildDefaultContainer();
        }

        return $this->container;
    }
} 
