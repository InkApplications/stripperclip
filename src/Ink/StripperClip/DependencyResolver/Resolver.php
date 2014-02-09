<?php

namespace Ink\StripperClip\DependencyResolver;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Resolver
{
    private $tasksRun = [];

    public function __construct(
        Application $application,
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->application = $application;
    }

    public function resolve(array $dependencies)
    {
        foreach($dependencies as $dependency) {
            $this->runDependency($dependency);
        }
    }

    protected function runDependency($dependencyName)
    {
        if (false === in_array($dependencyName, $this->tasksRun)) {
            return;
        }

        $command = $this->application->find($dependencyName);
        $command->run($this->input, $this->output);
    }
} 
