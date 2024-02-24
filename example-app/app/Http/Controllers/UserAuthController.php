<?php

namespace App\Http\Controllers;

use App\Console\Commands\PublishCommand;
use App\Services\RabbitMQService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class UserAuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function userRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($user) {
//            $connection = new AMQPStreamConnection('my-rabbit', 5672, 'user', 'password');
//            $channel = $connection->channel();
//
////            $channel->queue_declare('sendEmail', false, false, true, false);
//
//            $msg = new AMQPMessage($user->id);
//            $channel->basic_publish($msg, '', 'send-email');
//
//
//            $channel->close();
//            $connection->close();

            $rabbitMQService = new RabbitMQService();
            $queue = 'send-email';
            $rabbitMQService->publish($user, $queue);

            return redirect()->route('verification.notice');
        }

        return redirect()->intended();
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('Dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}

