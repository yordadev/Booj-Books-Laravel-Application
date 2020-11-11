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
    <section class="relative py-16 ">
        <div class="container mx-auto px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                <div class="px-6">

                    <div class="flex flex-wrap justify-center">

                        <div class="w-full lg:w-6/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                <form method="GET" action="{{ route('home') }}"
                                    class="w-full lg:w-12/12 px-4 lg:order-1 pt-4">
                                    @csrf
                                    <div class="flex items-center border-b border-teal-500 py-2">
                                        <input name="query"
                                            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                            type="text" placeholder="Space X" aria-label="Query">
                                        <button
                                            class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                                            type="submit">
                                            Query
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="w-full lg:w-6/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                <div class="mr-4 p-3 text-center">
                                    <span
                                        class="text-xl font-bold block uppercase tracking-wide text-gray-700">{{ $data['authors']->count() }}</span><span
                                        class="text-sm text-gray-500">Authors</span>
                                </div>
                                <div class="mr-4 p-3 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-gray-700">
                                        {{ $data['books']->count() }}</span><span class="text-sm text-gray-500">Books
                                        Available</span>
                                </div>
                                <div class="lg:mr-4 p-3 text-center">
                                    <span
                                        class="text-xl font-bold block uppercase tracking-wide text-gray-700">{{ $data['collections']->count() }}</span><span
                                        class="text-sm text-gray-500">Collections</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    @foreach ($data['books'] as $book)
        <section class="relative py-16 mb-4">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl  -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-12/12 px-4 lg:order-1">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="max-w-md w-full lg:flex">
                                        <div class="object-scale-down h-34 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                                            style="background-image: url('{{ $book['img'] }}')" title="Woman holding a mug">
                                        </div>
                                        <div
                                            class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                                            <div class="mb-8">
                                                <div class="text-black font-bold text-xl mb-2">{{ $book['title'] }}</div>
                                                <p class="text-sm text-grey-dark flex items-center">
                                                    @foreach ($book['authors'] as $author)
                                                        <b> {{ $author }}</b>
                                                    @endforeach
                                                </p>
                                                <p class="text-grey-darker text-base mt-4">{{ $book['description'] }}</p>
                                            </div>
                                            <div class="flex items-center pb-6 mb-6 pt-0">

                                                <form method="GET" action="{{ route('get.collection_add') }}">
                                                    @csrf
                                                    <input type="hidden" value="{{ $book['title'] }}" name="title">
                                                    <input type="hidden" value="{{ $book['description'] }}"
                                                        name="description">
                                                    <input type="hidden" value="{{ $book['link'] }}" name="link">
                                                    @foreach ($book['authors'] as $author)
                                                        <input type="hidden" value="{{ $author }}" name="authors[author]">
                                                    @endforeach
                                                    <button
                                                        class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded outline-none focus:outline-none sm:mr-2 mb-3"
                                                        type="submit" style="transition: all 0.15s ease 0s;">
                                                        Add to Collection
                                                    </button>

                                                </form>
                                                <a href="{{ $book['link'] }}" target="_blank"><button
                                                        class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded outline-none focus:outline-none sm:mr-2 mb-3"
                                                        type="button" style="transition: all 0.15s ease 0s;">
                                                        View Book
                                                    </button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
