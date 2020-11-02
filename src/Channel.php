<?php


namespace MiniFrameWork;

use Bramus\Monolog\Formatter\ColoredLineFormatter;
use Bramus\Monolog\Formatter\ColorSchemes\TrafficLight;
use Monolog\Handler\StreamHandler;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Monolog\Logger;

class Channel
{
    private AMQPChannel $channel;
    private string $queueName;
    private Logger $logger;

    public function __construct(AMQPChannel $channel, string $queueName)
    {
        $this->channel = $channel;
        $this->queueName = $queueName;

        $this->logger = new Logger('Channel');

        $streamHandler = new StreamHandler('php://stdout');
        $streamHandler->setFormatter(new ColoredLineFormatter(new TrafficLight()));

        $this->logger->pushHandler($streamHandler);
    }


    public function consume(QueueProcessorInterface $processor)
    {
        $this->logger->info('Queue consume started for: ' . $this->queueName);
        $this->channel->queue_declare($this->queueName, false, false, false, false);
        $callback = fn(AMQPMessage $message) => $processor->process(new Message($message));

        $this->channel->basic_consume(
            $this->queueName, '', false, false, false, false, $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function publish($message)
    {
        $this->channel->basic_publish($message, '', $this->queueName);
    }
}