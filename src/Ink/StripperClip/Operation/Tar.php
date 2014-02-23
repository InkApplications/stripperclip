<?php
/**
 * Tar.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Operation;

use Archive_Tar;

use Symfony\Component\Finder\Finder;

/**
 * Tar
 *
 * Provides Tar creation operations for the build scripts
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Tar
{
    /**
     * @var Finder Symfony file finder service
     */
    private $finder;

    /**
     * Constructor
     *
     * @param Finder $filesystem The Symfony file finder service
     */
    public function __construct(Finder $filesystem)
    {
        $this->finder = $filesystem;
    }

    /**
     * Create Tar
     *
     * Creates a tar archive of a directory with the option to exclude files and
     * compress the archive.
     *
     * @param string $destination The destination of the tar file
     * @param string $root The directory to compress
     * @param array $exclude A collection of files and directories to exclude
     * @param null $compression The compression type of the output can be
     *     `gz` or `bz2` (optional)
     */
    public function createTar($destination, $root, array $exclude = [], $compression = null)
    {
        $tar = new Archive_Tar($destination, $compression);
        $files = $this->finder->files()->in($root);

        foreach ($exclude as $excludePath) {
            $files->notPath($excludePath);
        }

        $fileArr = iterator_to_array($files);
        $tar->add($fileArr);
    }
} 
