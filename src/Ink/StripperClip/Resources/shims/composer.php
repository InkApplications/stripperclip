<?php

use Ink\StripperClip\Console\Application;

function composer($command) {
    $app = Application::getApplicationContext();
    $composer = $app->getService('stripperclip.operation.composer');
    $composer->run($command);
}
