<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension as BaseAbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base AbstractTypeExtension to utilize configureOptions
 *
 * @author isometriks <craig.blanchette@gmail.com>
 */
abstract class AbstractTypeExtension extends BaseAbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver)
    {
        if (!method_exists($this, 'setDefaultOptions')) {
            return;
        }

        $this->setDefaultOptions($resolver);
    }
}
