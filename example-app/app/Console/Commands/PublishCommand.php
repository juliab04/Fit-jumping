<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('my-rabbit', 5672, 'user', 'password');
        $channel = $connection->channel();

//        $channel->queue_declare('send-email', false, false, true, false);


        $msg = new AMQPMessage('hjvhgvh');
        $channel->basic_publish($msg, '', 'send-email');

        echo " [x] Email send by user \n";

        $channel->close();
        $connection->close();
    }
}
