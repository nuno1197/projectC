<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Create player') }}
        </h2>

    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="{{ route('players.store') }}" enctype="multipart/form-data">
            @csrf
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Add Player</p>
                        <p class="text-xs">Create a player for your roster!</p>
                    </div>
                    <input type="hidden" name="roster_id" value="{{$rosters->id}}">
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="name" class="text-sm">Name</label>
                            <input id="name" type="text" placeholder="Name" name="name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="birth_date" class="text-sm">Birth Date</label>
                            <input id="birth_date" type="date" placeholder="Birth Date" name="birth_date" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="position" class="text-sm">Position</label>
                            <input id="position" type="text" placeholder="Position" name="position" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="jersey_number" class="text-sm">Jersey Number</label>
                            <input id="jersey_number" type="number" placeholder="11" name="jersey_number" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="player_notes" class="text-sm">Player Notes</label>
                            <textarea id="player_notes" placeholder="Some notes for this player" name="player_notes" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"></textarea>
                        </div>
                        <div class="col-span-full">
                            <label for="photo_path" class="text-sm">Player Photo</label>
                            <div class="flex items-center space-x-2">
                                <!-- Preview image -->
                                <img id="image-preview" src="https://source.unsplash.com/30x30/?random" alt="" class="w-10 h-10 dark:bg-orange-800 rounded-full dark:bg-orange_fruit">
                                <!-- Hidden file input -->
                                <input type="file" id="photo_path" name="photo_path" accept="image/*" class="hidden" onchange="previewImage(event)">

                                <!-- Change button with hover effect -->
                                <button type="button" onclick="document.getElementById('photo_path').click()" class="px-4 py-2 border bg-rich_black text-white rounded-md dark:border-orange_fruit hover:bg-gray-700">Change</button>
                            </div>
                        </div>
                        <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                            <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                            <x-orangeButton>Save</x-orangeButton>
                        </div>

                    </div>
                </fieldset>
            </form>
        </section>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
</x-app-layout>
