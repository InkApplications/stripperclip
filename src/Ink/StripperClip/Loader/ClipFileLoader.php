<?php

namespace Ink\StripperClip\Loader;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClipFileLoader
{
    private $input;
    private $output;

    public function __construct(InputInterface $input, OutputInterface $outputInterface)
    {
        $this->input = $input;
        $this->output = $outputInterface;
    }

    public function load($clipFile)
    {
        if (false === file_exists($clipFile)) {
            $this->onFileMissing();
            return;
        }

        require $clipFile;
    }

    protected function onFileMissing()
    {
        $this->output->write("\r\033[K");
        $this->output->writeln('<error>Could not find build.clip file</error>');
    }
} 
