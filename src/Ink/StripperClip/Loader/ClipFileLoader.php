<?php
/**
 * ClipFileLoader.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Loader;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * ClipFile Loader
 *
 * Loads the necessary clip build files into the current application context.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class ClipFileLoader
{
    /**
     * Input
     *
     * @var InputInterface The console input to use
     */
    private $input;

    /**
     * Output
     *
     * @var OutputInterface The console output to use
     */
    private $output;

    /**
     * Finder
     *
     * @var Finder The symfony file finder service
     */
    private $finder;

    /**
     * Directory
     *
     * @var string The current working directory to start looking for clip
     *     files in
     */
    private $directory;

    /**
     * Constructor
     *
     * @param Finder $finder The symfony file finder service
     * @param string $directory The current working directory to start looking
     *     for clip files in
     * @param InputInterface $input The console input to use
     * @param OutputInterface $outputInterface The console output to use
     */
    public function __construct(
        Finder $finder,
        $directory,
        InputInterface $input,
        OutputInterface $outputInterface
    ) {
        $this->finder = $finder;
        $this->directory = $directory;
        $this->input = $input;
        $this->output = $outputInterface;
    }

    /**
     * Load
     *
     * Initiates the loading of clip files. Loads all files matching
     * `*.clip.php` in the file path.
     */
    public function load()
    {
        $clipFileSignature = '*.clip.php';
        $files = $this->finder->files();
        $files->in($this->directory)->name($clipFileSignature);

        foreach ($files as $clipFile) {
            $this->loadFile($clipFile);
        }

        $loadedFiles = $files->count();
        $this->writeFileCount($loadedFiles);
    }

    /**
     * Write File Count
     *
     * Outputs the number of clip files that were loaded by the file loader
     * to the output interface provided.
     *
     * @param int $count The number of files that were loaded
     */
    protected function writeFileCount($count)
    {
        if (0 === $count) {
            $this->output->write("\r\033[K");
            $this->output->writeln('<error>No clip files were found</error>');
        } else {
            $this->output->write("\r\033[K");
            $this->output->writeln('<info>Loaded ' . $count . ' Clip Files</info>');
        }
    }

    /**
     * Load File
     *
     * Requires a file into the current runtime.
     *
     * @param SplFileInfo $file Loads an individual file into runtime
     */
    protected function loadFile(SplFileInfo $file)
    {
        require $file->getRealPath();
    }
} 
