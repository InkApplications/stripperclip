<?php

namespace Ink\StripperClip\Command;

use Ink\StripperClip\DependencyResolver\Resolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskRunnerCommand extends Command
{
    const DEPENDENCY = 'dependsOn';
    const DESCRIPTION = 'description';
    private $callable;
    private $options;
    private $resolver;

    public function __construct(
        Resolver $resolver,
        $name,
        array $options,
        $callable
    ) {
        parent::__construct($name);

        $this->callable = $callable;
        $this->options = $options;
        $this->resolver = $resolver;

        if (array_key_exists(self::DESCRIPTION, $this->options)) {
            $this->setDescription($this->options[self::DESCRIPTION]);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>[Task:{$this->getName()}] Running</info>");
        $this->resolveDependencies();
        call_user_func($this->callable);

        $output->writeln("<info>[Task:{$this->getName()}] successful</info>");
    }

    public function resolveDependencies()
    {
        if (false === array_key_exists(self::DEPENDENCY, $this->options)) {
            return;
        }
        $this->resolver->resolve($this->options[self::DEPENDENCY]);
    }
} 
