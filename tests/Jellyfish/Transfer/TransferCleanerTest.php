<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

use Codeception\Test\Unit;
use Iterator;
use Jellyfish\Transfer\Helper\FilesystemHelperInterface;
use Jellyfish\Transfer\Helper\Finder\FinderFacadeInterface;
use Jellyfish\Transfer\Helper\FinderHelperInterface;
use SplFileInfo;
use stdClass;

class TransferCleanerTest extends Unit
{
    /**
     * @var \Jellyfish\Transfer\TransferCleaner
     */
    protected TransferCleaner $transferCleaner;

    /**
     * @var string
     */
    protected string $targetDirectory;

    /**
     * @var FilesystemHelperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $filesystemMock;

    /**
     * @var FinderHelperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderMock;

    /**
     * @var FinderFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->filesystemMock = $this->getMockBuilder(FilesystemHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->finderMock = $this->getMockBuilder(FinderHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->finderFacadeMock = $this->getMockBuilder(FinderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->targetDirectory = '/root/src/Generated/Transfer/';

        $this->transferCleaner = new TransferCleaner(
            $this->finderFacadeMock,
            $this->filesystemMock,
            $this->targetDirectory,
        );
    }

    /**
     * @return void
     */
    public function testClean(): void
    {
        $this->markTestSkipped('Test wird übersprungen.');

        $finderMocks = [
            $this->getMockBuilder(FinderHelperInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(FinderHelperInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $iteratorMocks = [
            $this->getMockBuilder(Iterator::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(Iterator::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $splFileInfoMocks = [
            $this->getMockBuilder(SplFileInfo::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(SplFileInfo::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(SplFileInfo::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->filesystemMock->expects(static::atLeastOnce())
            ->method('exists')
            ->with($this->targetDirectory)
            ->willReturn(true);

        $finderMocks[0]->expects(static::atLeastOnce())
            ->method('in')
            ->with([$this->targetDirectory])
            ->willReturn($finderMocks[0]);

        $finderMocks[0]->expects(static::atLeastOnce())
            ->method('depth')
            ->with(0)
            ->willReturn($finderMocks[0]);

        $finderMocks[0]->expects(static::atLeastOnce())
            ->method('getIterator')
            ->willReturn($iteratorMocks[0]);

        $iteratorMocks[0]->expects(static::atLeastOnce())
            ->method('rewind');

        $iteratorMocks[0]->expects(static::atLeastOnce())
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, true, false);

        $iteratorMocks[0]->expects(static::atLeastOnce())
            ->method('current')
            ->willReturnOnConsecutiveCalls($splFileInfoMocks[0], $splFileInfoMocks[1]);

        $splFileInfoMocks[0]->expects(static::atLeastOnce())
            ->method('isDir')
            ->willReturn(true);

        $splFileInfoMocks[0]->expects(static::atLeastOnce())
            ->method('getRealPath')
            ->willReturn($this->targetDirectory . 'Product');

        $splFileInfoMocks[1]->expects(static::atLeastOnce())
            ->method('getRealPath')
            ->willReturn($this->targetDirectory . 'factory-registry.php');

        $this->filesystemMock->expects(static::atLeastOnce())
            ->method('remove')
            ->withConsecutive(
                [$this->targetDirectory . 'Product/AttributeTransfer.php'],
                [$this->targetDirectory . 'Product'],
            );

        $finderMocks[1]->expects(static::atLeastOnce())
            ->method('in')
            ->with([$this->targetDirectory . 'Product'])
            ->willReturn($finderMocks[1]);

        $finderMocks[1]->expects(static::atLeastOnce())
            ->method('depth')
            ->with(0)
            ->willReturn($finderMocks[1]);

        $finderMocks[1]->expects(static::atLeastOnce())
            ->method('getIterator')
            ->willReturn($iteratorMocks[1]);

        $iteratorMocks[1]->expects(static::atLeastOnce())
            ->method('rewind');

        $iteratorMocks[1]->expects(static::atLeastOnce())
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, false);

        $iteratorMocks[1]->expects(static::atLeastOnce())
            ->method('current')
            ->willReturn($splFileInfoMocks[2]);

        $splFileInfoMocks[2]->expects(static::atLeastOnce())
            ->method('isDir')
            ->willReturn(false);

        $splFileInfoMocks[2]->expects(static::atLeastOnce())
            ->method('getRealPath')
            ->willReturn($this->targetDirectory . 'Product/AttributeTransfer.php');

        static::assertEquals($this->transferCleaner, $this->transferCleaner->clean());
    }

    /**
     * @return void
     */
    public function testCleanWithInvalidIteratorElement(): void
    {
        $this->markTestSkipped('Test wird übersprungen.');
        $this->filesystemMock->expects(static::atLeastOnce())
            ->method('exists')
            ->with($this->targetDirectory)
            ->willReturn(true);

        $finderMock = $this->getMockBuilder(FinderHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $iteratorMock = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stdClassMock = $this->getMockBuilder(stdClass::class)
            ->disableOriginalConstructor()
            ->getMock();

        $finderMock->expects(static::atLeastOnce())
            ->method('in')
            ->with([$this->targetDirectory])
            ->willReturn($finderMock);

        $finderMock->expects(static::atLeastOnce())
            ->method('depth')
            ->with(0)
            ->willReturn($finderMock);

        $finderMock->expects(static::atLeastOnce())
            ->method('getIterator')
            ->willReturn($iteratorMock);

        $iteratorMock->expects(static::atLeastOnce())
            ->method('rewind');

        $iteratorMock->expects(static::atLeastOnce())
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, false);

        $iteratorMock->expects(static::atLeastOnce())
            ->method('current')
            ->willReturn($stdClassMock);

        $this->filesystemMock->expects(static::never())
            ->method('remove');

        static::assertEquals($this->transferCleaner, $this->transferCleaner->clean());
    }

    /**
     * @return void
     */
    public function testCleanWithNonExistingTargetDirectory(): void
    {
        $this->filesystemMock->expects(static::atLeastOnce())
            ->method('exists')
            ->with($this->targetDirectory)
            ->willReturn(false);

        static::assertEquals($this->transferCleaner, $this->transferCleaner->clean());
    }
}
