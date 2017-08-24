<?php

namespace AppBundle\Controller;

use AppBundle\Form\ClientRequestForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends Controller
{
    /**
     * @Route("/form/{id}", name="homepage")
     */
    public function formAction($id, Request $request)
    {
        $repo = $this->get('service_app.repository.form');

        $form = $repo->load($id);

        $clientRequestForm = $this->createForm(ClientRequestForm::class, $form);

        if ($request->getMethod() == 'POST') {
            $clientRequestForm = $this->createForm(ClientRequestForm::class, $form);
            $clientRequestForm->handleRequest($request);

            if ($clientRequestForm->isValid()) {
                $form = $clientRequestForm->getData();
                $form->setUpdatedAt(new \DateTime());
                $this->get('service_app.repository.form')->store($form);

                return new Response($this->renderView('AppBundle:Form:thankyou.html.twig'));
            }
        }

        return new Response(
            $this->renderView('AppBundle:Form:form.html.twig', ['form' => $clientRequestForm->createView()])
        );
    }
}
