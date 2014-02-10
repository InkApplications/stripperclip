<?php

namespace Ink\StripperClip\Loader;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ClipFileLoader
{
    private $input;
    private $output;
    private $finder;
    private $directory;

    public function __construct(
        Finder $finder,
        $directory,
        InputInterface $input,
        OutputInterface $outputInterface
    ) {
        $this->finder = $finder;
        $this->directory = $directory;
        $this->input = $input;
        $this->output = $outputInterface;
    }

    public function load()
    {
        $clipFileSignature = '*.clip.php';
        $files = $this->finder->files();
        $files->in($this->directory)->name($clipFileSignature);

        foreach ($files as $clipFile) {
            $this->loadFile($clipFile);
        }

        $loadedFiles = $files->count();
        $this->writeFileCount($loadedFiles);
    }

    protected function writeFileCount($count)
    {
        if (0 === $count) {
            $this->output->write("\r\033[K");
            $this->output->writeln('<error>No clip files were found</error>');
        } else {
            $this->output->write("\r\033[K");
            $this->output->writeln('<info>Loaded ' . $count . ' Clip Files</info>');
        }
    }

    protected function loadFile(SplFileInfo $file)
    {
        require $file->getRealPath();
    }
} 
