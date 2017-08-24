<?php
declare(strict_types=1);

namespace CS\ServiceApp\Form\Domain;

use CS\ServiceApp\Call\Domain\Call;

class Form
{
    private $id;

    /** @var string */
    private $question;

    /** @var  \DateTime */
    private $createdAt;

    /** @var  \DateTime */
    private $updatedAt;

    /** @var Call */
    private $call;

    /**
     * Form constructor.
     *
     * @param Call   $call
     * @param string $question
     *
     * @internal param $id
     */
    public function __construct(Call $call, $question = '')
    {
        $this->question = $question;
        $this->id = crc32($call->getCallId().time());
        $this->call = $call;
    }

    /**
     * @return Call
     */
    public function getCall(): Call
    {
        return $this->call;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

}
