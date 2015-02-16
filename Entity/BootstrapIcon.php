<?php

namespace opwoco\Bundle\BootstrapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BootstrapIcon
 */
class BootstrapIcon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var boolean
     */
    private $glyphicon;

    /**
     * @var boolean
     */
    private $fontawesome;

    /**
     * @var boolean
     */
    private $foundation;

    /**
     * @var boolean
     */
    private $ionicons;

    /**
     * @var boolean
     */
    private $octicons;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return BootstrapIcon
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    
        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set glyphicon
     *
     * @param boolean $glyphicon
     * @return BootstrapIcon
     */
    public function setGlyphicon($glyphicon)
    {
        $this->glyphicon = $glyphicon;
    
        return $this;
    }

    /**
     * Get glyphicon
     *
     * @return boolean 
     */
    public function getGlyphicon()
    {
        return $this->glyphicon;
    }

    /**
     * Set fontawesome
     *
     * @param boolean $fontawesome
     * @return BootstrapIcon
     */
    public function setFontawesome($fontawesome)
    {
        $this->fontawesome = $fontawesome;
    
        return $this;
    }

    /**
     * Get fontawesome
     *
     * @return boolean 
     */
    public function getFontawesome()
    {
        return $this->fontawesome;
    }

    /**
     * Set foundation
     *
     * @param boolean $foundation
     * @return BootstrapIcon
     */
    public function setFoundation($foundation)
    {
        $this->foundation = $foundation;
    
        return $this;
    }

    /**
     * Get foundation
     *
     * @return boolean 
     */
    public function getFoundation()
    {
        return $this->foundation;
    }

    /**
     * Set ionicons
     *
     * @param boolean $ionicons
     * @return BootstrapIcon
     */
    public function setIonicons($ionicons)
    {
        $this->ionicons = $ionicons;
    
        return $this;
    }

    /**
     * Get ionicons
     *
     * @return boolean 
     */
    public function getIonicons()
    {
        return $this->ionicons;
    }

    /**
     * Set octicons
     *
     * @param boolean $octicons
     * @return BootstrapIcon
     */
    public function setOcticons($octicons)
    {
        $this->octicons = $octicons;
    
        return $this;
    }

    /**
     * Get octicons
     *
     * @return boolean 
     */
    public function getOcticons()
    {
        return $this->octicons;
    }
}
