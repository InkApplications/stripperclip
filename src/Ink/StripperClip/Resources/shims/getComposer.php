<?php

use Ink\StripperClip\Console\Application;

function getComposer() {
    $app = Application::getApplicationContext();
    $composer = $app->getService('stripperclip.operation.composer');
    $composer->downloadLatest();
}
