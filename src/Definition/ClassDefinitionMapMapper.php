<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Symfony\Component\Serializer\SerializerInterface;

use function sprintf;

class ClassDefinitionMapMapper implements ClassDefinitionMapMapperInterface
{
    protected const TYPE = ClassDefinition::class . '[]';

    /**
     * @var string
     */
    protected const FORMAT = 'json';

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(protected SerializerInterface $serializer)
    {
    }

    /**
     * @param string $data
     *
     * @return array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface>
     */
    public function from(string $data): array
    {
        /** @var array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface> $classDefinitions */
        $classDefinitions = $this->serializer->deserialize($data, static::TYPE, static::FORMAT);
        $classDefinitionMap = [];

        foreach ($classDefinitions as $classDefinition) {
            $classDefinitionMapKey = $this->generateClassDefinitionMapKey($classDefinition);
            $classDefinitionMap[$classDefinitionMapKey] = $classDefinition;
            $classPropertyDefinitionMap = [];

            foreach ($classDefinition->getProperties() as $classPropertyDefinition) {
                $classPropertyDefinitionMap[$classPropertyDefinition->getName()] = $classPropertyDefinition;
            }

            $classDefinition->setProperties($classPropertyDefinitionMap);
        }

        return $classDefinitionMap;
    }

    /**
     * @param \Jellyfish\Transfer\Definition\ClassDefinitionInterface $classDefinition
     *
     * @return string
     */
    protected function generateClassDefinitionMapKey(ClassDefinitionInterface $classDefinition): string
    {
        if ($classDefinition->getNamespace() === null) {
            return $classDefinition->getName();
        }

        return sprintf('%s\\%s', $classDefinition->getNamespace(), $classDefinition->getName());
    }
}
