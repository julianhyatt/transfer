<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use ArrayObject;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Serializer\SerializerInterface;

class ClassDefinitionMapMapperTest extends Unit
{
    /**
     * @var \Jellyfish\Transfer\Definition\ClassDefinitionMapMapper
     */
    protected ClassDefinitionMapMapper $classDefinitionMapMapper;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SerializerInterface|MockObject $serializerMock;

    /**
     * @var \Jellyfish\Transfer\Definition\ClassDefinition[]|\PHPUnit\Framework\MockObject\MockObject[]|\ArrayObject
     */
    protected ArrayObject $classDefinitionMocks;

    /**
     * @var \Jellyfish\Transfer\Definition\ClassPropertyDefinition[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected array $classPropertyDefinitionMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->serializerMock = $this->getMockBuilder(SerializerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->classDefinitionMocks = new ArrayObject([
            $this->getMockBuilder(ClassDefinition::class)
                ->disableOriginalConstructor()
                ->getMock()
        ]);

        $this->classPropertyDefinitionMocks = [
            $this->getMockBuilder(ClassPropertyDefinition::class)
                ->disableOriginalConstructor()
                ->getMock()
        ];

        $this->classDefinitionMapMapper = new ClassDefinitionMapMapper($this->serializerMock);
    }

    /**
     * @return void
     */
    public function testFrom(): void
    {
        $json = '[{...}]';

        $this->serializerMock->expects(static::atLeastOnce())
            ->method('deserialize')
            ->with($json, ClassDefinition::class . '[]', 'json')
            ->willReturn($this->classDefinitionMocks);

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('Product');

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getNamespace')
            ->willReturn(null);

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getProperties')
            ->willReturn($this->classPropertyDefinitionMocks);

        $this->classPropertyDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('sku');

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('setProperties')
            ->with(['sku' => $this->classPropertyDefinitionMocks[0]]);

        $classDefinitionMap = $this->classDefinitionMapMapper->from($json);

        static::assertEquals(['Product' => $this->classDefinitionMocks[0]], $classDefinitionMap);
    }

    /**
     * @return void
     */
    public function testFromWithNamespace(): void
    {
        $json = '[{...}]';

        $this->serializerMock->expects(static::atLeastOnce())
            ->method('deserialize')
            ->with($json, ClassDefinition::class . '[]', 'json')
            ->willReturn($this->classDefinitionMocks);

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('Product');

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getNamespace')
            ->willReturn('Catalog');

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getProperties')
            ->willReturn($this->classPropertyDefinitionMocks);

        $this->classPropertyDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('sku');

        $this->classDefinitionMocks[0]->expects(static::atLeastOnce())
            ->method('setProperties')
            ->with(['sku' => $this->classPropertyDefinitionMocks[0]]);

        $classDefinitionMap = $this->classDefinitionMapMapper->from($json);

        static::assertEquals(['Catalog\\Product' => $this->classDefinitionMocks[0]], $classDefinitionMap);
    }
}
