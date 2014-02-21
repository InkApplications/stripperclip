<?php

namespace Ink\StripperClip\Console;

use Ink\StripperClip\Command\TaskRunnerCommand;

use Ink\StripperClip\Loader\VersionTagLoader;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\RuntimeException;

class Application extends ConsoleApplication
{
    private static $applicationContext;
    private $container;
    private $buildScriptAvailable;

    private static $logo = '
   _____  __         _                            ______ __ _
  / ___/ / /_ _____ (_)____   ____   ___   _____ / ____// /(_)____
  \__ \ / __// ___// // __ \ / __ \ / _ \ / ___// /    / // // __ \
 ___/ // /_ / /   / // /_/ // /_/ //  __// /   / /___ / // // /_/ /
/____/ \__//_/   /_// .___// .___/ \___//_/    \____//_//_// .___/
                   /_/    /_/                             /_/
';

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct(
        ContainerInterface $container,
        VersionTagLoader $versionLoader
    ) {
        parent::__construct('StripperClip', $versionLoader->getVersion());
        $this->container = $container;
    }

    public function prepare()
    {
        $this->loadBuildScript();

        if (null !== $this->buildScriptAvailable) {
            call_user_func($this->buildScriptAvailable);
        }
    }

    public function getHelp()
    {
        return self::$logo . parent::getHelp();
    }

    public function loadBuildScript()
    {
        self::$applicationContext = $this;
        $shimLoader = $this->getService('stripperclip.loader.shim');
        $shimLoader->load();

        $loader = $this->getService('stripperclip.loader.clip');
        $loader->load();
    }

    public function setBuildScriptAvailable($callable) {
        if (false === is_callable($callable)) {
            throw new RuntimeException('buildscript must be passed a callable');
        }

        $this->buildScriptAvailable = $callable;
    }

    public function createTask($name, array $options, $callable)
    {
        $resolver = $this->getService('stripperclip.dependency_resolver');
        $this->add(new TaskRunnerCommand($resolver, $name, $options, $callable));
    }

    public function getService($name)
    {
        return $this->container->get($name);
    }

    public static function getApplicationContext()
    {
        return self::$applicationContext;
    }
}
