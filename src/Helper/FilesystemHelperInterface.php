<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Helper;

interface FilesystemHelperInterface
{
    /**
     * @param string $path
     * @param int $mode
     * @return FilesystemHelperInterface
     */
    public function mkdir(string $path, int $mode = 0777): FilesystemHelperInterface;

    /**
     * @param string $path
     * @return FilesystemHelperInterface
     */
    public function remove(string $path): FilesystemHelperInterface;

    /**
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool;

    /**
     * @param string $pathToFile
     * @param string $content
     * @return FilesystemHelperInterface
     */
    public function appendToFile(string $pathToFile, string $content): FilesystemHelperInterface;

    /**
     * @param string $pathToFile
     * @param string $content
     * @return FilesystemHelperInterface
     */
    public function writeToFile(string $pathToFile, string $content): FilesystemHelperInterface;

    /**
     * @param string $pathToFile
     *
     * @return string
     */
    public function readFromFile(string $pathToFile): string;
}
