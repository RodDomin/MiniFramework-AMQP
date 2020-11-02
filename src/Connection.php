<?php

namespace MiniFrameWork;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use parallel\Runtime;

class Connection
{
    private string $host;
    private string $user;
    private string $password;
    private int $port;
    private AMQPStreamConnection $amqpConnection;

    public function init() {
        $this->amqpConnection = new AMQPStreamConnection(
            $this->host, $this->port, $this->user, $this->password
        );
    }

    public function close() {
        $this->amqpConnection->close();
    }

    public function getChannel(string $queueName): Channel
    {
        return new Channel($this->amqpConnection->channel(), $queueName);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }



}