<?php

use Ink\StripperClip\Console\Application;

function assertAvailable($bin, $fallback = null)  {
    $app = Application::getApplicationContext();
    $remoteFile = $app->getService('stripperclip.operation.assertions');
    $remoteFile->assertAvailable($bin, $fallback);
}
