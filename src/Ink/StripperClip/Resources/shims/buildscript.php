<?php
use Ink\StripperClip\Console\Application;

function buildscript($callable) {
    $app = Application::getApplicationContext();
    $app->setBuildScriptAvailable($callable);
}
