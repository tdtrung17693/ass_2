<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function index(Request $request) {
        $filter = $request->input('filter');

        if (!is_numeric($filter) || $filter == NULL) {

            $communities = DB::table('COMMUNITY')
                    ->leftJoin('USER_JOIN_COMMUNITY', 'COMMUNITY.CommunityID', '=', 'USER_JOIN_COMMUNITY.CommunityID')
                    ->select(
                        'COMMUNITY.CommunityID', 'COMMUNITY.CommunityName',
                        'COMMUNITY.CommunityDescription', 'COMMUNITY.CreatorID',
                        DB::raw('COUNT(USER_JOIN_COMMUNITY.UserID) AS NumberOfUsers'))
                    ->groupBy('COMMUNITY.CommunityID', 'COMMUNITY.CommunityName', 'COMMUNITY.CommunityDescription', 'COMMUNITY.CreatorID')
                    ->get();
        } else { 
            $filter = intval($filter);
            $communities = DB::select(DB::raw('exec show_communities_with_more_than_n_users :n'), [':n' => $filter]);
        }

        return view('communities', ['Comms' => $communities, 'filter' => $filter]);
    }

    public function create() {
        return view('comm-new');
    }

    public function store(Request $request) {
        $name = $request->input('comm-name');
        $id = $request->input('comm-id');
        $description = $request->input('comm-desc');
        $creatorId = 1;

        $rowCount = DB::select(DB::raw("exec p_create_community :id, :name, :desc, 1"),[
            ':id' => $id,
            ':name' => $name,
            ':desc' => $description
        ]);

        if (intval($rowCount[0]->RetValue) == -1) {
            return back()->withInput()->with('error', 'This ID is already chosen');
        }

        if (intval($rowCount[0]->RetValue) == -2) {
            return back()->withInput()->with('error', 'The creator ID does not exist');
        }

        return back()->with('success', "{$name} was successfully added.");
    }

    public function edit($id) {
        if (!is_numeric($id)) return abort(404);

        if (!DB::table('COMMUNITY')->where('CommunityID', '=', $id)->exists()) return abort(404);

        $comm = DB::table('COMMUNITY')->select('*')->where('CommunityID', '=', $id)->first();

        return view('comm-edit', ['Name'=>$comm->CommunityName, 'Desc'=>$comm->CommunityDescription, 'CommID' =>$comm->CommunityID]);
    }

    public function update(Request $request, $id) {
        if (!is_numeric($id)) return abort(404);

        if (!DB::table('COMMUNITY')->where('CommunityID', '=', $id)->exists()) return abort(404);

        $name = $request->input('comm-name');
        $description = $request->input('comm-desc');

        if ($name == '' || $name == null) {
            return back()->withInput()->with('error', 'Community\'s name cannot be empty');
        }

        $rowCount = DB::table('COMMUNITY')->where('CommunityID', $id)->update([
            'CommunityName' => $name,
            'CommunityDescription' => $description
        ]);

        if ($rowCount == 0) {
            return back()->withInput()->with('error', 'The community was not successfully updated');
        }

        return back()->with('success', 'The community was successfully updated');
    }

    public function destroy(Request $request, $id) {
        if (!is_numeric($id)) return abort(404);

        if (!DB::table('COMMUNITY')->where('CommunityID', '=', $id)->exists()) return abort(404);

        if(DB::table('COMMUNITY')->where('CommunityID', $id)->delete() == 0) {
            return back()->with('error', 'The community was not successfully deleted');
        }

        return back()->with('success', 'The community was successfully deleted');
    }
}
