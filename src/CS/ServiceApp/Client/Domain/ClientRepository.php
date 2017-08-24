<?php

namespace CS\ServiceApp\Client\Domain;

interface ClientRepository
{
    public function store(Client $client);

    public function load($clientId);

    public function commit();
}
