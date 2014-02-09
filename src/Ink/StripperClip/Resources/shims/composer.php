<?php

function composer($command) {
    $return = 0;
    passthru('composer.phar ' . $command, $return);

    if ($return > 0) {
        throw new RuntimeException('Composer install failed');
    }
}
