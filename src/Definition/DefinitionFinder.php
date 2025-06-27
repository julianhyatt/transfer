<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Iterator;
use Jellyfish\Transfer\Helper\Finder\FinderFacadeInterface;
use Jellyfish\Transfer\Helper\FinderHelperInterface;

class DefinitionFinder implements DefinitionFinderInterface
{
    /**
     * @var string
     */
    protected const NAME_PATTERN = '*.transfer.json';

    /**
     * @var array<string>
     */
    protected const IN_PATTERNS = [
        'src/Transfer/',
        'src/*/Transfer/',
        'src/*/*/Transfer/',
        'packages/*/src/*/*/Transfer/',
        'vendor/*/*/src/*/*/Transfer/',
        'vendor/*/*/packages/*/src/*/*/Transfer/',
    ];

    /**
     * @param FinderFacadeInterface $finderFacade
     * @param string $rootDir
     */
    public function __construct(
        protected FinderFacadeInterface $finderFacade,
        protected string $rootDir
    ) {
    }

    /**
     * @return \Iterator
     */
    public function find(): Iterator
    {
        return $this->finderFacade->createFinder()->in(static::IN_PATTERNS)
            ->name(static::NAME_PATTERN)
            ->getIterator();
    }
}
