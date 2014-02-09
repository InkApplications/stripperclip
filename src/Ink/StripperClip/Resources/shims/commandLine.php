<?php

function commandLine($command, $checkReturn = true) {
    $return = 0;
    passthru($command, $return);

    if (true === $checkReturn && $return > 0) {
        throw new RuntimeException('Command failed. Application exit code: ' . $return);
    }
}
