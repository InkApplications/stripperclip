<?php

use Ink\StripperClip\Console\Application;

function remove($name) {
    $app = Application::getApplicationContext();
    $fileSystem = $app->getService('filesystem');
    $fileSystem->remove($name);
}
