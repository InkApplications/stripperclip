<?php
/**
 * stub.php
 *
 * A PHP phar stub to load the executable application.
 *
 * @license MIT <http://opensource.org/licenses/MIT>
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
Phar::mapPhar('stripperclip.phar');

include 'phar://stripperclip.phar/bin/stripperclip.php';

__HALT_COMPILER();
