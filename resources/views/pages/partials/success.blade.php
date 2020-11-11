@if(Session::has('success'))


        <div class="bg-green-100 border border-green-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ Session::get('success') }}</span>
        </div>


@endif
