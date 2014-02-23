<?php
/**
 * Application.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Console;

use Ink\StripperClip\Command\TaskRunnerCommand;
use Ink\StripperClip\Loader\VersionTagLoader;

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\RuntimeException;

/**
 * Application
 *
 * The main symfony console application.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Application extends ConsoleApplication
{
    /**
     * Application Context
     *
     * @var Application An instance Container for the current application
     */
    private static $applicationContext;

    /**
     * Container
     *
     * @var ContainerInterface The application Service Container
     */
    private $container;

    /**
     * Build Script Available
     *
     * @var callable the callable to invoke after the build script has been
     *     loaded.
     * @todo This should be a series of scripts/callables
     */
    private $buildScriptAvailable;

    /**
     * Logo
     *
     * @var string The application banner to be displayed on the info screen
     */
    private static $logo = '
   _____  __         _                            ______ __ _
  / ___/ / /_ _____ (_)____   ____   ___   _____ / ____// /(_)____
  \__ \ / __// ___// // __ \ / __ \ / _ \ / ___// /    / // // __ \
 ___/ // /_ / /   / // /_/ // /_/ //  __// /   / /___ / // // /_/ /
/____/ \__//_/   /_// .___// .___/ \___//_/    \____//_//_// .___/
                   /_/    /_/                             /_/
';

    /**
     * Constructor
     *
     * @param ContainerInterface $container The Service Container
     * @param VersionTagLoader $versionLoader Service for determining the
     *     application version number
     */
    public function __construct(
        ContainerInterface $container,
        VersionTagLoader $versionLoader
    ) {
        parent::__construct('StripperClip', $versionLoader->getVersion());
        $this->container = $container;
    }

    /**
     * Prepare
     *
     * Initialization for the stripperclip application.
     */
    public function prepare()
    {
        $this->loadBuildScript();

        if (null !== $this->buildScriptAvailable) {
            call_user_func($this->buildScriptAvailable);
        }
    }

    /**
     * Load Build Script
     *
     * Loads the shims, then the current working build script to load into the
     * application.
     */
    public function loadBuildScript()
    {
        self::$applicationContext = $this;
        $shimLoader = $this->getService('stripperclip.loader.shim');
        $shimLoader->load();

        $loader = $this->getService('stripperclip.loader.clip');
        $loader->load();
    }

    /**
     * Set Build Script Available
     *
     * Sets a build script to invoke before the application or any tasks are
     * run.
     *
     * @param callable $callable A callable script to invoke
     * @throws RuntimeException
     */
    public function setBuildScriptAvailable($callable) {
        if (false === is_callable($callable)) {
            throw new RuntimeException('buildscript must be passed a callable');
        }

        $this->buildScriptAvailable = $callable;
    }

    /**
     * Create Task
     *
     * Adds a new task to the command application
     *
     * @param string $name The name of the command
     * @param array $options Options to set on the task command
     * @param callable $callable The callable task to execute upon running
     * @see TaskRunnerCommand
     */
    public function createTask($name, array $options, $callable)
    {
        $resolver = $this->getService('stripperclip.dependency_resolver');
        $this->add(new TaskRunnerCommand($resolver, $name, $options, $callable));
    }

    /**
     * Get Service
     *
     * Fetches a service from thee application service container.
     *
     * @param string $name The name of the service to get
     * @return object The service fetched from the container
     */
    final public function getService($name)
    {
        return $this->container->get($name);
    }

    /**
     * Get Application Context
     *
     * @return Application An instance of the current application
     */
    public static function getApplicationContext()
    {
        return self::$applicationContext;
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        return self::$logo . parent::getHelp();
    }
}
