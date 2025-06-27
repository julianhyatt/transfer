<?php

namespace Jellyfish\Transfer\Helper\Finder;

use Symfony\Component\Finder\Finder;

class FinderFactory
{
    /**
     * @return FinderHelperInterface
     */
    public function createFinder(): FinderHelperInterface
    {
        return new FinderHelper($this->createSymfonyFinder());
    }

    /**
     * @return Finder
     */
    protected function createSymfonyFinder(): Finder
    {
        return new Finder();
    }
}
