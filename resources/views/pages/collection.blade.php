@extends('layouts.app')

@section('content')


    @if (Session::has('success') || $errors->count() > 0)
        <section class="relative py-16 ">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6 pt-3">
                        @include('pages.partials.success')
                        @include('pages.partials.error')
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="relative py-16 mb-6 pt-6">
        <div class="container mx-auto px-4">

            <div class="px-6 pb-6">

                <div class="w-full lg:w-12/12 px-4">

                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-800">Books in {{ $data['collection']->name }}
                                </h3>
                            </div>

                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th
                                        class="w-4/12 px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        Book Name</th>
                                    <th
                                        class="w-4/12 px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        Authors</th>

                                    <th
                                        class="w-1/12 px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        position</th>

                                    <th
                                        class="w-1/12 px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                    </th>
                                    <th
                                        class="w-1/12 px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['collection']->pivot as $bookPivot)

                                    <tr>
                                        <th
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">
                                            {{ $bookPivot->book->title }}
                                        </th>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center ">
                                            @foreach ($bookPivot->book->authors as $authorPivot)
                                                <a href="#">{{ $authorPivot->author->name }}</a>
                                            @endforeach
                                        </td>
                                        <th
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">
                                            <div class="mb-4 ">
                                                <form id="movebook-{{ $bookPivot->book_id }}" method="POST" action="{{ route('post.move_book') }}">
                                                    @csrf
                                                    <input type="hidden" value="{{ $data['collection']->collection_id }}"
                                                        name="collection_id">
                                                    <input type="hidden" value="{{ $bookPivot->book_id }}" name="book_id">
                                                    <input
                                                        class="shadow appearance-none border rounded w-full py-2  text-center px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        id="position" type="text" placeholder="Position" name="position"
                                                        value="{{ $bookPivot->position }}">
                                                </form>
                                            </div>

                                        </th>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">



                                            <button form="movebook-{{ $bookPivot->book_id }}"
                                                class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-3"
                                                type="submit" style="transition: all 0.15s ease 0s;">
                                                Move Book
                                            </button>
                                            </form>
                                        </td>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">
                                            <form method="POST" action="{{ route('post.collection_remove_book') }}">
                                                @csrf
                                                <input type="hidden" value="{{ $data['collection']->collection_id }}"
                                                    name="collection_id">
                                                    <input type="hidden" value="{{ $bookPivot->book_id }}"
                                                    name="book_id">
                                                <button
                                                    class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-3"
                                                    type="submit" style="transition: all 0.15s ease 0s;">
                                                    Remove Book
                                                </button>
                                            </form>



                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                        <div class="w-full lg:w-12/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8 mt-6">
                                @if ($data['collection']->pivot->count() < 1)

                                    <p class="pb-6 pt-6 text-center">You have not added any books to this collection.</p>
                                @endif


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
