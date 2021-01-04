<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Album
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mt-2">
                            <x-label for="name" :value="__('Name')"/>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus/>
                        </div>

                        <!-- Genre -->
                        <div class="mt-2">
                            <x-label for="genre" :value="__('Genre')"/>
                            <x-input id="genre" class="block mt-1 w-full" type="text" name="genre" required/>
                        </div>

                        <!-- Genre -->
                        <div class="mt-2">
                            <x-label for="genre" :value="__('Genre')"/>
                            <x-input id="genre" class="block mt-1 w-full" type="text" name="genre" required/>
                        </div>

                        <div class="mt-2">
                            <x-label for="year" :value="__('Year')"/>
                            <x-input id="year" class="block mt-1 w-full" type="text" name="year" required/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
