<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Group;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function getCoaches()
    {
        return view('Coaches', ['coaches' => Coach::get()]);
    }

    public function note()
    {
        return view('note', ['groups' => Group::get()]);
    }

    public function myNotes()
    {
        if (!empty(Auth::id())) {
            $myGroup = Group::join('notes', 'notes.group_id', '=', 'groups.id')
                ->select('groups.id', 'groups.name', 'groups.description', 'groups.price', 'groups.number_of_lessons', 'groups.max_number_of_participants', 'groups.actual_number_of_participants')
                ->where('notes.user_id', '=', Auth::id())
                ->get();

            return view('myNotes', ['groups'=> $myGroup]);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function deleteMyGroup(Request $request)
    {
        if(Auth::check()) {
            if($myGroup = Note::where('group_id', '=', $request['group_id'])) {
                $myGroup->delete();
            }
        }
        return redirect("login")->withSuccess('You are not allowed to access');

    }

    public function getNotes()
    {
        return view('updateNotes', ['notes' => Note::where('user_id', '=', Auth::id())->get(), 'groups' => Group::get()]);
    }

    public function updateNotes(Request $request)
    {
        if(Auth::check()) {
           $newNote = Note::update([
               'name' => $request['name'],
               'surname' => $request['surname'],
               'email' => $request['email'],
               'phone' => $request['phone'],
               'group_id' => $request['group_id']
           ]);

           return view('updateNotes', ['notes' => $newNote]);

        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function getGroups()
    {
        return view('Groups', ['groups' => Group::get()]);
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
