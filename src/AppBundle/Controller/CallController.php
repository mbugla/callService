<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallController extends Controller
{
    /**
     * @Route("/", name="request_dispatch")
     */
    public function indexAction(Request $request)
    {
        $callCenter = $this->get('service_app.call_center');

        return new Response(
            $callCenter->handleIncomingEvent($request->request->all()),
            Response::HTTP_OK,
            ['Content-Type' => 'application/xml']
        );
    }
}
