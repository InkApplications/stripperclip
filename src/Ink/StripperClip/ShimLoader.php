<?php

namespace Ink\StripperClip;

use Ink\StripperClip\Console\Application;

class ShimLoader
{
    private $shimsDirectory;

    public function __construct()
    {
        $this->shimsDirectory = dirname(__FILE__) . '/Shims';
    }

    public function loadShims()
    {
        require $this->shimsDirectory . '/constants.php';
        require $this->shimsDirectory . '/task.php';
        require $this->shimsDirectory . '/remove.php';
    }
} 
