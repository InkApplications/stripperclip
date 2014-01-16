<?php

use Ink\StripperClip\Console\Application;

function createDirectory($name, $mode = 0777) {
    $app = Application::getApplicationContext();
    $fileSystem = $app->getService('filesystem');
    $fileSystem->mkdir($name, $mode);
}
