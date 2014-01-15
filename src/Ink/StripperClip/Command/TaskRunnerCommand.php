<?php

namespace Ink\StripperClip\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskRunnerCommand extends Command
{
    private $callable;

    public function __construct($name, $callable)
    {
        parent::__construct($name);

        $this->callable = $callable;
    }
    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        call_user_func($this->callable);

        echo "\r\n[Task] {$this->getName()} successful \r\n";
    }
} 
