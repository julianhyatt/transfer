<?php

namespace Jellyfish\Transfer\Helper\Finder;

interface FinderHelperInterface
{
    /**
     * @param string[] $directories
     * @return FinderHelperInterface
     */
    public function in(array $directories): FinderHelperInterface;

    /**
     * @param string $pattern
     * @return FinderHelperInterface
     */
    public function name(string $pattern): FinderHelperInterface;

    /**
     * @param int $level
     * @return FinderHelperInterface
     */
    public function depth(int $level): FinderHelperInterface;

    /**
     * @return \Iterator
     */
    public function getIterator(): \Iterator;
}
