<?php
/**
 * StripperClip.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip;

use ErrorException;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * StripperClip
 *
 * Bootstrapper class for the application
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class StripperClip
{
    /**
     * Container
     *
     * @var ContainerInterface The application service container
     */
    private $container;

    /**
     * Start Time
     *
     * @var int The timestamp in microseconds that the application was started
     */
    private $startTime;

    /**
     * @param ContainerInterface $container The existing application service
     *     container (optional)
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Bootstrap
     *
     * Initializes the application and runs the console app
     */
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

    /**
     * Init Error Handler
     *
     * initializes the ErrorException conversion handler.
     */
    protected function initErrorHandler()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline){
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }

    /**
     * Build Default Container
     *
     * Builds a new application container in the case where none is provided.
     *
     * @return ContainerInterface An application service container
     */
    protected function buildDefaultContainer()
    {
        $container = new ContainerBuilder();
        $rootDir = __DIR__ . '/../../../';
        $resourcesDir = __DIR__ . '/Resources';
        $configDir = $resourcesDir . '/config';
        $container->setParameter('dir.resources', $resourcesDir);
        $container->setParameter('dir.root', $rootDir);
        $container->setParameter('dir.cwd', getcwd());
        $buildDir = getcwd() . '/build';
        if (false === file_exists($buildDir)) {
            mkdir($buildDir);
        }
        $container->setParameter('dir.build', $buildDir);
        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load('services.yml');

        return $container;
    }

    /**
     * Get Container
     *
     * Gets the application container if it is already set, if not it will
     * create a new one
     *
     * @return ContainerInterface The application service container
     * @see buildDefaultcontainer
     */
    final protected function getContainer()
    {
        if (null === $this->container) {
            $this->container = $this->buildDefaultContainer();
        }

        return $this->container;
    }

    /**
     * Print Runtime
     *
     * Outputs the application total runtime in seconds.
     */
    protected function printRuntime()
    {
        $endTime = microtime(true);
        $time = $endTime - $this->startTime;
        printf("Total time: %01.2f secs \r\n", $time);
    }
} 
