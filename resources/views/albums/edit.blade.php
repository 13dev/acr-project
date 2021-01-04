<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Album
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('dashboard.album-edit', ['album' => $album->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mt-2">
                            <x-label for="name" :value="__('Name')"/>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                     value="{{ $album->name }}" required autofocus/>
                        </div>

                        <!-- Genre -->
                        <div class="mt-2">
                            <x-label for="genre" :value="__('Genre')"/>
                            <x-input id="genre" class="block mt-1 w-full" type="text" name="genre"
                                     value="{{ $album->genre }}" required/>
                        </div>

                        <!-- artist_id -->
                        <div class="mt-2">
                            <x-label for="artist_id" :value="__('Artist')"/>
                            <div class="relative">
                                <svg class="w-2 h-2 absolute top-0 right-0 m-4 pointer-events-none"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                                    <path
                                        d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z"
                                        fill="#648299" fill-rule="nonzero"/>
                                </svg>
                                <select name="artist_id" id="artist_id"
                                        class="block mt-1 w-full form-input rounded-md shadow-sm">
                                    @foreach($artists as $artist)
                                        <option
                                            value="{{ $artist->id }}" {{ $album->artist->id === $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- year -->
                        <div class="mt-2">
                            <x-label for="year" :value="__('Year')"/>
                            <x-input id="year" class="block mt-1 w-full" type="text" name="year"
                                     value="{{ $album->year }}" required/>
                        </div>

                        <div class="mt-2">
                            <x-label for="cover" :value="__('Year')"/>
                            <x-input id="cover" class="block mt-1 w-full" type="file" name="cover" accept="image/*"/>
                        </div>

                        <div class="mt-2 flex items-center justify-center">
                            <img src="{{ url('storage/covers/'. $album->cover) }}" alt="Cover" width="300"
                                 class="m-3 text-center">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
