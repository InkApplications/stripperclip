<?php

namespace Ink\StripperClip\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskRunnerCommand extends Command
{
    const DEPENDENCY = 'dependsOn';
    const DESCRIPTION = 'description';
    private $callable;
    private $options;

    public function __construct($name, array $options, $callable)
    {
        parent::__construct($name);

        $this->callable = $callable;
        $this->options = $options;

        if (array_key_exists(self::DESCRIPTION, $this->options)) {
            $this->setDescription($this->options[self::DESCRIPTION]);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->resolveDependencies($input, $output);
        call_user_func($this->callable);

        $output->writeln("\r\n<info>[Task] {$this->getName()} successful</info>");
    }

    public function resolveDependencies(InputInterface $input, OutputInterface $output)
    {
        if (false === array_key_exists(self::DEPENDENCY, $this->options)) {
            return;
        }

        foreach($this->options[self::DEPENDENCY] as $dependency) {
            $command = $this->getApplication()->find($dependency);
            $command->run($input, $output);
        }
    }
} 
