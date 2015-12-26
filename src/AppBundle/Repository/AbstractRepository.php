<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
abstract class AbstractRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Entity $obj
     */
    public function create(Entity $obj)
    {
        $this->getEntityManager()->persist($obj);
        $this->getEntityManager()->flush();

        return $obj;
    }

    /**
     * @param Entity $obj
     */
    public function update(Entity $obj)
    {
        $this->getEntityManager()->persist($obj);
        $this->getEntityManager()->flush();

        return $obj;
    }

    /**
     * @param Entity $obj
     */
    public function delete(Entity $obj)
    {
        $this->getEntityManager()->remove($obj);
        $this->getEntityManager()->flush();

        return $obj;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function findByIds(array $ids)
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.id IN(?1)')
            ->setParameter(1, $ids)
            ->getQuery();

        return $query->getResult();
    }
}
