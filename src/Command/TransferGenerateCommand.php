<?php

declare(strict_types=1);

namespace Jellyfish\Transfer\Command;

use Jellyfish\Transfer\TransferFacadeInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'transfer:generate',
    description: 'Generate transfer classes and factories',
    hidden: false,
    aliases: ['transfer:generate'],
)]
class TransferGenerateCommand extends Command
{
    /**
     * @var string
     */
    public const NAME = 'transfer:generate';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Generate transfer classes and factories';

    /**
     * @param \Jellyfish\Transfer\TransferFacadeInterface $transferFacade
     */
    public function __construct(
        protected TransferFacadeInterface $transferFacade
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName(static::NAME);
        $this->setDescription(static::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->transferFacade->clean();
        $this->transferFacade->generate();

        return 0;
    }
}
