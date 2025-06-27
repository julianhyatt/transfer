<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

use Jellyfish\Transfer\Definition\ClassDefinitionMapLoader;
use Jellyfish\Transfer\Definition\ClassDefinitionMapLoaderInterface;
use Jellyfish\Transfer\Definition\ClassDefinitionMapMapper;
use Jellyfish\Transfer\Definition\ClassDefinitionMapMapperInterface;
use Jellyfish\Transfer\Definition\ClassDefinitionMapMerger;
use Jellyfish\Transfer\Definition\ClassDefinitionMapMergerInterface;
use Jellyfish\Transfer\Definition\DefinitionFinder;
use Jellyfish\Transfer\Definition\DefinitionFinderInterface;
use Jellyfish\Transfer\Generator\ClassGenerator;
use Jellyfish\Transfer\Helper\FilesystemHelper;
use Jellyfish\Transfer\Helper\FilesystemHelperInterface;
use Jellyfish\Transfer\Helper\Finder\FinderFacade;
use Jellyfish\Transfer\Helper\Finder\FinderFacadeInterface;
use Jellyfish\Transfer\Helper\Finder\FinderFactory;
use Jellyfish\Transfer\Helper\FinderHelper;
use Jellyfish\Transfer\Helper\FinderHelperInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use function sprintf;

class TransferFactory
{
    /**
     * @var \Jellyfish\Transfer\TransferGeneratorInterface|null
     */
    protected ?TransferGeneratorInterface $transferGenerate = null;

    /**
     * @var \Jellyfish\Transfer\TransferCleanerInterface|null
     */
    protected ?TransferCleanerInterface $transferCleaner = null;
    /**
     * @var FinderFacadeInterface|null
     */
    protected ?FinderFacadeInterface $finderFacade = null;

    /**
     * @var FilesystemHelperInterface|null
     */
    protected ?FilesystemHelperInterface $filesystemHelper = null;

    /**
     * @param Filesystem $filesystem
     * @param SerializerInterface $serializer
     * @param Finder $finder
     * @param string $rootDir
     */
    public function __construct(
        protected Filesystem $filesystem,
        protected SerializerInterface $serializer,
        protected Finder $finder,
        protected string $rootDir
    ) {
    }

    /**
     * @return \Jellyfish\Transfer\TransferGeneratorInterface
     */
    public function getTransferGenerator(): TransferGeneratorInterface
    {
        if ($this->transferGenerate === null) {
            $this->transferGenerate = new TransferGenerator(
                $this->createClassDefinitionMapLoader(),
                $this->createClassGenerators(),
            );
        }

        return $this->transferGenerate;
    }

    /**
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionMapLoaderInterface
     */
    protected function createClassDefinitionMapLoader(): ClassDefinitionMapLoaderInterface
    {
        return new ClassDefinitionMapLoader(
            $this->createDefinitionFinder(),
            $this->getFilesystemHelper(),
            $this->createClassDefinitionMapMapper(),
            $this->createClassDefinitionMapMerger(),
        );
    }

    /**
     * @return \Jellyfish\Transfer\Definition\DefinitionFinderInterface
     */
    protected function createDefinitionFinder(): DefinitionFinderInterface
    {
        return new DefinitionFinder($this-> getFinderFacade(), $this->rootDir);
    }

    /**
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionMapMapperInterface
     */
    protected function createClassDefinitionMapMapper(): ClassDefinitionMapMapperInterface
    {
        return new ClassDefinitionMapMapper($this->serializer);
    }

    /**
     * @return \Jellyfish\Transfer\Definition\ClassDefinitionMapMergerInterface
     */
    protected function createClassDefinitionMapMerger(): ClassDefinitionMapMergerInterface
    {
        return new ClassDefinitionMapMerger();
    }

    /**
     * @return array<\Jellyfish\Transfer\Generator\ClassGeneratorInterface>
     */
    protected function createClassGenerators(): array
    {
        $targetDirectory = $this->getTargetDirectory();
        $twigEnvironment = $this->createTwigEnvironment();

        return [
            new ClassGenerator(
                $this->getFilesystemHelper(),
                $twigEnvironment,
                $targetDirectory,
            ),
        ];
    }

    /**
     * @return \Twig\Environment
     */
    protected function createTwigEnvironment(): Environment
    {
        $pathToTemplates = __DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR;
        $loader = new FilesystemLoader($pathToTemplates);

        return new Environment($loader, []);
    }

    /**
     * @return FinderFacadeInterface
     */
    protected function createFinderFacade(): FinderFacadeInterface
    {
        return new FinderFacade(new FinderFactory());
    }

    /**
     * @return FinderFacadeInterface
     */
    public function getFinderFacade(): FinderFacadeInterface
    {
        if ($this->finderFacade === null) {
            $this->finderFacade = $this->createFinderFacade();
        }

        return $this->finderFacade;
    }

    /**
     * @return FilesystemHelperInterface
     */
    protected function createFilesystemHelper(): FilesystemHelperInterface
    {
        return new FilesystemHelper($this->filesystem);
    }

    /**
     * @return FilesystemHelperInterface
     */
    public function getFilesystemHelper(): FilesystemHelperInterface
    {
        if ($this->filesystemHelper === null) {
            $this->filesystemHelper = $this->createFilesystemHelper();
        }

        return $this->filesystemHelper;
    }

    /**
     * @return \Jellyfish\Transfer\TransferCleanerInterface
     */
    public function getTransferCleaner(): TransferCleanerInterface
    {
        if ($this->transferCleaner === null) {
            $this->transferCleaner = new TransferCleaner(
                $this->getFinderFacade(),
                $this->getFilesystemHelper(),
                $this->getTargetDirectory(),
            );
        }

        return $this->transferCleaner;
    }

    /**
     * @return string
     */
    protected function getTargetDirectory(): string
    {
        return sprintf('%ssrc/Generated/Transfer/', $this->rootDir);
    }
}
