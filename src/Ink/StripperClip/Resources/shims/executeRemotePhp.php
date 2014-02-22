<?php

use Ink\StripperClip\Console\Application;

function executeRemotePhp($url)  {
    $app = Application::getApplicationContext();
    $remoteFile = $app->getService('stripperclip.operation.remote_file');
    $remoteFile->executeRemotePhp($url);
}
