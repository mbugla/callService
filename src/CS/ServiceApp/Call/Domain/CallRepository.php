<?php

declare(strict_types=1);

namespace CS\ServiceApp\Call\Domain;

interface CallRepository
{
    public function store(Call $call);

    /**
     * @param $callId
     *
     * @return Call | null
     */
    public function load($callId);

    public function commit();
}
