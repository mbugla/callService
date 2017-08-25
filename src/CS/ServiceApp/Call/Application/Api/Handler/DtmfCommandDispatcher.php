<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Application\Api\Handler;

use CS\ServiceApp\Call\Application\Api\Command\DtmfCommand;

class DtmfCommandDispatcher implements DtmfCommandHandler
{

    /**
     * @var PremiumContentDtmfCommandHandler
     */
    private $premiumContentDtmfCommandHandler;
    /**
     * @var FormDtmfCommandHandler
     */
    private $formDtmfCommandHandler;

    /**
     * DtmfHandlerDispatcher constructor.
     *
     * @param PremiumContentDtmfCommandHandler $premiumContentDtmfCommandHandler
     * @param FormDtmfCommandHandler           $formDtmfCommandHandler
     */
    public function __construct(PremiumContentDtmfCommandHandler $premiumContentDtmfCommandHandler, FormDtmfCommandHandler $formDtmfCommandHandler)
    {
        $this->premiumContentDtmfCommandHandler = $premiumContentDtmfCommandHandler;
        $this->formDtmfCommandHandler = $formDtmfCommandHandler;
    }

    public function handleDTMF(DtmfCommand $dtmfCommand)
    {
        $dtmf = $dtmfCommand->getDtmf();

        switch ($dtmf->getDtmf()) {
            case 1:
                $this->premiumContentDtmfCommandHandler->handleDTMF($dtmfCommand);
                break;
            case 2:
                $this->formDtmfCommandHandler->handleDTMF($dtmfCommand);
                break;
        }
    }
}
