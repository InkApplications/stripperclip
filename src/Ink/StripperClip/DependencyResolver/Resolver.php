<?php
/**
 * Resolver.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\DependencyResolver;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Resolver
 *
 * Handles running of tasks' dependencies before the task itself is run.
 * Will not run an individual dependency more than one time if multiple tasks in
 * the chain depend on it.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Resolver
{
    /**
     * Tasks Run
     *
     * This is to keep track of all of the tasks that have been run by one
     * dependency or another.
     *
     * @var array A list of the previously run task names
     */
    private $tasksRun = [];

    /**
     * Input
     *
     * Used when invoking dependencies.
     *
     * @var InputInterface The console input to use
     */
    private $input;

    /**
     * Output
     *
     * Used when invoking dependencies.
     *
     * @var OutputInterface The console output to use
     */
    private $output;

    /**
     * Application
     *
     * @var Application The console application to find the registered tasks
     */
    private $application;

    /**
     * Constructor
     *
     * @param Application $application The console application to find the
     *     registered tasks
     * @param InputInterface $input The interface to use for dependencies
     * @param OutputInterface $output The interface to use for dependencies
     */
    public function __construct(
        Application $application,
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->application = $application;
    }

    /**
     * Resolve
     *
     * Runs a collection of task dependencies, by name.
     *
     * @param array $dependencies The dependencies to run
     */
    public function resolve(array $dependencies)
    {
        foreach($dependencies as $dependency) {
            $this->runDependency($dependency);
        }
    }

    /**
     * Run Dependency
     *
     * Runs a single task by name. Will not run the task if it's already been
     * run.
     *
     * @param string $dependencyName The name of the command to run
     */
    protected function runDependency($dependencyName)
    {
        if (true === in_array($dependencyName, $this->tasksRun)) {
            return;
        }

        $command = $this->application->find($dependencyName);
        $command->run($this->input, $this->output);
        $this->tasksRun[] = $dependencyName;
    }
} 
