<?php

use Ink\StripperClip\Console\Application;

function task($name, $options, $callable) {
    $application = Application::getApplicationContext();
    $application->createTask($name, $options, $callable);
}
