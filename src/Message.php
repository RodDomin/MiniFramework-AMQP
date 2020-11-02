<?php


namespace MiniFrameWork;


use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    private AMQPMessage $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    public function getBody()
    {
        return $this->message->body;
    }

    public function ack(): void
    {
        $this->message->ack();
    }
}