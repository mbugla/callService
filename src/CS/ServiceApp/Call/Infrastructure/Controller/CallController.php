<?php

namespace CS\ServiceApp\Call\Infrastructure\Controller;

use CS\ServiceApp\CallCenter\Domain\CallCenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallController
{
    /**
     * @var CallCenter
     */
    private $callCenter;

    /**
     * CallController constructor.
     *
     * @param CallCenter $callCenter
     */
    public function __construct(CallCenter $callCenter)
    {
        $this->callCenter = $callCenter;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return new Response(
            $this->callCenter->handleIncomingEvent($request->request->all()),
            Response::HTTP_OK,
            ['Content-Type' => 'application/xml']
        );
    }
}
