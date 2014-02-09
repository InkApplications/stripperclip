<?php

function bower($command) {
    $return = 0;
    passthru('bower ' . $command, $return);

    if ($return > 0) {
        throw new RuntimeException('Composer install failed');
    }
}
