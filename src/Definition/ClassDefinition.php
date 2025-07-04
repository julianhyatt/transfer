<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use RuntimeException;

use function array_key_exists;
use function preg_replace;
use function sha1;
use function sprintf;
use function str_replace;
use function strtolower;

class ClassDefinition implements ClassDefinitionInterface
{
    /**
     * @var string
     */
    public const NAMESPACE_PREFIX = 'Generated\\Transfer';

    /**
     * @var string
     */
    protected const PATTERN_ID = '/(?<=\\w)(?=[A-Z])/';

    /**
     * @var string
     */
    protected const REPLACEMENT_ID = '_$1';

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string|null
     */
    protected ?string $namespace = null;

    /**
     * @var array<\Jellyfish\Transfer\Definition\ClassPropertyDefinition>
     */
    protected array $properties;

    /**
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getId(): string
    {
        $id = static::NAMESPACE_PREFIX;

        if ($this->namespace !== null) {
            $id .= $this->namespace;
        }

        $id .= $this->name;
        $id = str_replace('\\', '', $id);
        $id = @preg_replace(static::PATTERN_ID, static::REPLACEMENT_ID, $id);

        if ($id === null) {
            throw new RuntimeException('Could not perform a regular expression search and replace.');
        }

        return strtolower($id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setName(string $name): ClassDefinitionInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @param string|null $namespace
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setNamespace(?string $namespace): ClassDefinitionInterface
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getNamespaceStatement(): string
    {
        if ($this->namespace === null) {
            return sprintf('namespace %s;', static::NAMESPACE_PREFIX);
        }

        return sprintf('namespace %s\\%s;', static::NAMESPACE_PREFIX, $this->namespace);
    }

    /**
     * @return array<string>
     */
    public function getUseStatements(): array
    {
        $useStatements = [];

        foreach ($this->properties as $property) {
            if (!$this->canCreateUseStatement($property)) {
                continue;
            }

            $useStatement = $this->createUseStatement($property);
            $useStatementKey = sha1($useStatement);

            if (array_key_exists($useStatementKey, $useStatements)) {
                continue;
            }

            $useStatements[$useStatementKey] = $useStatement;
        }

        return $useStatements;
    }

    /**
     * @param \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface $property
     *
     * @return bool
     */
    protected function canCreateUseStatement(ClassPropertyDefinitionInterface $property): bool
    {
        return $property->isPrimitive() === false
            && ($property->getTypeNamespace() !== $this->namespace || $property->getTypeAlias() !== null);
    }

    /**
     * @param \Jellyfish\Transfer\Definition\ClassPropertyDefinitionInterface $property
     *
     * @return string
     */
    protected function createUseStatement(ClassPropertyDefinitionInterface $property): string
    {
        if ($property->getTypeAlias() === null) {
            return sprintf(
                'use %s\\%s\\%s;',
                static::NAMESPACE_PREFIX,
                $property->getTypeNamespace(),
                $property->getType(),
            );
        }

        return sprintf(
            'use %s\\%s\\%s as %s;',
            static::NAMESPACE_PREFIX,
            $property->getTypeNamespace(),
            $property->getType(),
            $property->getTypeAlias(),
        );
    }

    /**
     * @return array<\Jellyfish\Transfer\Definition\ClassPropertyDefinition>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array<\Jellyfish\Transfer\Definition\ClassPropertyDefinition> $properties
     *
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionInterface
     */
    public function setProperties(array $properties): ClassDefinitionInterface
    {
        $this->properties = $properties;

        return $this;
    }
}
