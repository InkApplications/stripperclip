<?php

namespace Ink\StripperClip;

use ErrorException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class StripperClip
{
    private $container;
    private $startTime;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        echo 'Loading...';
        $this->startTime = microtime(true);
        $this->initErrorHandler();

        $app = $this->getContainer()->get('stripperclip.application');
        $app->setAutoExit(false);
        $app->prepare();

        echo 'Done.';
        echo "\r\033[K";
        $app->run();

        $this->printRuntime();
    }

    protected function initErrorHandler()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline){
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    protected function buildDefaultContainer()
    {
        $container = new ContainerBuilder();
        $rootDir = __DIR__ . '/../../../';
        $resourcesDir = __DIR__ . '/Resources';
        $configDir = $resourcesDir . '/config';
        $container->setParameter('dir.resources', $resourcesDir);
        $container->setParameter('dir.root', $rootDir);
        $container->setParameter('dir.cwd', getcwd());
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

    protected function printRuntime()
    {
        $endTime = microtime(true);
        $time = $endTime - $this->startTime;
        printf("Total time: %01.2f secs \r\n", $time);
    }
} 
