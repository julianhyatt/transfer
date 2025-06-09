<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Codeception\Test\Unit;
use Iterator;
use Jellyfish\Transfer\Helper\FinderHelperInterface;
use Symfony\Component\Finder\Finder;

class DefinitionFinderTest extends Unit
{
    /**
     * @var \Jellyfish\Transfer\Definition\DefinitionFinder
     */
    protected ?DefinitionFinder $definitionFinder;

    /**
     * @var string
     */
    protected string $rootDir;

    /**
     * @var FinderHelperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderMock;

    /**
     * @var \Iterator|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $iteratorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->finderMock = $this->getMockBuilder(FinderHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rootDir = '/';

        $this->definitionFinder = new DefinitionFinder($this->finderMock, $this->rootDir);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->finderMock->expects(static::atLeastOnce())
            ->method('in')
            ->with([
                'src/*/*/Transfer/',
                'packages/*/src/*/*/Transfer/',
                'vendor/*/*/src/*/*/Transfer/',
                'vendor/*/*/packages/*/src/*/*/Transfer/'
            ])->willReturn($this->finderMock);

        $this->finderMock->expects(static::atLeastOnce())
            ->method('name')
            ->with('*.transfer.json')
            ->willReturn($this->finderMock);

        $this->finderMock->expects(static::atLeastOnce())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        $iterator = $this->definitionFinder->find();

        static::assertEquals($this->iteratorMock, $iterator);
    }
}
