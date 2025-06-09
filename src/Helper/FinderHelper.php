<?php

namespace Jellyfish\Transfer\Helper;

use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

class FinderHelper implements FinderHelperInterface
{
    /**
     * @param Finder $symfonyFinder
     */
    public function __construct(protected Finder $symfonyFinder)
    {
    }

    /**
     * @param string[] $directories
     * @return FinderHelperInterface
     */
    public function in(array $directories): FinderHelperInterface
    {
        foreach ($directories as $directory) {
            try {
                $this->symfonyFinder->in($directory);
            } catch (DirectoryNotFoundException $directoryNotFoundException) {
            }
        }

        return $this;
    }

    /**
     * @param string $pattern
     * @return FinderHelperInterface
     */
    public function name(string $pattern): FinderHelperInterface
    {
        $this->symfonyFinder->name($pattern);

        return $this;
    }

    /**
     * @param int $level
     * @return FinderHelperInterface
     */
    public function depth(int $level): FinderHelperInterface
    {
        $this->symfonyFinder->depth($level);

        return $this;
    }

    /**
     * @return \Iterator
     */
    public function getIterator(): \Iterator
    {
        return $this->symfonyFinder->getIterator();
    }
}
