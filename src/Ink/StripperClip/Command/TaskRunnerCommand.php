<?php
/**
 * TaskRunnerCommand.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Command;

use Ink\StripperClip\DependencyResolver\Resolver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Task Runner Command
 *
 * This is the class that a user's `task()` definitions will be created with.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class TaskRunnerCommand extends Command
{
    /**
     * Dependency Key
     *
     * The Options key for defining what other tasks should be run before the
     * current task is run.
     *
     * @var string Options key for defining dependencies
     */
    const DEPENDENCY = 'dependsOn';

    /**
     * Description Key
     *
     * The Options Key for defining what description should be set on the user
     * defined task.
     */
    const DESCRIPTION = 'description';

    /**
     * Callable
     *
     * This stores the callable function that the user defined for the task to
     * be run on execution.
     *
     * @var callable The task callable
     */
    private $callable;

    /**
     * Options
     *
     * The user defined options for the task that was defined.
     *
     * @var array Key => Value pairs of options to be set for the task
     */
    private $options;

    /**
     * Resolver
     *
     * The resolver is used to find the tasks that are defined as dependencies
     * and need to be run before this task.
     *
     * @var Resolver The Task Dependency Resolver to use
     */
    private $resolver;

    /**
     * Constructor
     *
     * @param Resolver $resolver The Task Dependency Resolver to use
     * @param string $name The Name of the task to be defined
     * @param array $options The configuration options to be defined
     * @param callable $callable The callable task to execute
     */
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

    /**
     * Resolve Dependencies
     *
     * Invokes the dependency resolver for the current task to run the tasks
     * that must be run before execution of the current task.
     */
    public function resolveDependencies()
    {
        if (false === array_key_exists(self::DEPENDENCY, $this->options)) {
            return;
        }
        $this->resolver->resolve($this->options[self::DEPENDENCY]);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>[Task:{$this->getName()}] Running</info>");
        $this->resolveDependencies();
        call_user_func($this->callable);

        $output->writeln("<info>[Task:{$this->getName()}] successful</info>");
    }
} 
