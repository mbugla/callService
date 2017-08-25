<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormCrudController
 * @package AppBundle\Controller\Admin
 *
 * @Route("/admin")
 */
class FormCrudController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/forms", name="admin_forms_index")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $forms = $this->get('service_app.repository.form')->findAll();

        return new Response($this->renderView('@App/Admin/Form/index.html.twig', ['forms' => $forms]));
    }
}
