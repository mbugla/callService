<?php

namespace CS\ServiceApp\Call\Application\Api\Handler;

use CS\ServiceApp\Call\Domain\CallRepository;
use CS\ServiceApp\Call\Application\Api\Command\CallCommand;
use CS\ServiceApp\Client\Domain\Client;
use CS\ServiceApp\Client\Domain\ClientRepository;

class CallCommandHandler
{
    /** @var CallRepository */
    private $callRepository;

    /** @var ClientRepository */
    private $clientRepository;

    /**
     * CallCommandHandler constructor.
     *
     * @param CallRepository   $callRepository
     * @param ClientRepository $clientRepository
     */
    public function __construct(CallRepository $callRepository, ClientRepository $clientRepository)
    {
        $this->callRepository = $callRepository;
        $this->clientRepository = $clientRepository;
    }

    public function handle(CallCommand $callCommand)
    {
        $call = $callCommand->getCall();
        $client = $this->clientRepository->load($call->getFrom());

        if ($client === null) {
            $client = new Client($call->getFrom());
            $this->clientRepository->store($client);
            $this->clientRepository->commit();
        };

        $call->assignClient($client);
        $this->callRepository->store($call);
        $this->callRepository->commit();
    }
}
