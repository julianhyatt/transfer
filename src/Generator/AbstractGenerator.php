<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Generator;

use Jellyfish\Transfer\Helper\FilesystemHelperInterface;
use Twig\Environment;

abstract class AbstractGenerator
{
    /**
     * @var string
     */
    protected const FILE_EXTENSION = '.php';

    /**
     * @param FilesystemHelperInterface $filesystem
     * @param Environment $twig
     * @param string $targetDirectory
     */
    public function __construct(
        protected FilesystemHelperInterface $filesystem,
        protected Environment $twig,
        protected string $targetDirectory
    ) {
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    protected function createDirectories(string $path)
    {
        if ($this->filesystem->exists($path)) {
            return $this;
        }

        $this->filesystem->mkdir($path, 0775);

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getTemplateName(): string;
}
