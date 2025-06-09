<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Helper;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

use function file_get_contents;
use function file_put_contents;
use function sprintf;

class FilesystemHelper implements FilesystemHelperInterface
{
    /**
     * @param SymfonyFilesystem $symfonyFilesystem
     */
    public function __construct(protected SymfonyFilesystem $symfonyFilesystem)
    {
    }

    /**
     * @param string $path
     * @param int $mode
     * @return FilesystemHelperInterface
     */
    public function mkdir(string $path, int $mode = 0777): FilesystemHelperInterface
    {
        $this->symfonyFilesystem->mkdir($path, $mode);

        return $this;
    }

    /**
     * @param string $path
     * @return FilesystemHelperInterface
     */
    public function remove(string $path): FilesystemHelperInterface
    {
        $this->symfonyFilesystem->remove($path);

        return $this;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool
    {
        return $this->symfonyFilesystem->exists($path);
    }

    /**
     * @param string $pathToFile
     * @param string $content
     * @return FilesystemHelperInterface
     */
    public function appendToFile(string $pathToFile, string $content): FilesystemHelperInterface
    {
        if (false === @file_put_contents($pathToFile, $content, FILE_APPEND)) {
            throw new IOException(sprintf('Failed to write file "%s".', $pathToFile), 0, null, $pathToFile);
        }

        return $this;
    }

    /**
     * @param string $pathToFile
     * @param string $content
     * @return FilesystemHelperInterface
     */
    public function writeToFile(string $pathToFile, string $content): FilesystemHelperInterface
    {
        if (false === @file_put_contents($pathToFile, $content)) {
            throw new IOException(sprintf('Failed to write file "%s".', $pathToFile), 0, null, $pathToFile);
        }

        return $this;
    }

    /**
     * @param string $pathToFile
     *
     * @return string
     */
    public function readFromFile(string $pathToFile): string
    {
        $fileContent = @file_get_contents($pathToFile);

        if (false === $fileContent) {
            throw new IOException(sprintf('Failed to read file "%s".', $pathToFile), 0, null, $pathToFile);
        }

        return $fileContent;
    }
}
