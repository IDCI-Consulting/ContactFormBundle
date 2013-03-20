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
     * @var datetime $created_at
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string")
     */
    private $apiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_liste", type="json_array")
     */
    private $domainListe;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_white_liste", type="json_array")
     */
    private $ipWhiteListe;

    /**
     * @var array
     *
     * @ORM\Column(name="ip_black_liste", type="json_array")
     */
    private $ipBlackListe;

    /**
     * @var boolean
     *
     * @ORM\Column(name="https_only", type="boolean")
     */
    private $httpsOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="method_post_only", type="boolean")
     */
    private $methodPostOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="method_get_only", type="boolean")
     */
    private $methodGetOnly;

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
}
