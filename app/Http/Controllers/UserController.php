<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $users = DB::table("NETWORK_USERS")->leftJoin('AVATAR', 'NETWORK_USERS.UserID', '=', 'AVATAR.UserID')
                                  ->leftJoin('PHOTO', 'AVATAR.MultimediaID', '=', 'PHOTO.MultimediaID')
                                  ->select("NETWORK_USERS.UserID", DB::raw("(NETWORK_USERS.FirstName + ' ' + NETWORK_USERS.LastName) AS FullName"), "NETWORK_USERS.Username", "PHOTO.Url AS Avatar")
                                  ->get();

        return view('users', [
            'users' => $users
        ]);
    }

    public function view(Request $request, $UserID) {
        if (!is_numeric($UserID)) return abort(404);
        if (!DB::table('NETWORK_USERS')->where('UserID', '=', $UserID)->exists()) return abort(404);

        $filter = $request->input('filter');
        $user = DB::table("NETWORK_USERS")->leftJoin('AVATAR', 'NETWORK_USERS.UserID', '=', 'AVATAR.UserID')
                                  ->join('USER_ROLE', 'USER_ROLE.RoleID', '=', 'NETWORK_USERS.RoleID')
                                  ->leftJoin('PHOTO', 'AVATAR.MultimediaID', '=', 'PHOTO.MultimediaID')
                                  ->select("NETWORK_USERS.UserID", "NETWORK_USERS.FirstName", "NETWORK_USERS.LastName", "NETWORK_USERS.Username", "PHOTO.Url AS Avatar")
                                  ->where('NETWORK_USERS.UserID', '=', $UserID)
                                  ->first();
        
        $ownedBooks = DB::table('OWN')->join('BOOKCOPY', function ($q) {
            $q->on('BOOKCOPY.BookCopyID', '=', 'OWN.BookCopyID')
              ->on('BOOKCOPY.ISBN', '=', 'OWN.ISBN');
        })->join('BOOK', 'BOOK.ISBN', '=', 'OWN.ISBN')
          ->leftJoin('BOOKCOVER', 'BOOKCOVER.ISBN', '=', 'BOOK.ISBN')
          ->leftJoin('PHOTO', 'BOOKCOVER.MultimediaID', '=', 'PHOTO.MultimediaID')
          ->select('BOOK.ISBN', 'BOOK.BookTitle', 'PHOTO.Url AS BookCover')
          ->where('OWN.UserID', '=', $UserID)
          ->get();

        $createdComms = DB::select(DB::raw('exec show_communities_created_by :id'), [':id'=>$UserID]);
        $activeMsgBox = DB::select(DB::raw("EXEC P_FIND_NUMBER_OF_MESSAGE_BY_A_USER :FName, :LName, :filter"),[
            ":FName" => $user->FirstName,
            ":LName" => $user->LastName,
            ":filter" => $filter ?? 0
        ]);

        
        return view('user-profile', ['user' => $user, 'filter' => $filter, 'OwnedBooks' => $ownedBooks, 'ActiveMsgBox' => $activeMsgBox, 'CreatedComms' => $createdComms]);
    }

    public function create() {
        return view('user-new');
    }

    public function store(Request $request) {
        $userid = $request->input('userid') ?? -1;
        $firstname = $request->input('firstname') ?? '' ;
        $lastname = $request->input('lastname') ?? '';
        $role = $request->input('role') ?? 99999;
        $username = $request->input('username') ?? '';
        $dob = $request->input('dob');
        $rowCount = DB::select(DB::raw("exec P_INSERT_USER :uid, :fname, :lname, :uname, :dob, :rid"),[
            ':uid' => $userid,
            ':fname' => $firstname,
            ':lname' => $lastname,
            ':uname' => $username,
            ':dob' => date('Y-m-d\TH:i:s', strtotime($dob)),
            ':rid' => $role
        ]);

        $rowCount = intval($rowCount[0]->RetValue);
        if ($rowCount == -1) {
            return back()->withInput()->with('error', 'UserID has been already existed.');
        } else if ($rowCount == -2) {
            return back()->withInput()->with('error', 'Role does not existed.');
        } else if ($rowCount == -3) {
            return back()->withInput()->with('error', 'Length of Last name, First name and Username must be less than 20 characters');
        }

        return back()->with('success', "User '{$username}' was successfully added.");
    }

    public function edit($id) {
        if (!DB::table('NETWORK_USERS')->where('UserID', $id)->exists()) {
            return abort(404);
        }
        $user = DB::table('NETWORK_USERS')->where('UserID', $id)->first();
        return view('user-edit', [
            'UserID' => $user->UserID,
            'FirstName' => $user->FirstName,
            'LastName' => $user->LastName,
            'Username' => $user->Username,
            'DOB' => $user->DOB,
            'Role' => $user->RoleID
        ]);
    }

    public function update(Request $request, $UserID) {
        if (!DB::table('NETWORK_USERS')->where('UserID', $UserID)->exists()) {
            return abort(404);
        }

        $firstname = $request->input('firstname') ?? '' ;
        $lastname = $request->input('lastname') ?? '';
        $role = $request->input('role') ?? 99999;
        $dob = $request->input('dob');

        if ($firstname == '' || $firstname == null) {
            return back()->withInput()->with('error', 'First name cannot be empty');
        }

        if ($lastname == '' || $lastname == null) {
            return back()->withInput()->with('error', 'Last name cannot be empty');
        }

        if ($role == '' || $role == null) {
            return back()->withInput()->with('error', 'Role cannot be empty');
        }

        if (!DB::table('USER_ROLE')->where('RoleID', '=', $role)->exists()) {
            return back()->withInput()->with('error', 'Role does not exist');
        }

        $rowCount = DB::table('NETWORK_USERS')->where('UserID', $UserID)->update([
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'RoleID' => $role
        ]);

        if ($rowCount == 0) {
            return back()->withInput()->with('error', 'The user was not successfully updated');
        }

        return back()->with('success', 'The user was successfully updated');
    }

    public function destroy(Request $request, $UserID, $UName) {
        if (!DB::table('NETWORK_USERS')->where('UserID', $UserID)->exists()) {
            return abort(404);
        }

        if(DB::table('NETWORK_USERS')->where('UserID', $UserID)->delete() == 0) {
            return redirect('/')->with('error', "The user {$UName} was successfully deleted");
        }

        return back()->with('success', "The user {$UName} was successfully deleted");
    }
} 
