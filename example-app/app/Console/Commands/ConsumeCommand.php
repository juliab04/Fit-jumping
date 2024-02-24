<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\RabbitMQService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use function Symfony\Component\Translation\t;

class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

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
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->consume();

//        $connection = new AMQPStreamConnection('my-rabbit', 5672, 'user', 'password');
//        $channel = $connection->channel();
//
////        $channel->queue_declare('send-email', false, false, true, false);
//
//
//        $callback = function ($msg) {
////            print_r($msg->body);
//            $user = User::find($msg->body);
//            event(new Registered($user));
//        };
//
//        $channel->basic_consume('send-email', '', false, true, false, false, $callback);
//
//        try {
//            $channel->consume();
//        } catch (\Throwable $exception) {
//            echo $exception->getMessage();
//        }

    }
}
