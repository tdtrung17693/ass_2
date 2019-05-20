<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index($BoxID = 1) {
        // SELECT M.BoxName, M.BoxID FROM USER_JOIN_BOX
        // JOIN NETWORK_USERS ON USER_JOIN_BOX.UserID = NETWORK_USERS.UserID
        // JOIN MESSAGE_BOX M ON M.BoxID = USER_JOIN_BOX.BoxID
        // WHERE USER_JOIN_BOX.UserID = 1
        $allMsgBox = DB::table('USER_JOIN_BOX')->join('NETWORK_USERS', 'USER_JOIN_BOX.UserID', '=', 'NETWORK_USERS.UserID')
                                                ->join('MESSAGE_BOX', 'MESSAGE_BOX.BoxID', '=', 'USER_JOIN_BOX.BoxID')
                                                ->select('MESSAGE_BOX.BoxName', 'MESSAGE_BOX.BoxID')
                                                ->where('USER_JOIN_BOX.UserID', '=', 1)
                                                ->get();

        // SELECT * FROM MESSAGE
        // JOIN MESSAGE_BOX M ON MESSAGE.BoxID = M.BoxID
        // JOIN NETWORK_USERS NU ON MESSAGE.UserID = NU.UserID
        // WHERE M.BoxID = 1
        // ORDER BY MESSAGE.SentOn
        $firstMessageBox = DB::table('MESSAGE')->join('MESSAGE_BOX', 'MESSAGE_BOX.BoxID', '=', 'MESSAGE.BoxID')
                                                ->join('NETWORK_USERS', 'NETWORK_USERS.UserID', '=', 'MESSAGE.UserID')
                                                ->join('AVATAR', 'NETWORK_USERS.UserID', '=', 'AVATAR.UserID')
                                                ->join('PHOTO', 'AVATAR.MultimediaID', '=', 'PHOTO.MultimediaID')
                                                ->select('MESSAGE.SentOn', 'MESSAGE.MessageContent', 'NETWORK_USERS.Username', 'PHOTO.Url AS Avatar', 'NETWORK_USERS.UserID')
                                                ->where('MESSAGE.BoxID', '=', $BoxID)
                                                ->orderBy('MESSAGE.SentOn')
                                                ->get();

        $boxMembers = DB::table('USER_JOIN_BOX')->join('NETWORK_USERS', 'USER_JOIN_BOX.UserID', '=', 'NETWORK_USERS.UserID')
                                                ->join('MESSAGE_BOX', 'MESSAGE_BOX.BoxID', '=', 'USER_JOIN_BOX.BoxID')
                                                ->join('AVATAR', 'NETWORK_USERS.UserID', '=', 'AVATAR.UserID')
                                                ->join('PHOTO', 'AVATAR.MultimediaID', '=', 'PHOTO.MultimediaID')
                                                ->select('NETWORK_USERS.Username', 'NETWORK_USERS.UserID', 'PHOTO.Url AS Avatar')
                                                ->where('USER_JOIN_BOX.BoxID', '=', $BoxID)
                                                ->get();
        
        return view('messenger', ['MsgBoxes' => $allMsgBox, 'CurrentBoxID' => $BoxID, 'Current' => $firstMessageBox, 'Members' => $boxMembers]);
        
    }

    public function view_mb_msgs($BoxID, $UserID) {
        if (!DB::table('NETWORK_USERS')->where('UserID', '=', $UserID)->exists()) return abort(404);
        $currentMember = DB::table('NETWORK_USERS')->select(DB::raw('FirstName + \' \' +LastName AS FullName'), 'Username')->where('UserID', '=', $UserID)->first();

        $allMsgBox = DB::table('USER_JOIN_BOX')->join('NETWORK_USERS', 'USER_JOIN_BOX.UserID', '=', 'NETWORK_USERS.UserID')
                                                ->join('MESSAGE_BOX', 'MESSAGE_BOX.BoxID', '=', 'USER_JOIN_BOX.BoxID')
                                                ->select('MESSAGE_BOX.BoxName', 'MESSAGE_BOX.BoxID')
                                                ->where('USER_JOIN_BOX.UserID', '=', 1)
                                                ->get();

        // SELECT * FROM MESSAGE
        // JOIN MESSAGE_BOX M ON MESSAGE.BoxID = M.BoxID
        // JOIN NETWORK_USERS NU ON MESSAGE.UserID = NU.UserID
        // WHERE M.BoxID = 1
        // ORDER BY MESSAGE.SentOn
        $mbMsgs = DB::select(DB::raw('exec P_FIND_MESSAGE_FROM_USER_ID :UserID, :BoxID'), [
            ':UserID' => $UserID,
            ':BoxID' => $BoxID
        ]);

        $boxMembers = DB::table('USER_JOIN_BOX')->join('NETWORK_USERS', 'USER_JOIN_BOX.UserID', '=', 'NETWORK_USERS.UserID')
                                                ->join('MESSAGE_BOX', 'MESSAGE_BOX.BoxID', '=', 'USER_JOIN_BOX.BoxID')
                                                ->join('AVATAR', 'NETWORK_USERS.UserID', '=', 'AVATAR.UserID')
                                                ->join('PHOTO', 'AVATAR.MultimediaID', '=', 'PHOTO.MultimediaID')
                                                ->select('NETWORK_USERS.Username', 'NETWORK_USERS.UserID', 'PHOTO.Url AS Avatar')
                                                ->where('USER_JOIN_BOX.BoxID', '=', $BoxID)
                                                ->get();
        
        return view('messenger-member-msg', ['MsgBoxes' => $allMsgBox, 'CurrentBoxID' => $BoxID, 'CurrentMbID' => $UserID, 'Username' => $currentMember->Username, 'FullName' => $currentMember->FullName,'MbMessages' => $mbMsgs, 'Members' => $boxMembers]);
        
    }


}
