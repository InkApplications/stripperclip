<?php

namespace Ink\StripperClip\Loader;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ShimLoader
{
    private $shimsDirectory;
    private $finder;

    public function __construct(Finder $finder, $shimsDirectory)
    {
        $this->finder = $finder;
        $this->shimsDirectory = $shimsDirectory;
    }

    public function load()
    {
        $files = $this->finder->files()->in($this->shimsDirectory);

        foreach ($files as $file) {
            $this->loadFile($file);
        }
    }

    protected function loadFile(SplFileInfo $file)
    {
        $path = $file->getRealPath();

        require $path;
    }
} 
