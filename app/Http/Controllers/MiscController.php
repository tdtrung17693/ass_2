<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiscController extends Controller {
    public function search_endpoint(Request $request) {
        $scope =  $request->input('search-scope');

        if ($scope == 'author') {
            $result = DB::select(DB::raw("exec SearchAuthorByName {$request->input("q")}"));

            return view('search-result', ['scope' => $scope, 'result' => $result, 'title' =>  "Search for author: {$request->input('q')}"]);
        } else if ($scope == 'book') {
            $result = DB::select(DB::raw("exec SearchBooksByName :Param1"),[
                ':Param1' => $request->input('q')
            ]);

            return view('search-result', ['scope' => $scope, 'result' => $result, 'title' =>  "Search for book: {$request->input('q')}"]);
        }
    }
}