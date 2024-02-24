<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('my-rabbit', 5672, 'user', 'password');
    }

    public function publish($user, $queue)
    {

        $channel = $this->connection->channel();
//            $channel->queue_declare('sendEmail', false, false, true, false);
        $msg = new AMQPMessage($user->id);
        $channel->basic_publish($msg, '', $queue);


        $channel->close();
        $this->connection->close();
    }

    public function consume()
    {
        $channel = $this->connection->channel();

//        $channel->queue_declare('sendEmail', false, false, true, false);

        $callback = function ($msg) {
            $user = User::find($msg->body);
            event(new Registered($user));
        };

        $channel->basic_consume('send-email', '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
