<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

interface ClassDefinitionMapMergerInterface
{
    /**
     * @param array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface> $classDefinitionMapA
     * @param array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface> $classDefinitionMapB
     *
     * @return array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface>
     */
    public function merge(array $classDefinitionMapA, array $classDefinitionMapB): array;
}
