<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Domain;

use CS\ServiceApp\Call\Domain\Call;

class Sms
{
    /** @var  int */
    private $id;

    /** @var string */
    private $to;

    /** @var string */
    private $content;

    /** @var \DateTime */
    private $createdAt;

    /** @var  Call */
    private $call;

    /** @var  \DateTime */
    private $sentAt;

    /**
     * Sms constructor.
     *
     * @param string    $to
     * @param string    $content
     * @param \DateTime $createdAt
     */
    public function __construct(string $to, string $content, \DateTime $createdAt)
    {
        $this->to = $to;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function to(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Call
     */
    public function getCall(): Call
    {
        return $this->call;
    }

    /**
     * @param Call $call
     */
    public function assignCall(Call $call)
    {
        $this->call = $call;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt(): \DateTime
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function wasSentAt(\DateTime $dateTime)
    {
        $this->sentAt = $dateTime;
    }

    /**
     * @return bool
     */
    public function isSent(): bool
    {
        return $this->sentAt instanceof \DateTime;
    }
}
