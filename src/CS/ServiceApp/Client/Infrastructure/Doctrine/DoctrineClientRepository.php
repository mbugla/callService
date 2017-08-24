<?php

namespace CS\ServiceApp\Client\Infrastructure\Doctrine;

use CS\ServiceApp\Client\Domain\Client;
use CS\ServiceApp\Client\Domain\ClientRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineClientRepository extends EntityRepository implements ClientRepository
{

    public function store(Client $client)
    {
        $this->_em->persist($client);
    }

    public function load($phoneNumber)
    {
        return $this->findOneBy(['phoneNumber'=>$phoneNumber]);
    }

    public function commit()
    {
        $this->_em->flush();
    }
}
