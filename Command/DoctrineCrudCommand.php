<?php

namespace Mopa\Bundle\BootstrapBundle\Command;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand as BaseGenerator;

class DoctrineCrudCommand extends BaseGenerator
{
    protected function configure()
    {
        parent::configure();
        $this->setName('mopa:generate:crud');
    }

    protected function getGenerator()
    {
        $generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/crud');
        $this->setGenerator($generator);

        return parent::getGenerator();
    }
}
