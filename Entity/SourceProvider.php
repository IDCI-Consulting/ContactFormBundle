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
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\SourceProviderData", mappedBy="sourceProvider")
     */
    protected $sourceProviderData;
}
