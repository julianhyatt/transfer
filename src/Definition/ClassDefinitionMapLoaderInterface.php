<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

interface ClassDefinitionMapLoaderInterface
{
    /**
     * @return array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface>
     */
    public function load(): array;
}
