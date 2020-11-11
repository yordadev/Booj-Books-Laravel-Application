<?php

namespace App\Http\Controllers\Functionality;

use App\Models\Book;
use App\Models\Author;
use App\Models\Collection;
use App\Models\AuthorBook;
use Illuminate\Http\Request;
use App\Models\CollectionPivot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageCollection extends Controller
{
    /**
     * * processAddBookNewCollection(Request $request)
     * 
     *  This method takes user input and creates a new collection, then adds the book.
     * 
     * @param String name 
     * @param String title
     * @param String description
     * @param String link
     * @param Array authors
     * @param Array[String] author
     * 
     * @return Route get.collection with flash message
     */
    public function processAddBookNewCollection(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string|max:255',
            'link'           => 'required|string',
            'authors'        => 'required|array',
            'authors.author' => 'required|string|max:255'
        ]);

        try {
            $collection = Collection::create([
                'collection_id' => Collection::generateCollectionID(),
                'user_id'       => Auth::user()->id,
                'name'          => $request->name
            ]);

            $book = $this->createBook($request);

            foreach ($request->authors as $author) {
                $this->createAuthor($author, $book);
            }

            $this->createPivotTable($collection, $book);

            return redirect()->route('get.collection', [
                'collection_id' => $collection->collection_id
            ])->with('success', 'Successfully created a new collection.');
        } catch (\Exception $e) {
            return redirect()->route('get.collections')->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * * processAddBookExistingCollection(Request $request)
     * 
     * This method takes user input and adds a book to an existing collection.
     * 
     * @param String collection_id
     * @param String title
     * @param String description
     * @param String link
     * @param Array authors
     * @param Array[String] author
     * 
     * @return Route get.collection with flash message
     */
    public function processAddBookExistingCollection(Request $request)
    {
        $request->validate([
            'collection_id'  => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'link'           => 'required|string',
            'authors'        => 'required|array',
            'authors.author' => 'required|string|max:255'
        ]);

        try {
            // validate user input
            if (!$collection = Collection::where([
                'collection_id' => $request->collection_id,
                'user_id'       => Auth::user()->id
            ])->first()) {
                return redirect()->back()->withErrors(['error' => 'Unknown Collection']);
            }

            $book = $this->createBook($request);

            foreach ($request->authors as $author) {
                $this->createAuthor($author, $book);
            }

            $this->createPivotTable($collection, $book);


            return redirect()->route('get.collection', [
                'collection_id' => $collection->collection_id
            ])->with('success', 'Successfully added the book to an existing collection.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * * processMoveBook(Request $request)
     * 
     *  This method takes user input and moves the desired books position, 
     *  the other pivot books get reordered.
     * 
     * @param String collection_id
     * @param String book_id
     * @param Integer position
     * 
     * @return Route get.collection with flash message
     */
    public function processMoveBook(Request $request)
    {
        $request->validate([
            'book_id'       => 'required|string|max:255',
            'collection_id' => 'required|string|max:255',
            'position'      => 'required|integer'
        ]);

        try {
            // validate user input
            if (!$collection = Collection::where([
                'collection_id' => $request->collection_id,
                'user_id'       => Auth::user()->id
            ])->first()) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => 'Unknown Collection.']);
            }

            // validate user input 
            if (!$requestedBookPivot = CollectionPivot::where([
                'book_id'       => $request->book_id,
                'collection_id' => $collection->collection_id
            ])->first()) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => 'Unknown Book.']);
            }

            // validate position input

            if ($collection->pivot->count() < $request->position) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => 'Invalid position input.']);
            }

            // set a condition to check later for moving
            $moved = false;
            foreach ($collection->pivot as $bookPivot) {

                //find the position of the pivot
                if ($bookPivot->position === $request->position) {
                    //make sure it isnt the same book
                    if ($bookPivot->book_id !== $request->book_id) {
                        // move the current book

                        $bookPivot->position = $bookPivot->position + 1;
                        $bookPivot->save();

                        // move the new book into position
                        $requestedBookPivot->position = $request->position;
                        $requestedBookPivot->save();
                        // set the condition to true to move the rest of the pivots
                        $moved = true;
                    } else {
                        // error book to move is in same position as required position
                        return redirect()->route('get.collection', [
                            'collection_id' => $collection->collection_id
                        ])->withErrors(['error' => 'Book is already in that position. Try again.']);
                    }
                } else {
                    // else prevents double jeopordy on moving positions from the intital move
                    if ($moved && $requestedBookPivot->book_id !== $bookPivot->book_id) {

                        $position = $bookPivot->position + 1;
                        if ($collection->pivot->count() < $position) {
                            // prevent from going over pivot length
                            $bookPivot->position = $collection->pivot->count();
                            $bookPivot->save();
                        } else {
                            $bookPivot->position = $position;
                            $bookPivot->save();
                        }
                    }
                }
            }

            if ($moved) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->with('success', 'Successfully moved the book position.');
            }

            return redirect()->route('get.collection', [
                'collection_id' => $collection->collection_id
            ])->withErrors(['error' => 'Something went wrong, please try again.']);
        } catch (\Exception $e) {
            return redirect()->route('get.collection', [
                'collection_id' => $collection->collection_id
            ])->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * * processRemoveBookCollection(Request $request)
     * 
     * This method removes the desired book from a collection.
     * 
     * @param String collection_id
     * @param String book_id
     * 
     * @return Route get.collection with flash message
     */
    public function processRemoveBookCollection(Request $request)
    {
        $request->validate([
            'book_id'       => 'required|string|max:255',
            'collection_id' => 'required|string|max:255',
        ]);

        try {
            // input validation
            if (!$collection = Collection::where([
                'collection_id' => $request->collection_id,
                'user_id'       => Auth::user()->id
            ])->first()) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => 'Unknown Collection.']);
            }

            // validate user input
            if (!$requestedBookPivot = CollectionPivot::where([
                'book_id'       => $request->book_id,
                'collection_id' => $collection->collection_id
            ])->first()) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => 'Unknown Book.']);
            }

            try {
                // remove the record
                $removed = false;

                // update the remaining pivot books positions
                foreach ($collection->pivot as $bookPivot) {
                    if ($bookPivot->book_id === $requestedBookPivot->book_id) {
                        $removed = true;
                        $requestedBookPivot->delete();
                    }

                    if ($removed) {
                        $bookPivot->position = $bookPivot->position - 1;
                        $bookPivot->save();
                    }
                }

                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->with('success', 'Successfully removed the book from the collection.');
            } catch (\Exception $e) {
                return redirect()->route('get.collection', [
                    'collection_id' => $collection->collection_id
                ])->withErrors(['error' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            return redirect()->route('get.collection', [
                'collection_id' => $collection->collection_id
            ])->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * * createBook(Request $request)
     * 
     * This method checks if a book exists in the db and returns the book.
     * if no book exists, it creates it & returns the book.
     * 
     * @param Request $request
     * 
     * @return Book $book
     */
    private function createBook(Request $request)
    {
        if (!$book = Book::where([
            'title' => $request->title,
            'description' => $request->description
        ])->first()) {
            // create new book
            $book = Book::create([
                'book_id' => Book::generateBookID(),
                'title'   => $request->title,
                'description' => $request->description
            ]);
        }
        return $book;
    }


    /**
     * * createAuthor($name, Book $book)
     * 
     * This method checks if a author exists in the db else it creates it.
     * It checks if the author book exists else it creates it in the db.
     * 
     * @param String $name
     * @param Book $book
     * 
     * @return void
     */
    private function createAuthor($name, Book $book)
    {
        // check if exists else make record
        if (!$authorObj = Author::where([
            'name' => $name
        ])->first()) {
            // no author
            $authorObj = Author::create([
                'author_id' => Author::generateAuthorID(),
                'name' => $name
            ]);
        }

        if (!AuthorBook::where([
            'author_id' => $authorObj->author_id,
            'book_id'   => $book->book_id
        ])->first()) {
            AuthorBook::create([
                'author_id' => $authorObj->author_id,
                'book_id'   => $book->book_id
            ]);
        }
    }


    /**
     * * createPivotTable(Collection $collection, Book $book)
     * 
     * This method creates the pivot table for the book if it doesn't already exist.
     * 
     * @param Collection $collection
     * @param Book $book
     * 
     * @return void
     */
    private  function createPivotTable(Collection $collection, Book $book)
    {
        // check if exists else make record
        if (!CollectionPivot::where([
            'collection_id' => $collection->collection_id,
            'book_id'       => $book->book_id
        ])->first()) {
            CollectionPivot::create([
                'collection_id' => $collection->collection_id,
                'book_id' => $book->book_id,
                'position' => $collection->pivot->count() + 1
            ]);
        }
    }
}
