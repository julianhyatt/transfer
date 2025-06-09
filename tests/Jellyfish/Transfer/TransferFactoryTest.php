<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

use Codeception\Test\Unit;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Serializer;

class TransferFactoryTest extends Unit
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $filesystemMock;

    /**
     * @var \Symfony\Component\Serializer\Serializer|\PHPUnit\Framework\MockObject\MockObject
     */

    protected $serializerMock;

    /**
     * @var \Symfony\Component\Finder\Finder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $finderMock;

    /**
     * @var string
     */
    protected string $rootDir;

    /**
     * @var \Jellyfish\Transfer\TransferFactory
     */
    protected TransferFactory $transferFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->filesystemMock = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serializerMock = $this->getMockBuilder(Serializer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->finderMock = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rootDir = DIRECTORY_SEPARATOR;

        $this->transferFactory = new TransferFactory(
            $this->filesystemMock,
            $this->serializerMock,
            $this->finderMock,
            $this->rootDir
        );
    }

    /**
     * @return void
     */
    public function testGetTransferGenerator(): void
    {
        static::assertInstanceOf(
            TransferGenerator::class,
            $this->transferFactory->getTransferGenerator()
        );
    }

    /**
     * @return void
     */
    public function testGetTransferCleaner(): void
    {
        static::assertInstanceOf(
            TransferCleaner::class,
            $this->transferFactory->getTransferCleaner()
        );
    }
}
