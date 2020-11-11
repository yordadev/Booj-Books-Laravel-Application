<?php

namespace App\Http\Controllers\Pages;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public $displayableBooks;
    public $books;
    public $bookAuthors;
    public $authors;
    public $collections;
    public $googleBooks;
    public $query;

    public function __construct()
    {
        $this->displayableBooks = collect([]);
        $this->books            = collect([]);
        $this->authors          = collect([]);
        $this->query            = 'Space X';
    }

    /**
     * * renderHome(Request $request)
     * 
     *  This method connects to a publically available API (Google Books API)
     *  returns books for given query, defaults to "Space X"
     * 
     *  Prepares the given data and returns the view with all the data gathered.
     * 
     * @param String query
     * 
     * @return View pages.home
     */
    public function renderHome(Request $request)
    {
        $collections = Collection::where('user_id', Auth::user()->id)->get();
        $googleBooks = Http::get('https://www.googleapis.com/books/v1/volumes?q=' . $this->query . '&key=' . config('services.google.key'));

        if (isset($request->all()['query'])) {
            $this->query = $request->all()['query'];
        }

        foreach ($googleBooks['items'] as $book) {
            $this->bookAuthors = collect([]); //reset it every book
            if (!empty($book['volumeInfo']['authors'])) {
                foreach ($book['volumeInfo']['authors'] as $author) {
                    if (!$this->bookAuthors->contains($author)) {
                        $this->bookAuthors->add($author);
                        if (!$this->authors->contains($author)) {
                            $this->authors->add($author);
                        }
                    }
                }
            }

            $book = collect([
                'title'       => $book['volumeInfo']['title'],
                'description' => $book['searchInfo']['textSnippet'] ?? 'No description found.',
                'link'        => $book['accessInfo']['webReaderLink'],
                'authors'     => $this->bookAuthors,
                'img'         => $book['volumeInfo']['imageLinks']['thumbnail']
            ]);

            if (!$this->displayableBooks->contains($book['title'])) {
                $this->books->add($book);
                $this->displayableBooks->add($book['title']);
            }
        }

        return view('pages.home', [
            'data' => [
                'authors'     => $this->authors,
                'books'       => $this->books,
                'collections' => $collections,
                'query'       => $this->query
            ]
        ]);
    }
}
