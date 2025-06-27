<?php

namespace Jellyfish\Transfer\Helper\Finder;

interface FinderFacadeInterface
{
    /**
     * @return FinderHelperInterface
     */
    public function createFinder(): FinderHelperInterface;
}
