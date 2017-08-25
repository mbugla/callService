<?php
declare(strict_types=1);

namespace CS\ServiceApp\Client\Domain;

use CS\ServiceApp\Call\Domain\Call;
use Doctrine\Common\Collections\ArrayCollection;

class Client
{

    private $id;

    private $phoneNumber;

    private $calls;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        $this->calls = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getCalls(): ArrayCollection
    {
        return $this->calls;
    }

    public function madeACall(Call $call)
    {
        $this->calls->add($call);
    }

    public function removeCall(Call $call)
    {
        $this->calls->removeElement($call);
    }
}
