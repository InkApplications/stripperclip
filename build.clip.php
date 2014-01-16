<?php

task('clean', [], function(){
    remove('build');
    remove('vendor');
});

task('prepare', [], function() {
    createDirectory('build');
    createDirectory('vendor');
});

task('install', [dependsOn => ['prepare']], function() {
    composer('install');
});

task('compile', [dependsOn => ['install']], function() {
    commandLine("phar pack -f build/clip.phar -s .phar/stub.php -b '/usr/bin/env php' .");
});

