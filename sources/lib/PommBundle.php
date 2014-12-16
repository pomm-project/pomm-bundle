<?php

namespace PommProject\PommBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PommBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DependencyInjection\PommExtension();
    }
}
