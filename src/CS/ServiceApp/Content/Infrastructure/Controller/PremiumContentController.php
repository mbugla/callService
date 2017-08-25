<?php
declare(strict_types=1);

namespace CS\ServiceApp\Content\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class PremiumContentController
{
    /** @var EngineInterface */
    private $templating;

    /**
     * PremiumContentController constructor.
     *
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function premiumAction(Request $request): Response
    {
        return new Response($this->templating->render('@App/PremiumContent/premium.html.twig'));
    }
}
