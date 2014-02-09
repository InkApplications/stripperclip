<?php

namespace Ink\StripperClip\Loader;

class VersionTagLoader
{
    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function getVersion()
    {
        $versionFile = $this->root . '/VERSION';

        if (false === file_exists($versionFile)) {
            return 'dev';
        }

        $contents = file_get_contents($versionFile);

        return $contents;
    }
} 
