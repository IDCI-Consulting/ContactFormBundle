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
 * @ORM\Table(name="idci_contact_source_provider_data")
 */
class SourceProviderData
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
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\ContactFormBundle\Entity\SourceProvider", inversedBy="sourceProviderData", cascade={"persist"})
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
}
