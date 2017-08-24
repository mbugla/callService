<?php

namespace Tests\CS\ServiceApp\Implementation\Repository;

use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Call\Domain\CallRepository;

class InMemoryCallRepository implements CallRepository
{

    private $calls;

    public function store(Call $call)
    {
        $this->calls[$call->getCallId()] = $call;
    }

    public function load($callId)
    {
        if(isset($this->calls[$callId])) {
            return $this->calls[$callId];
        }

        return null;
    }

    public function commit()
    {
    }
}
