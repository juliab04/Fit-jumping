<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController
{
    public function dashboard()
    {
        if (Auth::id() === User::where('id', '=', 3)) {
            return redirect()->route('/admin/getUsers');
        }

        return redirect()->route('dashboard');
    }

    public function getUsers()
    {
        if (Auth::check()) {
            $users = User::paginate(5);
            $quantity = User::count();

            return view('admin.users',  ['users'=> $users, 'quantity' => $quantity]);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function getUserPanel(int $id)
    {
        if(Auth::check()) {
            $user = User::where('id', '=', $id)->first();
            return view('admin.userPanel', ['user'=> $user]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function deleteUser(Request $request)
    {
        if(Auth::check()) {
            if($user = User::where('id', '=', $request['id'])) {
                $user->delete();
            }
        }
        return redirect("/admin/getUsers");
    }

    public function updateUser(Request $request)
    {
//        print_r($request); die;
        if(Auth::check()) {
            $newUser = User::where('id', '=', $request['id'])->first();
            $newUser ->update([
                'name' => $request['name'],
                'email' => $request['email'],
            ]);

            return view('admin.userPanel', ['user' => $newUser]);

        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function search(Request $request)
    {
        $s = $request->s;
        $quantity = User::count();
        $users = User::where('name', 'LIKE', "%{$s}%")->orderBy('name')->paginate(5);
        return view('admin.users',  ['users'=> $users, 'quantity' => $quantity]);
    }

}
