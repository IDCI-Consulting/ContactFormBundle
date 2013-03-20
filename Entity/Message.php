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
 * @ORM\Table(name="idci_contact_message")
 * @ORM\HasLifecycleCallbacks
 */
class Message
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
     * @var datetime $created_at
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * source
     *
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\Source", inversedBy="messages", cascade={"persist"})
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
     * @var json_array
     *
     * @ORM\Column(name="data", type="json_array")
     */
    private $data;

    /**
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime('now'));
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set provider
     *
     * @param string $provider
     * @return Message
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
     * Set data
     *
     * @param array $data
     * @return Message
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return array 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set source
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Source $source
     * @return Message
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
}