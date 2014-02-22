<?php

namespace Ink\StripperClip\Operation;

class RemoteFile
{
    private $basePath;

    public function __construct($buildDir)
    {
        $this->basePath = $buildDir;
    }

    public function makeAvailable($url)
    {
        $fileName = $this->getFilePath($url);
        $fh = fopen($fileName, 'w');

        if (!$fh) {
            throw new \RuntimeException('Could not create file ' . $fileName . ': error');
        }
        if (false === fwrite($fh, file_get_contents($url))) {
            throw new \RuntimeException('Download failed: error');
        }
    }

    public function makeAvailableAndExecute($url)
    {
        $this->makeAvailable($url);

        $fileName = $this->getFilePath($url);
        exec($fileName);
    }

    public function executeRemotePhp($url)
    {
        $this->makeAvailable($url);
        $fileName = $this->getFilePath($url);

        passthru('php ' . $fileName);
        remove($fileName);
    }

    final protected function getFilePath($url)
    {
        return $this->basePath . '/' . basename($url);
    }
} 
