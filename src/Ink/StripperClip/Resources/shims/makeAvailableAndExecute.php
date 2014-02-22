<?php

use Ink\StripperClip\Console\Application;

function makeAvailableAndExecute($url)  {
    $app = Application::getApplicationContext();
    $remoteFile = $app->getService('stripperclip.operation.remote_file');
    $remoteFile->makeAvailableAndExecute($url);
}
