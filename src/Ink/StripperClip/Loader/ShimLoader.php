<?php

namespace Ink\StripperClip\Loader;

class ShimLoader
{
    private $shimsDirectory;

    public function __construct()
    {
        $this->shimsDirectory = dirname(__FILE__) . '/../Shims';
    }

    public function load()
    {
        require $this->shimsDirectory . '/constants.php';
        require $this->shimsDirectory . '/task.php';
        require $this->shimsDirectory . '/remove.php';
        require $this->shimsDirectory . '/createDirectory.php';
        require $this->shimsDirectory . '/copyFile.php';
        require $this->shimsDirectory . '/composer.php';
        require $this->shimsDirectory . '/bower.php';
        require $this->shimsDirectory . '/commandLine.php';
    }
} 
