<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

class TransferFacade implements TransferFacadeInterface
{
    /**
     * @param \Jellyfish\Transfer\TransferFactory $factory
     */
    public function __construct(protected TransferFactory $factory)
    {
    }

    /**
     * @return \Jellyfish\Transfer\TransferFacadeInterface
     */
    public function generate(): TransferFacadeInterface
    {
        $this->factory->getTransferGenerator()->generate();

        return $this;
    }

    /**
     * @return \Jellyfish\Transfer\TransferFacadeInterface
     */
    public function clean(): TransferFacadeInterface
    {
        $this->factory->getTransferCleaner()->clean();

        return $this;
    }
}
