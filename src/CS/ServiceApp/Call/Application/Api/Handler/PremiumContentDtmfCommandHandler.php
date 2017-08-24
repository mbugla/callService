<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Application\Api\Handler;

use CS\ServiceApp\Call\Domain\CallRepository;
use CS\ServiceApp\Call\Application\Api\Command\DtmfCommand;
use CS\ServiceApp\Sms\Domain\Sms;
use CS\ServiceApp\Sms\Domain\SmsRepository;

class PremiumContentDtmfCommandHandler implements DtmfCommandHandler
{
    /** @var string */
    private $premiumContentUrl;

    /** @var CallRepository */
    private $callRepository;

    /** @var SmsRepository */
    private $smsRepository;

    /**
     * PremiumContentDtmfCommandHandler constructor.
     *
     * @param string         $premiumContentUrl
     * @param CallRepository $callRepository
     * @param SmsRepository  $smsRepository
     */
    public function __construct(
        string $premiumContentUrl,
        CallRepository $callRepository,
        SmsRepository $smsRepository
    ) {
        $this->premiumContentUrl = $premiumContentUrl;
        $this->callRepository = $callRepository;
        $this->smsRepository = $smsRepository;
    }

    /**
     * @param DtmfCommand $dtmfCommand
     */
    public function handleDTMF(DtmfCommand $dtmfCommand)
    {
        $dtmf = $dtmfCommand->getDtmf();
        $call = $this->callRepository->load($dtmf->getCallId());

        $sms = new Sms(
            $call->getFrom(),
            'Your premium content is available here: '.$this->premiumContentUrl,
            new \DateTime()
        );

        $sms->assignCall($call);

        $this->smsRepository->store($sms);
    }

}
