<?php
/**
 * Composer.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Operation;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Composer
 *
 * Provides operations interacting with composer including a way to download
 * composer and make it available before executing commands with it.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Composer
{
    /**
     * Output
     *
     * @var OutputInterface Console output
     */
    private $output;

    /**
     * Bin Directory
     *
     * @var string The directory where project binaries are to be stored
     */
    private $binDirectory;

    /**
     * Composer Bin
     *
     * This is the path of the composer binary as we will make it available,
     * based off of the application binary directory.
     *
     * @var string The path where composer is/will be stored
     */
    private $composerBin;

    /**
     * Remote File
     *
     * Used to install composer
     *
     * @var RemoteFile Service for remote file operations
     */
    private $remoteFile;

    /**
     * Constructor
     *
     * @param string $binDirectory The directory where project binaries are to
     *     be stored
     * @param RemoteFile $remoteFile Service for remote file operations
     * @param OutputInterface $output Console output
     */
    public function __construct($binDirectory, RemoteFile $remoteFile, OutputInterface $output)
    {
        $this->binDirectory = $binDirectory;
        $this->composerBin = $binDirectory . '/composer';
        $this->remoteFile = $remoteFile;
        $this->output = $output;
    }

    /**
     * Download Latest
     *
     * Fetches the latest version of composer and makes it available in the
     * application binary directory.
     */
    public function downloadLatest()
    {
        if ($this->isAvailable()) {
            return;
        }

        $this->output->writeln('<info>Downloading Composer</info>');

        $this->remoteFile->executeRemotePhp(
            'https://getcomposer.org/installer',
            ' -- --install-dir=bin --filename=composer'
        );
    }

    /**
     * Run
     *
     * Runs a composer command directly to the composer bin file
     *
     * @param string $command The composer command to run
     * @throws \RuntimeException If the composer command fails
     */
    public function run($command)
    {
        $return = 0;
        passthru($this->composerBin . ' ' . $command, $return);

        if ($return > 0) {
            throw new \RuntimeException('Composer command failed');
        }
    }

    /**
     * Is Available
     *
     * Checks to see if a copy of composer is available.
     *
     * @return bool Whether the composer binary is available
     */
    final public function isAvailable()
    {
        return file_exists($this->composerBin);
    }
} 
