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
    const HTTP_METHOD_GET  = "GET";
    const HTTP_METHOD_POST = "POST";
    const HTTP_METHOD_PUT  = "PUT";

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
     * @var string
     *
     * @ORM\Column(name="mail", type="string")
     */
    private $mail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enabled", type="boolean", options={"default":1})
     */
    private $isEnabled;

    /**
     * @var datetime $createdAt
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string", unique=true)
     */
    private $apiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_list", type="json_array", nullable=true)
     */
    private $domainList;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_white_list", type="json_array", nullable=true)
     */
    private $ipWhiteList;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_black_list", type="json_array", nullable=true)
     */
    private $ipBlackList;

    /**
     * @var boolean
     *
     * @ORM\Column(name="https_only", type="boolean", options={"default":0})
     */
    private $httpsOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="http_method", type="string", nullable=true)
     */
    private $httpMethod;

    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\Message", mappedBy="source")
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\SourceProvider", mappedBy="source")
     */
    protected $sourceProviders;

    public static function getHttpMethods()
    {
        return array(
            self::HTTP_METHOD_GET  => self::HTTP_METHOD_GET,
            self::HTTP_METHOD_POST => self::HTTP_METHOD_POST,
            self::HTTP_METHOD_PUT  => self::HTTP_METHOD_PUT,
        );
    }

    public function generateToken()
    {
        $now = new \DateTime('now');

        return md5(sprintf('%s %s',
            $this->getName(),
            $this->getMail(),
            $now->format('l d F (H:i:s)')
        ));
    }

    /**
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->setApiToken($this->generateToken());
    }

    /**
     * toString
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsEnabled(true);
        $this->setHttpsOnly(false);
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
     * Set mail
     *
     * @param string $mail
     * @return Source
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Source
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Set domainList
     *
     * @param array $domainList
     * @return Source
     */
    public function setDomainList($domainList)
    {
        $this->domainList = $domainList;

        return $this;
    }

    /**
     * Get domainList
     *
     * @return array 
     */
    public function getDomainList()
    {
        return $this->domainList;
    }

    /**
     * Set ipWhiteList
     *
     * @param array $ipWhiteList
     * @return Source
     */
    public function setIpWhiteList($ipWhiteList)
    {
        $this->ipWhiteList = $ipWhiteList;

        return $this;
    }

    /**
     * Get ipWhiteList
     *
     * @return array 
     */
    public function getIpWhiteList()
    {
        return $this->ipWhiteList;
    }

    /**
     * Set ipBlackList
     *
     * @param array $ipBlackList
     * @return Source
     */
    public function setIpBlackList($ipBlackList)
    {
        $this->ipBlackList = $ipBlackList;

        return $this;
    }

    /**
     * Get ipBlackList
     *
     * @return array 
     */
    public function getIpBlackList()
    {
        return $this->ipBlackList;
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
     * Set httpMethod
     *
     * @param string $httpMethod
     * @return Source
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    /**
     * Get httpMethod
     *
     * @return string 
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Add message
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Message $message
     * @return Source
     */
    public function addMessage(\IDCI\Bundle\ContactFormBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\Message $message
     */
    public function removeMessage(\IDCI\Bundle\ContactFormBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
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

    /**
     * Add sourceProvider
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider
     * @return Source
     */
    public function addSourceProvider(\IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider)
    {
        $this->sourceProviders[] = $sourceProvider;
    
        return $this;
    }

    /**
     * Remove sourceProvider
     *
     * @param \IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider
     */
    public function removeSourceProvider(\IDCI\Bundle\ContactFormBundle\Entity\SourceProvider $sourceProvider)
    {
        $this->sourceProviders->removeElement($sourceProvider);
    }

    /**
     * Get sourceProviders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSourceProviders()
    {
        return $this->sourceProviders;
    }
}
