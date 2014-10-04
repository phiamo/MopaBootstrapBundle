<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mopa\Bundle\BootstrapBundle\Twig;

/**
 * MopaBootstrap Flash Extension.
 *
 * @author Nikolai Zujev (jaymecd) <nikolai.zujev@gmail.com>
 */
class FlashExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $mapping = array();

    /**
     * Constructor.
     *
     * @param array $mapping
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('mopa_bootstrap_flash_mapping', array($this, 'getMapping'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Get flash mapping.
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mopa_bootstrap_flash';
    }
}
