<?php

namespace App\Http\Controllers\Pages;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{

    /**
     * * renderAddBook(Request $request)
     * 
     *  This method prepares and renders the view to add book to collection
     * 
     * @param String title
     * @param String description
     * @param String link
     * @param Array authors
     * @param Array[author] author
     * 
     * @return View pages.add_book_collection
     */
    public function renderAddBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string',
            'authors' => 'required|array',
            'authors.author' => 'required|string|max:255'
        ]);


        $collections = Auth::user()->collections;

        return view('pages.add_book_collection', [
            'data' => [
                'title' => $request->title,
                'description' => $request->description,
                'link'        => $request->link,
                'authors'     => $request->authors,
                'collections' => $collections
            ]
        ]);
    }

    /**
     * * renderViewCollections()
     * 
     *  This method prepares and renders the view
     *  the collections for the auth user
     * 
     * @return View pages.collections
     */
    public function renderViewCollections()
    {
        $collections = Auth::user()->collections;

        return view('pages.collections', [
            'data' => [
                'collections' => $collections
            ]
        ]);
    }

    /**
     * * renderViewCollection(Request $request)
     * 
     *  This method prepares and renders the view
     *  the collections for the auth user
     * 
     * @param String collection_id
     * 
     * @return View pages.collection
     */
    public function renderViewCollection(Request $request)
    {
        $request->validate([
            'collection_id' => 'required|string|max:255'
        ]);

        if (!$collection = Collection::where([
            'collection_id' => $request->collection_id,
            'user_id'       => Auth::user()->id
        ])->first()) {
            return redirect()->route('get.collections')->withErrors(['error' => 'Unknown Collection']);
        }

        return view('pages.collection', [
            'data' => [
                'collection' => $collection
            ]
        ]);
    }
}
