<?php
/**
 * RemoteFile.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Operation;

/**
 * Remote File
 *
 * Provides remote file operations.
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class RemoteFile
{
    /**
     * @var string The workspace for the build script
     */
    private $workspacePath;

    /**
     * Constructor
     *
     * @param string $workspacePath The base workspace path of the build script
     */
    public function __construct($workspacePath)
    {
        $this->workspacePath = $workspacePath;
    }

    /**
     * Make Available
     *
     * Makes a remote file, by url, available to the build script.
     *
     * @param string $url The url of the file to fetch
     * @throws \RuntimeException
     */
    public function makeAvailable($url)
    {
        $fileName = $this->getFileDestination($url);
        $fh = fopen($fileName, 'w');

        if (!$fh) {
            throw new \RuntimeException('Could not create file ' . $fileName . ': error');
        }
        if (false === fwrite($fh, file_get_contents($url))) {
            throw new \RuntimeException('Download failed: error');
        }
    }

    /**
     * Make Available and Execute
     *
     * Makes a remote file, by url, available to the build script.
     * After the file has been available, it executes it.
     *
     * @param string $url The url of the file to fetch
     */
    public function makeAvailableAndExecute($url)
    {
        $this->makeAvailable($url);

        $fileName = $this->getFileDestination($url);
        exec($fileName);
    }

    /**
     * Execute Remote PHP
     *
     * Makes a php executable file available to the build script, executes it,
     * then cleans up the file.
     *
     * @param string $url the URL of the remote PHP file to execute
     */
    public function executeRemotePhp($url)
    {
        $this->makeAvailable($url);
        $fileName = $this->getFileDestination($url);

        passthru('php ' . $fileName);
        remove($fileName);
    }

    /**
     * Get File Destination
     *
     * @param string $url The url to get the file destination for
     * @return string The workspace file location
     */
    final protected function getFileDestination($url)
    {
        return $this->workspacePath . '/' . basename($url);
    }
} 
