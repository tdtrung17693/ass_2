<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index() {
        $books = DB::table('BOOK')->leftJoin('BOOKCOVER', 'BOOKCOVER.ISBN', '=', 'BOOK.ISBN')
                                  ->leftJoin('PHOTO', 'BOOKCOVER.MultimediaID', '=', 'PHOTO.MultimediaID')
                                  ->select('BOOK.ISBN', 'BOOK.BookTitle', 'BOOK.PublicationDate', 'BOOK.AverageRating AS AvgRating', 'PHOTO.Url AS BookCover')
                                  ->orderBy('BOOK.PublicationDate')
                                  ->get();
        
                        //           select [BOOK].[ISBN]
                        //           , STRING_AGG(AUTHOR.AuthorName, ', ') as Authors
                        //          , STRING_AGG(AUTHOR.AuthorID, ', ') as AuthorIDs from [BOOK]
                        //   left join [AUTHOR_WRITE_BOOK] on [AUTHOR_WRITE_BOOK].[ISBN] = [BOOK].[ISBN]
                        //   left join [AUTHOR] on [AUTHOR].[AuthorID] = [AUTHOR_WRITE_BOOK].[AuthorID]
                        //   GROUP BY [BOOK].[ISBN]
        $bookWithAuthors = DB::table('BOOK')
                                  ->leftJoin('AUTHOR_WRITE_BOOK', 'AUTHOR_WRITE_BOOK.ISBN', '=', 'BOOK.ISBN')
                                  ->leftJoin('AUTHOR', 'AUTHOR.AuthorID', 'AUTHOR_WRITE_BOOK.AuthorID')
                                  ->select('BOOK.ISBN', DB::raw('STRING_AGG(AUTHOR.AuthorName, \',\') AS AuthorNames'), DB::raw('STRING_AGG(AUTHOR.AuthorID, \',\') AS AuthorIDs'))
                                  ->groupBy('BOOK.ISBN')
                                  ->get();
        
        $bookMap = [];


        foreach($bookWithAuthors as $book) {
            if (!$book->AuthorNames || !$book->AuthorIDs) { $bookMap[$book->ISBN] = null; continue; }
            $bookMap[$book->ISBN] = array_combine(explode(',', $book->AuthorIDs), explode(',', $book->AuthorNames));
        }
        
        return view('books', ['books' => $books, 'authors' => $bookMap]);
    }

    public function view($id) {
        $book = DB::table('BOOK')->leftJoin('BOOKCOVER', 'BOOKCOVER.ISBN', '=', 'BOOK.ISBN')
                                  ->leftJoin('PHOTO', 'BOOKCOVER.MultimediaID', '=', 'PHOTO.MultimediaID')
                                  ->select('BOOK.ISBN', 'BOOK.BookTitle', 'BOOK.BookDescription', 'BOOK.PublicationDate', 'BOOK.AverageRating AS AvgRating', 'PHOTO.Url AS BookCover')
                                  ->where('BOOK.ISBN', '=', $id)
                                  ->first();

        $authors = DB::table('AUTHOR')
                                  ->leftJoin('AUTHOR_WRITE_BOOK', 'AUTHOR_WRITE_BOOK.AuthorID', '=', 'AUTHOR.AuthorID')
                                  ->leftJoin('BOOK', 'BOOK.ISBN', 'AUTHOR_WRITE_BOOK.ISBN')
                                  ->select('AUTHOR.AuthorName', 'AUTHOR.AuthorID')
                                  ->where('BOOK.ISBN', '=', $id)
                                  ->get();

        $reviews = DB::table('REVIEW')->join('NETWORK_USERS', 'REVIEW.UserID', '=', 'NETWORK_USERS.UserID')
                                      ->select('NETWORK_USERS.UserID', 'NETWORK_USERS.Username', 'REVIEW.PostContent', 'REVIEW.BookRating')
                                      ->where('REVIEW.ISBN', '=', $id)->get();

        return view('book-view', ['Book'=>$book, 'Authors' => $authors, 'Reviews' => $reviews]);
    }

    public function create() {
        $authors = DB::table('AUTHOR')->select('AuthorID', 'AuthorName')->get();
        return view('create-book', ['Authors'=>$authors]);
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

        if (intval($rowCount[0]->RetValue) == -1) {
            return back()->withInput()->with('error', 'ISBN cannot be empty');
        }

        if (intval($rowCount[0]->RetValue) == -2) {
            return back()->withInput()->with('error', 'ISBN has already existed');
        }

        if (intval($rowCount[0]->RetValue) == -3) {
            return back()->withInput()->with('error', 'Book title cannot be empty');
        }

        if (intval($rowCount[0]->RetValue) == -4) {
            return back()->withInput()->with('error', 'Number of pages must be greater than 0');
        }

        $authors = $request->input('authors') ?? [];
        $toBeInsert = [];

        foreach ($authors as $author) {
            $toBeInsert[] = [ 'AuthorID' => $author, 'ISBN' => $isbn ];
        }

        if (count($toBeInsert) > 0)
            DB::table('AUTHOR_WRITE_BOOK')->insert($toBeInsert);

        return back()->with('success', "'{$title}' was successfully added.");
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
