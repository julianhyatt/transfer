<?php

declare(strict_types=1);

namespace Jellyfish\Transfer;

interface TransferFacadeInterface
{
    /**
     * @return \Jellyfish\Transfer\TransferFacadeInterface
     */
    public function generate(): self;

    /**
     * @return \Jellyfish\Transfer\TransferFacadeInterface
     */
    public function clean(): self;
}
