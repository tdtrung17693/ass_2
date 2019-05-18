<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index() {
        $books = DB::table('BOOK')->leftJoin('BOOKCOVER', 'BOOKCOVER.ISBN', '=', 'BOOK.ISBN')
                                  ->leftJoin('PHOTO', 'BOOKCOVER.MultimediaID', '=', 'PHOTO.MultimediaID')
                                  ->select('BOOK.ISBN', 'BOOK.BookTitle', 'BOOK.BookDescription', 'BOOK.PublicationDate', DB::raw('[dbo].BookAvgRating(BOOK.ISBN) AS AvgRating'), 'PHOTO.PhotoURL AS BookCover')
                                  ->get();
                                
        return view('books', ['books' => $books]);
    }

    public function create() {
        return view('create-book');
    }

    public function store(Request $request) {
        $title = $request->input('title');
        $pubDate = $request->input('pub-date');
        $description = $request->input('description');
        $pages = $request->input('pages');
        $isbn = $request->input('isbn');

        $rowCount = DB::select(DB::raw("exec InsertBook :isbn, :title, :desc, :pages, :pubDate"),[
            ':isbn' => $isbn,
            ':title' => $title,
            ':desc' => $description,
            ':pages' => $pages,
            ':pubDate' => $pubDate
        ]);

        if (intval($rowCount[0]->RetValue) == 0) {
            return back()->withInput()->with('error', 'Invalid input');
        }

        return back()->with('success', "'{$title}' was successfully added.");
    }
}
