StripperClip
============

StripperClip is a functional build scripting tool for PHP projects.

This project is still in development and does not have a stable release.

Installation
------------

Soon.

Configuration
-------------

The build file is configured in your project's `build.clip` file.

Example:

```php
<?php

task('clean', [], function(){
    remove('build');
    remove('vendor');
});

task('prepare', [], function() {
    createDirectory('build');
    createDirectory('vendor');
});

task(
    'install',
    [dependsOn => ['prepare'], description => 'Installs the project'],
    function() {
        composer('install');
    }
);
```
