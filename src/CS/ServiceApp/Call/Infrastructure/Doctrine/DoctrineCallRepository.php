<?php

namespace CS\ServiceApp\Call\Infrastructure\Doctrine;

use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Call\Domain\CallRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineCallRepository extends EntityRepository implements CallRepository
{
    public function store(Call $call)
    {
        $this->_em->persist($call);
    }

    /**
     * @param $callId
     *
     * @return Call | null
     */
    public function load($callId)
    {
        return $this->findOneBy(['callId' => $callId]);
    }

    public function commit()
    {
        $this->_em->flush();
    }
}
