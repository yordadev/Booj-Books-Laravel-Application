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

            <div class="px-6">

                <div class="w-full lg:w-12/12 px-4">

                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-800">Your Book Collections
                                </h3>
                            </div>

                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        Collection Name</th>
                                    <th
                                        class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        Books</th>

                                    <th
                                        class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-center">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data['collections'] as $collection)
                                    <tr>
                                        <th
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">
                                            {{ $collection->name }}
                                        </th>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center ">
                                            {{ $collection->pivot->count() }}
                                        </td>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-center">
                                            <form method="GET" action="{{ route('get.collection') }}">
                                                @csrf
                                                <input type="hidden" value="{{ $collection->collection_id }}"
                                                    name="collection_id">
                                                <button
                                                    class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-3"
                                                    type="submit" style="transition: all 0.15s ease 0s;">
                                                    Manage Collection
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="w-full lg:w-12/12 px-4 lg:order-1">
                            <div class="flex justify-center py-4 lg:pt-4 pt-8 mt-6">
                                @if ($data['collections']->count() < 1)

                                    <p class="pb-6 pt-6 text-center">You have not created any collections.</p>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
