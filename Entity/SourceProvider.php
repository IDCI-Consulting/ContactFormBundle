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
 * @ORM\Table(name="idci_contact_source_provider")
 */
class SourceProvider
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
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\Source", inversedBy="sourceProviders", cascade={"persist"})
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", onDelete="Cascade")
     */
    protected $source;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string")
     */
    private $provider;

    /**
     * @var string
     *
     * @ORM\Column(name="data_request_transformer", type="string")
     */
    private $dataRequestTransformer;

    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter", mappedBy="sourceProvider")
     */
    protected $sourceProviderParameters;

    /**
     * toString
     */
    public function __toString()
    {
        return sprintf('%s', $this->getProvider());
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sourceProviderParameters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set provider
     *
     * @param string $provider
     * @return SourceProvider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    
        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set data request transformer
     *
     * @param string $data_request_transformer
     * @return SourceProvider
     */
    public function setDataRequestTransformer($data_request_transformer)
    {
        $this->dataRequestTransformer = $data_request_transformer;
    
        return $this;
    }

    /**
     * Get data request transformer
     *
     * @return string 
     */
    public function getDataRequestTransformer()
    {
        return $this->dataRequestTransformer;
    }

    /**
     * Set source
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Source $source
     * @return SourceProvider
     */
    public function setSource(\IDCI\Bundle\ContactFormBundle\Entity\Source $source = null)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return \IDCI\Bundle\ContactFormBundle\Entity\Source 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Add sourceProviderParameter
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter $sourceProviderParameter
     * @return SourceProvider
     */
    public function addSourceProviderParameter(\IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter $sourceProviderParameter)
    {
        $this->sourceProviderParameters[] = $sourceProviderParameter;
    
        return $this;
    }

    /**
     * Remove sourceProviderParameter
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter $sourceProviderParameter
     */
    public function removeSourceProviderParameter(\IDCI\Bundle\ContactFormBundle\Entity\SourceProviderParameter $sourceProviderParameter)
    {
        $this->sourceProviderParameters->removeElement($sourceProviderParameter);
    }

    /**
     * Get sourceProviderParameters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSourceProviderParameters()
    {
        return $this->sourceProviderParameters;
    }

    /**
     * Get Parameter
     *
     * @param string $key
     * @return string | null
     */
    public function getParameter($key)
    {
        $parameters = $this->getSourceProviderParameters();

        foreach($parameters as $parameter) {
            if ($parameter->getKey() == $key) {
                return $parameter->getValue();
            }
        }

        return null;
    }
}
