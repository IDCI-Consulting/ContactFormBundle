<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\ContactFormBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SourceRepository
 */
class SourceRepository extends EntityRepository
{
    /**
     * Get the source associated with the given token query builder
     *
     * @param string $token
     * @return DoctrineQueryBuilder
     */
    public function getSourceQueryBuilder($token)
    {
        $qb = $this->createQueryBuilder('src');

        $qb
            ->andWhere('src.isEnabled = true')
            ->andWhere('src.apiToken = :token')
            ->setParameter('token', $token)
        ;

        return $qb;
    }

    /**
     * Get the source associated with the given token query
     *
     * @param string $token
     * @return DoctrineQuery
     */
    public function getSourceQuery($token)
    {
        $qb = $this->getSourceQueryBuilder($token);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Get the source associated with the given token
     *
     * @param string $token
     * @return Source
     */
    public function getSource($token)
    {
        $q = $this->getSourceQuery($token);

        return is_null($q) ? array() : $q->getSingleResult();
    }
}
