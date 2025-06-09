<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

interface ClassDefinitionInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setName(string $name): self;

    /**
     * @return string|null
     */
    public function getNamespace(): ?string;

    /**
     * @param string|null $namespace
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setNamespace(?string $namespace): self;

    /**
     * @return array<string>
     */
    public function getUseStatements(): array;

    /**
     * @return string
     */
    public function getNamespaceStatement(): string;

    /**
     * @return array<\Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface>
     */
    public function getProperties(): array;

    /**
     * @param array<\Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface> $properties
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setProperties(array $properties): self;
}
