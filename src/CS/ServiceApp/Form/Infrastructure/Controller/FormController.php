<?php
declare(strict_types=1);

namespace CS\ServiceApp\Form\Infrastructure\Controller;

use CS\ServiceApp\Form\Domain\FormRepository;
use CS\ServiceApp\Form\Infrastructure\Type\ClientRequestForm;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class FormController
{
    /** @var EngineInterface */
    private $templating;
    /** @var FormFactory */
    private $formFactory;

    /** @var FormRepository */
    private $formRepository;

    /**
     * FormController constructor.
     *
     * @param EngineInterface $templating
     * @param FormFactory     $formFactory
     * @param FormRepository  $formRepository
     */
    public function __construct(EngineInterface $templating, FormFactory $formFactory, FormRepository $formRepository)
    {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->formRepository = $formRepository;
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return Response
     */
    public function formAction($id, Request $request)
    {
        $form = $this->formRepository->load($id);

        $clientRequestForm = $this->formFactory->create(ClientRequestForm::class, $form);

        if ($request->getMethod() == 'POST') {

            $clientRequestForm->handleRequest($request);

            if ($clientRequestForm->isValid()) {
                $form = $clientRequestForm->getData();
                $form->setUpdatedAt(new \DateTime());
                $this->formRepository->store($form);

                return new Response($this->templating->render('AppBundle:Form:thankyou.html.twig'));
            }
        }

        return new Response(
            $this->templating->render('AppBundle:Form:form.html.twig', ['form' => $clientRequestForm->createView()])
        );
    }
}
