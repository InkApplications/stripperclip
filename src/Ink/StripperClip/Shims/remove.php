<?php

use Ink\StripperClip\Console\Application;
use Symfony\Component\Filesystem\Filesystem;

function remove($name) {
    $fs = new Filesystem();
    $fs->remove($name);
}
