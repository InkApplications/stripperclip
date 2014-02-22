<?php

namespace Ink\StripperClip\Operation;

class Assertions
{
    private $basePath;

    public function __construct($buildDir)
    {
        $this->basePath = $buildDir;
    }

    public function assertAvailable($bin, $fallback = null)
    {
        if (file_exists($bin) && is_executable($bin)) {
            return;
        }

        if (null === $fallback) {
            throw new \RuntimeException('Executable file was not available');
        }

        call_user_func($fallback);

        if (file_exists($bin) && is_executable($bin)) {
            throw new \RuntimeException('Executable file was still not available after fallback');
        }
    }
} 
