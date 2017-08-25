<?php
declare(strict_types=1);

namespace CS\ServiceApp\Form\Domain;

use CS\ServiceApp\Call\Domain\Call;

class Form
{
    /** @var  \DateTime | null */
    private $answerDate;

    /** @var int  */
    private $id;

    /** @var string */
    private $question;

    /** @var  string */
    private $firstName;

    /** @var  string */
    private $lastName;

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
     * @param string $firstName
     * @param string $lastName
     *
     */
    public function __construct(Call $call, $question = '', $firstName = '', $lastName = '')
    {
        $this->question = $question;
        $this->id = crc32($call->getCallId().time());
        $this->call = $call;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param \DateTime $answerDate
     */
    public function receivedAnswer(\DateTime $answerDate)
    {
        $this->answerDate = $answerDate;
    }

    /**
     * @return bool
     */
    public function isAnswered() : bool
    {
        return $this->answerDate instanceof \DateTime;
    }

    /**
     * @return \DateTime|null
     */
    public function getAnswerDate()
    {
        return $this->answerDate;
    }

}
