<?php
/**
 * FileCopier.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Operation;

use Symfony\Component\Filesystem\Filesystem;

/**
 * File Copier
 *
 * A service for copying files. Adds the functionality to find and replace in
 * the copied files as well.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class FileCopier
{
    /**
     * File System
     *
     * @var Filesystem The symfony filesystem component to use for copy
     *     operations
     */
    private $filesystem;

    /**
     * Constructor
     *
     * @param Filesystem $filesystem The symfony filesystem component
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Copy
     *
     * Copies a file with the option to find/replace tokens.
     *
     * @param string $source the source file path
     * @param string $destination The destination file path
     * @param array $replace an array of key=>value to find and replace in the
     *     copied file (optional)
     */
    public function copy($source, $destination, array $replace = [])
    {
        $contents = file_get_contents($source);

        foreach ($replace as $searchStr => $replaceStr) {
            $contents = str_replace($searchStr, $replaceStr, $contents);
        }

        $this->filesystem->dumpFile($destination, $contents);
    }
} 
