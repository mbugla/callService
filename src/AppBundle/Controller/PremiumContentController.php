<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremiumContentController extends Controller
{
    /**
     * @Route("/premium", name="homepage")
     */
    public function premiumAction(Request $request)
    {
        return new Response($this->renderView('@App/PremiumContent/premium.html.twig'));
    }
}
