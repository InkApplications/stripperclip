<?php

namespace Ink\StripperClip\Console;

use Ink\StripperClip\Command\TaskRunnerCommand;
use Ink\StripperClip\ShimLoader;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends ConsoleApplication
{
    private static $applicationContext;
    private $workingDirectory;
    private $shimLoader;

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
    public function __construct(ShimLoader $shimLoader, $version)
    {
        parent::__construct('StripperClip', $version);
        $this->workingDirectory = getcwd();
        $this->shimLoader = $shimLoader;
    }

    public function prepare()
    {
        $this->loadBuildScript();
    }

    public function getHelp()
    {
        return self::$logo . parent::getHelp();
    }

    public function loadBuildScript()
    {
        self::$applicationContext = $this;
        $this->shimLoader->loadShims();
        require $this->workingDirectory . '/build.clip';
    }

    public function createTask($name, array $options, $callable)
    {
        $this->add(new TaskRunnerCommand($name, $options, $callable));
    }

    public static function getApplicationContext()
    {
        return self::$applicationContext;
    }
}
