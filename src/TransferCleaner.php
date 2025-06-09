<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

use Jellyfish\Transfer\Helper\FilesystemHelperInterface;
use Jellyfish\Transfer\Helper\FinderHelperInterface;
use SplFileInfo;

use function is_string;

class TransferCleaner implements TransferCleanerInterface
{
    /**
     * @param FinderHelperInterface $finder
     * @param FilesystemHelperInterface $filesystem
     * @param string $targetDirectory
     */
    public function __construct(
        protected FinderHelperInterface $finder,
        protected FilesystemHelperInterface $filesystem,
        protected string $targetDirectory
    ) {
    }

    /**
     * @return \Jellyfish\Transfer\TransferCleanerInterface
     */
    public function clean(): TransferCleanerInterface
    {
        if (!$this->canClean()) {
            return $this;
        }

        return $this->cleanDirectory($this->targetDirectory);
    }

    /**
     * @return bool
     */
    protected function canClean(): bool
    {
        return $this->filesystem->exists($this->targetDirectory);
    }

    /**
     * @param string $directory
     *
     * @return \Jellyfish\Transfer\TransferCleanerInterface
     */
    protected function cleanDirectory(string $directory): TransferCleanerInterface
    {
        $iterator = $this->finder->in([$directory])
            ->depth(0)
            ->getIterator();

        foreach ($iterator as $item) {
            if (!($item instanceof SplFileInfo) || !is_string($item->getRealPath())) {
                continue;
            }

            $itemRealPath = $item->getRealPath();

            if ($item->isDir()) {
                $this->cleanDirectory($itemRealPath);
            }

            $this->filesystem->remove($itemRealPath);
        }

        return $this;
    }
}
