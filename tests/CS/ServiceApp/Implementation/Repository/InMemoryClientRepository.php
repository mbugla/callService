<?php

namespace Tests\CS\ServiceApp\Implementation\Repository;

use CS\ServiceApp\Client\Domain\Client;
use CS\ServiceApp\Client\Domain\ClientRepository;

class InMemoryClientRepository implements ClientRepository
{
    private $clients;

    public function store(Client $client)
    {
        $id = $client->getId();
        if (!$client->getId()) {
            $id = 1;
        }
        $this->clients[$id] = $client;
    }

    public function load($clientId)
    {
        if (isset($this->clients[$clientId])) {
            return $this->clients[$clientId];
        }

        return null;
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }
}
