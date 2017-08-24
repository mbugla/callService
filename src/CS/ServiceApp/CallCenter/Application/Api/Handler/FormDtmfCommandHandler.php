<?php

namespace CS\ServiceApp\CallCenter\Application\Api\Handler;

use CS\ServiceApp\Call\Domain\CallRepository;
use CS\ServiceApp\CallCenter\Application\Api\Command\DtmfCommand;
use CS\ServiceApp\Form\Application\FormFactory;
use CS\ServiceApp\Form\Domain\FormRepository;
use CS\ServiceApp\Sms\Domain\Sms;
use CS\ServiceApp\Sms\Domain\SmsRepository;

class FormDtmfCommandHandler implements DtmfCommandHandler
{
    /** @var CallRepository */
    private $callRepository;

    /** @var  FormRepository */
    private $formRepository;

    /** @var SmsRepository */
    private $smsRepository;

    /**
     * DtmfCommandHandler constructor.
     *
     * @param CallRepository $callRepository
     * @param FormRepository $formRepository
     * @param SmsRepository  $smsRepository
     *
     * @internal param SmsCenter $smsCenter
     */
    public function __construct(
        CallRepository $callRepository,
        FormRepository $formRepository,
        SmsRepository $smsRepository
    ) {
        $this->callRepository = $callRepository;
        $this->formRepository = $formRepository;
        $this->smsRepository = $smsRepository;
    }

    public function handleDTMF(DtmfCommand $dtmfCommand)
    {
        $dtmf = $dtmfCommand->getDtmf();

        switch ($dtmf->getDtmf()) {
            case 1:
                $call = $this->callRepository->load($dtmf->getCallId());

                $form = FormFactory::create($call);
                $this->formRepository->store($form);

                $sms = new Sms(
                    $call->getFrom(),
                    'Your form link: '.'http://buglamarek.usermd.net/form/'.$form->getId(),
                    new \DateTime()
                );

                $sms->assignCall($call);

                $this->smsRepository->store($sms);
        }
    }
}
