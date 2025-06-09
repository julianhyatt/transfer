<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

interface ClassPropertyDefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setName(string $name): self;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setType(string $type): self;

    /**
     * @return string|null
     */
    public function getTypeAlias(): ?string;

    /**
     * @param string|null $typeAlias
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setTypeAlias(?string $typeAlias): self;

    /**
     * @return string|null
     */
    public function getTypeNamespace(): ?string;

    /**
     * @param string|null $typeNamespace
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setTypeNamespace(?string $typeNamespace): self;

    /**
     * @return string|null
     */
    public function getSingular(): ?string;

    /**
     * @param string|null $singular
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setSingular(?string $singular): self;

    /**
     * @return bool
     */
    public function isNullable(): bool;

    /**
     * @param bool $isIsNullable
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setIsNullable(bool $isIsNullable): self;

    /**
     * @return bool
     */
    public function isArray(): bool;

    /**
     * @param bool|null $isArray
     *
     * @return \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface
     */
    public function setIsArray(?bool $isArray): self;

    /**
     * @return bool
     */
    public function isPrimitive(): bool;
}
