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
 * @ORM\Entity(repositoryClass="IDCI\Bundle\ContactFormBundle\Repository\SourceRepository")
 * @ORM\Table(name="idci_contact_source")
 * @ORM\HasLifecycleCallbacks
 */
class Source
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enabled", type="boolean", options={"default":1})
     */
    private $isEnabled;

    /**
     * @var datetime $created_at
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string", unique=true)
     */
    private $apiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_liste", type="json_array", nullable=true)
     */
    private $domainListe;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_white_liste", type="json_array", nullable=true)
     */
    private $ipWhiteListe;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_black_liste", type="json_array", nullable=true)
     */
    private $ipBlackListe;

    /**
     * @var boolean
     *
     * @ORM\Column(name="https_only", type="boolean", options={"default":0})
     */
    private $httpsOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="method_post_only", type="boolean", options={"default":0})
     */
    private $methodPostOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="method_get_only", type="boolean", options={"default":0})
     */
    private $methodGetOnly;

    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\Message", mappedBy="source")
     */
    protected $messages;

    public static function generateToken()
    {
        $now = new \DateTime('now');

        return md5($now->format('l d F (H:i:s)'));
    }

    /**
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->setApiToken(self::generateToken());
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsEnabled(true);
        $this->setHttpsOnly(false);
        $this->setMethodPostOnly(false);
        $this->setMethodGetOnly(false);
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
     * Set name
     *
     * @param string $name
     * @return Source
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return Source
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    
        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Source
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
     * Set apiToken
     *
     * @param string $apiToken
     * @return Source
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
    
        return $this;
    }

    /**
     * Get apiToken
     *
     * @return string 
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * Set domainListe
     *
     * @param array $domainListe
     * @return Source
     */
    public function setDomainListe($domainListe)
    {
        $this->domainListe = $domainListe;
    
        return $this;
    }

    /**
     * Get domainListe
     *
     * @return array 
     */
    public function getDomainListe()
    {
        return $this->domainListe;
    }

    /**
     * Set ipWhiteListe
     *
     * @param array $ipWhiteListe
     * @return Source
     */
    public function setIpWhiteListe($ipWhiteListe)
    {
        $this->ipWhiteListe = $ipWhiteListe;
    
        return $this;
    }

    /**
     * Get ipWhiteListe
     *
     * @return array 
     */
    public function getIpWhiteListe()
    {
        return $this->ipWhiteListe;
    }

    /**
     * Set ipBlackListe
     *
     * @param array $ipBlackListe
     * @return Source
     */
    public function setIpBlackListe($ipBlackListe)
    {
        $this->ipBlackListe = $ipBlackListe;
    
        return $this;
    }

    /**
     * Get ipBlackListe
     *
     * @return array 
     */
    public function getIpBlackListe()
    {
        return $this->ipBlackListe;
    }

    /**
     * Set httpsOnly
     *
     * @param boolean $httpsOnly
     * @return Source
     */
    public function setHttpsOnly($httpsOnly)
    {
        $this->httpsOnly = $httpsOnly;
    
        return $this;
    }

    /**
     * Get httpsOnly
     *
     * @return boolean 
     */
    public function getHttpsOnly()
    {
        return $this->httpsOnly;
    }

    /**
     * Set methodPostOnly
     *
     * @param boolean $methodPostOnly
     * @return Source
     */
    public function setMethodPostOnly($methodPostOnly)
    {
        $this->methodPostOnly = $methodPostOnly;
    
        return $this;
    }

    /**
     * Get methodPostOnly
     *
     * @return boolean 
     */
    public function getMethodPostOnly()
    {
        return $this->methodPostOnly;
    }

    /**
     * Set methodGetOnly
     *
     * @param boolean $methodGetOnly
     * @return Source
     */
    public function setMethodGetOnly($methodGetOnly)
    {
        $this->methodGetOnly = $methodGetOnly;
    
        return $this;
    }

    /**
     * Get methodGetOnly
     *
     * @return boolean 
     */
    public function getMethodGetOnly()
    {
        return $this->methodGetOnly;
    }

    /**
     * Add messages
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Message $messages
     * @return Source
     */
    public function addMessage(\IDCI\Bundle\ContactFormBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Message $messages
     */
    public function removeMessage(\IDCI\Bundle\ContactFormBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
}