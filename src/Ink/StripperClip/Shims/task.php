<?php

use Ink\StripperClip\Console\Application;

function task($name, $callable) {
    $application = Application::getApplicationContext();
    $application->createTask($name, $callable);
}
