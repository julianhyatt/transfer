<?php

namespace Jellyfish\Transfer\Helper\Finder;

class FinderFacade implements FinderFacadeInterface
{
    public function __construct(protected FinderFactory $finderFactory)
    {
    }

    /**
     * @return FinderHelperInterface
     */
    public function createFinder(): FinderHelperInterface
    {
        return ($this->finderFactory->createFinder());
    }
}
