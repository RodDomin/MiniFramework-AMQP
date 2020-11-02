# MiniFramework - RabbitMQ Module

Módulo de microservices do mini-framework, é um wrapper do php-amqplib.

## USO
Para cada Queue será necessário um script, pois o Script que vem do
AMQP é bloqueante.

Exemplo:
```PHP
$connection = new Connection();

$connection->setHost('localhost');
$connection->setPort(5672);
$connection->setUser('guest');
$connection->setPassword('guest');

$connection->init();
$channel = $connection->getChannel('messages');

$channel->consume(new class implements QueueProcessorInterface {
    public function process(Message $message): void
    {
        $this->logger->info("[x] mensagem recebida: " . $message->getBody() . PHP_EOL);
    
        $message->ack();
    }
});
``` 