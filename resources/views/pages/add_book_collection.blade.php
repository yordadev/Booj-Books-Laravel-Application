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

                                <div class="container mx-auto px-4 pt-6 pb-6 h-full">
                                    <div class="flex content-center items-center justify-center h-full mb-6">
                                        <div class="w-full lg:w-12/12 px-4">
                                            <div
                                                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                                                <div class="rounded-t mb-0 px-6 py-6">

                                                    <div class="text-gray-500 text-center mb-3 font-bold">
                                                        <small>{{ $data['title'] }}</small>
                                                    </div>
                                                    <hr class="mt-6 border-b-1 border-gray-400" />


                                                </div>
                                                <div class="flex-auto px-4 lg:px-10 py-10 pt-0">

                                                    @csrf

                                                    <div class="relative w-full mb-3">
                                                        <label
                                                            class="block uppercase text-gray-700 text-xs font-bold mb-2">Book
                                                            Description</label>
                                                        <p>{{ $data['description'] }}</p>


                                                    </div>
                                                    <div class="relative w-full mb-3">
                                                        <label
                                                            class="block uppercase text-gray-700 text-xs font-bold mb-2">Link</label><a
                                                            href="{{ $data['link'] }}" target="_blank">Readable Link</a>
                                                    </div>
                                                    <div class="relative w-full mb-3">
                                                        <label
                                                            class="block uppercase text-gray-700 text-xs font-bold mb-2">Authors</label>
                                                        @foreach ($data['authors'] as $author)
                                                            <p>{{ $author }}</p>
                                                        @endforeach
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8">

                                <div class="container mx-auto px-4 pt-6 pb-6 h-full">
                                    <div class="flex content-center items-center justify-center h-full mb-6">
                                        <div class="w-full lg:w-12/12 px-4">
                                            <div
                                                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                                                <div class="rounded-t mb-0 px-6 py-6">

                                                    <div class="text-gray-500 text-center mb-3 font-bold">
                                                        <small>You can add the book to a new collection.</small>
                                                    </div>
                                                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0 text-center">
                                                        <div class="inline-block relative w-64">
                                                            <form method="POST" action={{ route('post.collection_add') }}>
                                                                @csrf
                                                                <input type="hidden" value="{{ $data['title'] }}"
                                                                    name="title">
                                                                <input type="hidden" value="{{ $data['description'] }}"
                                                                    name="description">
                                                                <input type="hidden" value="{{ $data['link'] }}"
                                                                    name="link">
                                                                @foreach ($data['authors'] as $author)
                                                                    <input type="hidden" value="{{ $author }}"
                                                                        name="authors[author]">
                                                                @endforeach
                                                                <div class="relative w-full mb-3">
                                                                    <label
                                                                        class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                                                        for="grid-password">Collection Name</label><input
                                                                        type="text" name="name"
                                                                        class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                                                                        placeholder="name"
                                                                        style="transition: all 0.15s ease 0s;" />
                                                                </div>


                                                                <div class="text-center mt-6">
                                                                    <button
                                                                        class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                                                        type="submit"
                                                                        style="transition: all 0.15s ease 0s;">
                                                                        Add to new Collection
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-6 border-b-1 border-gray-400" />

                                 

                                                </div>

                                                <div class="flex-auto px-4 lg:px-10 py-10 pt-0 text-center">
                                                    <div class="text-gray-500 text-center mb-3 font-bold">
                                                        <small>You can add the book to an existing collection.</small>
                                                    </div>
                                                    <div class="inline-block relative w-64">
                                                        <form method="POST"
                                                            action={{ route('post.collection_existing') }}>
                                                            @csrf
                                                            <input type="hidden" value="{{ $data['title'] }}"
                                                            name="title">
                                                            <input type="hidden" value="{{ $data['description'] }}"
                                                                name="description">
                                                            <input type="hidden" value="{{ $data['link'] }}" name="link">
                                                            @foreach ($data['authors'] as $author)
                                                                <input type="hidden" value="{{ $author }}"
                                                                    name="authors[author]">
                                                            @endforeach
                                                            <label
                                                                class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                                                for="grid-password">Existing Collections</label>
                                                            <select
                                                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                                                name="collection_id">
                                                                @foreach ($data['collections'] as $collection)
                                                                    
                                                                    <option value="{{ $collection->collection_id }}">
                                                                        {{ ucfirst(strtolower($collection->name)) }}
                                                                        Collection</option>
                                                                @endforeach

                                                            </select>

                                                            <div class="text-center mt-6">
                                                                <button
                                                                    class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                                                    type="submit" style="transition: all 0.15s ease 0s;">
                                                                    Add to Existing Collection
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>

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
@endsection
