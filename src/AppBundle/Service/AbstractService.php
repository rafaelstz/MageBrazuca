<?php

namespace AppBundle\Service;
use AppBundle\Entity\Entity;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
abstract class AbstractService
{
    protected $repository;

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findByIds($ids)
    {
        return $this->repository->findByIds($ids);
    }

    public function create(Entity $object)
    {
        return $this->repository->create($object);
    }

    public function update(Entity $object)
    {
        return $this->repository->update($object);
    }
}
