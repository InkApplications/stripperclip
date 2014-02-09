<?php

use Ink\StripperClip\Console\Application;

function copyFile($source, $destination, array $replace = []) {
    $app = Application::getApplicationContext();
    $fileCopy = $app->getService('stripperclip.operation.file_copier');
    $fileCopy->copy($source, $destination, $replace);
}
