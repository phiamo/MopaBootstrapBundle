<?php

namespace Mopa\BootstrapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MopaBootstrapBundle extends Bundle
{
    public function getParent()
    {
        return 'KnpPaginatorBundle';
    }
}
