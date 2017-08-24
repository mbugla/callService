<?php

namespace CS\ServiceApp\Sms\Infrastructure\Doctrine;

use CS\ServiceApp\Sms\Domain\Sms;
use CS\ServiceApp\Sms\Domain\SmsRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineSmsRepository extends EntityRepository implements SmsRepository
{

    /**
     * @param Sms $sms
     */
    public function store(Sms $sms)
    {
        $this->_em->persist($sms);
        $this->_em->flush();
    }

    /**
     * @param string $callId
     *
     * @return null|object
     */
    public function findByCallId(string $callId)
    {
        return $this->findOneBy(['call' => $callId]);
    }
}
