<?php

namespace Jellyfish\Transfer;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TransferBundle extends Bundle
{
  public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new DependencyInjection\JellyfishTransferExtension();
        }
        return $this->extension;
    }
}
