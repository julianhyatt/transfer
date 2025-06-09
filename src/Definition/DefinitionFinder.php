<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Iterator;
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
     * @param FinderHelperInterface $finder
     * @param string $rootDir
     */
    public function __construct(
        protected FinderHelperInterface $finder,
        protected string $rootDir
    ) {
    }

    /**
     * @return \Iterator
     */
    public function find(): Iterator
    {
        return $this->finder->in(static::IN_PATTERNS)
            ->name(static::NAME_PATTERN)
            ->getIterator();
    }
}
