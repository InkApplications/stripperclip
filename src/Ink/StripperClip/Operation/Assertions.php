<?php
/**
 * Assertions.php
 *
 * @copyright (c) 2014 Ink Applications LLC.
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Ink\StripperClip\Operation;

/**
 * Assertions
 *
 * Provides build assertions for the language.
 *
 * @todo These may need to be broken up into seperate services eventually
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class Assertions
{
    /**
     * Base Path
     *
     * @var string The current working build path
     */
    private $basePath;

    /**
     * Constructor
     *
     * @param string $buildDir The current working build path
     */
    public function __construct($buildDir)
    {
        $this->basePath = $buildDir;
    }

    /**
     * Assert Available
     *
     * Asserts that a binary executable is available to be invoked by the
     * build script.
     * This method provides a fallback, to attempt to run if the assertion
     * fails. Typically this can be used to attempt to acquire the necessary
     * executable.
     * If the executable is still not available after the fallback is executed,
     * the build script will be halted.
     *
     * @param string $bin The file path of the executable
     * @param callable $fallback The fallback callable to invoke if the
     *     executable is not found (optional)
     * @throws \RuntimeException If the assertion fails
     */
    public function assertAvailable($bin, $fallback = null)
    {
        if (file_exists($bin) && is_executable($bin)) {
            return;
        }

        if (null === $fallback) {
            throw new \RuntimeException('Executable file was not available');
        }

        call_user_func($fallback);

        if (file_exists($bin) && is_executable($bin)) {
            throw new \RuntimeException('Executable file was still not available after fallback');
        }
    }
} 
