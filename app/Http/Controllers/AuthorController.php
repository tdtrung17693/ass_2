<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function insert_from_book(Request $request) {
        $name = $request->input('author-name');
        $desc = $request->input('author-desc');

        $r = DB::select(DB::raw('EXEC InsertAuthor :n, :d'), [
            ':n' => $name,
            ':d' => $desc
        ]);

        if ($r[0]->RetValue == -1) {
            return response()->json([
                'error' => 'Lenght of author name must be greater than 10'
            ]);
        }

        return response()->json([
            'success' => 'New author ' . $name . ' was added',
            'author' => [
                'AuthorName' => $name,
                'AuthorID' => $r[0]->InsertedID
            ]
        ]);
    }

    public function view($id) {
        if (!is_numeric($id)) return abort(404);
        if (!DB::table('AUTHOR')->where('AuthorID', '=', $id)->exists()) return abort(404);

        $bookOfAuthor = DB::select(DB::raw('exec SearchBookOfAuthor :AuthorID'), [':AuthorID' => $id]);
        $author = DB::table('AUTHOR')->select('AuthorName', 'AuthorID')->where('AuthorID', '=', $id)->first();

        return view('author', ['Author'=>$author, 'Books' => $bookOfAuthor]);
    }

    public function edit($id) {
        if (!DB::table('BOOK')->where('ISBN', $id)->exists()) {
            return abort(404);
        }
        $book = DB::table('BOOK')->where('ISBN', $id)->first();
        return view('edit-book', ['title' => $book->BookTitle, 'ISBN' => $book->ISBN, 'description' => $book->BookDescription, 'pubdate' => $book->PublicationDate, 'pnum' => $book->NumberOfPages]);
    }

    public function update(Request $request, $id) {
        if (!DB::table('BOOK')->where('ISBN', $id)->exists()) {
            return abort(404);
        }

        $title = $request->input('title');
        $pubDate = $request->input('pub-date');
        $description = $request->input('description');
        $pages = $request->input('pages');

        if ($title == '' || $title == null) {
            return back()->withInput()->with('error', 'Book title cannot be empty');
        }

        if ($pages <= 0 || $pages == null) {
            return back()->withInput()->with('error', 'Number of pages must be greater than 0');
        }

        $rowCount = DB::table('BOOK')->where('ISBN', $id)->update([
            'BookTitle' => $title,
            'BookDescription' => $description,
            'NumberOfPages' => $pages,
            'PublicationDate' => $pubDate
        ]);

        if ($rowCount == 0) {
            return back()->withInput()->with('error', 'The book was not successfully updated');
        }

        return back()->with('success', 'The book was successfully updated');
    }

    public function destroy(Request $request, $id) {
        if (!DB::table('BOOK')->where('ISBN', $id)->exists()) {
            return abort(404);
        }

        if(DB::table('BOOK')->where('ISBN', $id)->delete() == 0) {
            return redirect('/')->with('error', 'The book was not successfully deleted');
        }

        return redirect('/')->with('success', 'The book was successfully deleted');
    }
}
