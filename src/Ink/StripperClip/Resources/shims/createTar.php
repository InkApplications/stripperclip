<?php

use Ink\StripperClip\Console\Application;

function createTar($destination, $files, $exclude = [])  {
    $app = Application::getApplicationContext();
    $tar = $app->getService('stripperclip.operation.tar');
    $tar->createTar($destination, $files, $exclude);
}
