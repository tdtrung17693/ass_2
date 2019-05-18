<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create() {
        return view('user-new');
    }

    public function store(Request $request) {
        $userid = $request->input('userid');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $role = $request->input('role');
        $username = $request->input('username');
        $dob = $request->input('dob');

        $rowCount = DB::select(DB::raw("exec P_INSERT_USER :uid, :fname, :lname, :uname, :dob, :rid"),[
            ':uid' => $userid,
            ':fname' => $firstname,
            ':lname' => $lastname,
            ':uname' => $username,
            ':dob' => $dob,
            ':rid' => $role
        ]);

        return back()->with('success', "User '{$username}' was successfully added.");
    }
} 
