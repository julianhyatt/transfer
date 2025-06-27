<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Codeception\Test\Unit;
use Iterator;
use Jellyfish\Transfer\Helper\Finder\FinderFacadeInterface;
use Jellyfish\Transfer\Helper\Finder\FinderHelperInterface;
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
     * @var \Jellyfish\Transfer\Helper\Finder\FinderHelperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderMock;

    /**
     * @var FinderFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderFacadeMock;

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

        $this->finderFacadeMock = $this->getMockBuilder(FinderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rootDir = '/';

        $this->definitionFinder = new DefinitionFinder($this->finderFacadeMock, $this->rootDir);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->finderFacadeMock
            ->expects(static::atLeastOnce())
            ->method('createFinder')
            ->willReturn($this->finderMock);
        
        $this->finderMock->expects(static::atLeastOnce())
            ->method('in')
            ->with([
                'src/Transfer/',
                'src/*/Transfer/',
                'src/*/*/Transfer/',
                'packages/*/src/*/*/Transfer/',
                'vendor/*/*/src/*/*/Transfer/',
                'vendor/*/*/packages/*/src/*/*/Transfer/',
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
