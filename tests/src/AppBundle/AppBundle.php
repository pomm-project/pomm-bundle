<?php

namespace AppBundle;

use \Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DependencyInjection\AppExtension();
    }
}
