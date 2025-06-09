<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Definition;

use Jellyfish\Transfer\Helper\FilesystemHelperInterface;
use SplFileInfo;

use function is_string;

class ClassDefinitionMapLoader implements ClassDefinitionMapLoaderInterface
{
    /**
     * @param DefinitionFinderInterface $definitionFinder
     * @param FilesystemHelperInterface $filesystem
     * @param ClassDefinitionMapMapperInterface $classDefinitionMapMapper
     * @param ClassDefinitionMapMergerInterface $classDefinitionMapMerger
     */
    public function __construct(
        protected DefinitionFinderInterface $definitionFinder,
        protected FilesystemHelperInterface $filesystem,
        protected ClassDefinitionMapMapperInterface $classDefinitionMapMapper,
        protected ClassDefinitionMapMergerInterface $classDefinitionMapMerger
    ) {
    }

    /**
     * @return array<\Jellyfish\Transfer\Definition\ClassDefinitionInterface>
     */
    public function load(): array
    {
        $classDefinitionMap = [];

        foreach ($this->definitionFinder->find() as $definitionFile) {
            if (!($definitionFile instanceof SplFileInfo) || !is_string($definitionFile->getRealPath())) {
                continue;
            }

            $definitionFileContent = $this->filesystem->readFromFile($definitionFile->getRealPath());

            $currentClassDefinitionMap = $this->classDefinitionMapMapper->from($definitionFileContent);

            $classDefinitionMap = $this->classDefinitionMapMerger
                ->merge($classDefinitionMap, $currentClassDefinitionMap);
        }

        return $classDefinitionMap;
    }
}
