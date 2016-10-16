<?php

namespace TheliaEmailManager\Entity;

/**
 * @author Gilles Bourgeat <gilles.bourgeat@gmail.com>
 */
class EmailEntity
{
    /** @var string */
    protected $id = "";

    /** @var string */
    protected $subject = "";

    /** @var string[] */
    protected $from = [];

    /** @var string[] */
    protected $to = [];

    /** @var string */
    protected $traceId = "";

    /** @var string */
    protected $body = "";

    /** @var string[] */
    protected $replyTo = [];

    /** @var string[] */
    protected $Cc = [];

    /** @var string[] */
    protected $Bcc = [];

    /** @var \DateTime */
    protected $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param \string[] $from
     * @return $this
     */
    public function setFrom(array $from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param \string[] $to
     * @return $this
     */
    public function setTo(array $to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraceId()
    {
        return $this->traceId;
    }

    /**
     * @param string $traceId
     * @return $this
     */
    public function setTraceId($traceId)
    {
        $this->traceId = $trace;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param \string[] $replyTo
     * @return $this
     */
    public function setReplyTo(array $replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getCc()
    {
        return $this->Cc;
    }

    /**
     * @param \string[] $Cc
     * @return $this
     */
    public function setCc(array $Cc)
    {
        $this->Cc = $Cc;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getBcc()
    {
        return $this->Bcc;
    }

    /**
     * @param \string[] $Bcc
     * @return $this
     */
    public function setBcc(array $Bcc)
    {
        $this->Bcc = $Bcc;
        return $this;
    }

    /**
     * @param \Swift_Mime_Message $message
     * @return $this
     */
    public function hydrateBySwiftMimeMessage(\Swift_Mime_Message $message)
    {
        $this
            ->setBody($message->getBody())
            ->setSubject($message->getSubject())
            ->setTo($message->getTo())
            ->setCc($message->getCc())
            ->setBcc($message->getBcc())
            ->setReplyTo($message->getReplyTo());

        return $this;
    }
}