<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function note()
    {
        return view('note', ['groups' => Group::get()]);
    }

    public function sendSms(Request $request)
    {
        $smsSender = $request;
        $smsSender->send($request['phone'], 'Здесь текст сообщений');

    }

    public function userNote(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:notes',
            //'phone' => 'required|min:11',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return Note::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'group_id' => $data['group_id'],
            'user_id' => Auth::id(),
        ]);
    }


}
