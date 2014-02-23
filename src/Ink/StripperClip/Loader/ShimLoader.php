<?php
/**
 * ShimLoader.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Loader;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Shim Loader
 *
 * Used to load the build language shims needed to run build clip files.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class ShimLoader
{
    /**
     * @var string The directory to load language shims from
     */
    private $shimsDirectory;

    /**
     * Finder
     *
     * @var Finder The symfony file finder service
     */
    private $finder;

    /**
     * Constructor
     *
     * @param Finder $finder The symfony file finder service
     * @param string $shimsDirectory The directory to load language shims from
     */
    public function __construct(Finder $finder, $shimsDirectory)
    {
        $this->finder = $finder;
        $this->shimsDirectory = $shimsDirectory;
    }

    /**
     * Load
     *
     * Initiates the loading of all needed build language shim files
     */
    public function load()
    {
        $files = $this->finder->files()->in($this->shimsDirectory);

        foreach ($files as $file) {
            $this->loadFile($file);
        }
    }

    /**
     * Load File
     *
     * Loads an individual file into the runtime.
     *
     * @param SplFileInfo $file The file to load into runtime.
     */
    protected function loadFile(SplFileInfo $file)
    {
        $path = $this->shimsDirectory . $file->getRelativePath() . '/' . $file->getFilename();

        require $path;
    }
} 
