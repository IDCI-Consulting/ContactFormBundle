<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="idci_contact_source_provider_parameter")
 */
class SourceProviderParameter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * source
     *
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\SourceProvider", inversedBy="sourceProviderParameters", cascade={"persist"})
     * @ORM\JoinColumn(name="source_provider_id", referencedColumnName="id", onDelete="Cascade")
     */
    protected $sourceProvider;

    /**
     * @var string
     *
     * @ORM\Column(name="data_key", type="string")
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="data_value", type="string")
     */
    private $value;

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
     * Set key
     *
     * @param string $key
     * @return SourceProviderParameter
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return SourceProviderParameter
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set sourceProvider
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider
     * @return SourceProviderParameter
     */
    public function setSourceProvider(\IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider = null)
    {
        $this->sourceProvider = $sourceProvider;
    
        return $this;
    }

    /**
     * Get sourceProvider
     *
     * @return \IDCI\Bundle\ContactFormBundle\Entity\SourceProvider 
     */
    public function getSourceProvider()
    {
        return $this->sourceProvider;
    }
}