<?php

namespace Ink\StripperClip\Operation;

use Symfony\Component\Filesystem\Filesystem;

class FileCopier
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function copy($source, $destination, array $replace = [])
    {
        $contents = file_get_contents($source);

        foreach ($replace as $searchStr => $replaceStr) {
            $contents = str_replace($searchStr, $replaceStr, $contents);
        }

        $this->filesystem->dumpFile($destination, $contents);
    }
} 
