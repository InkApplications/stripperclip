<?php
/**
 * VersionTagLoader.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Loader;

/**
 * Version Tag Loader
 *
 * Determines the application version.
 * These versions are artifacts left by the build release server.
 * Will default to dev if no version artifact is found.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class VersionTagLoader
{
    /**
     * @var string The root directory of the stripperclip application
     */
    private $root;

    /**
     * Constructor
     *
     * @param string $root The root directory of the stripperclip application
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * Get Version
     *
     * @return string Gets the application version
     */
    public function getVersion()
    {
        $versionFile = $this->root . '/VERSION';

        if (false === file_exists($versionFile)) {
            return 'dev';
        }

        $contents = file_get_contents($versionFile);

        return $contents;
    }
} 
