<?php

use Ink\StripperClip\Console\Application;

function makeAvailable($url)  {
    $app = Application::getApplicationContext();
    $remoteFile = $app->getService('stripperclip.operation.remote_file');
    $remoteFile->makeAvailable($url);
}
