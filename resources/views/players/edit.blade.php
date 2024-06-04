<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Player Profile') }} - {{$player->name}}
        </h2>
    </x-slot>


@if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <h1 class="text-pacific_cyan font-bold text-xl">Player Info</h1>
    <span class="text-pacific_cyan font-bold text-sm">You can edit all fields, just click the icon, change what you need to change, and click UPDATE. </span>
    <div class="py-12 ">
        <form method="POST" action="{{ route('players.patch', ['players' => $player->id]) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
            <div class="flex flex-col md:flex-row bg-white rounded-lg p-4 text-orange_fruit font-extrabold shadow-md dark:bg-rich_black dark:text-white ">
                <!-- Component A -->
                <div x-data="{
                    editingName: false,
                    editingPosition: false,
                    editingBirthDate: false,
                    editingNumber: false,
                    editingImage: false,
                    newImage: null,
                    imagePreview: '{{ asset($player->photo_path) }}',
                    playerName: '{{ $player->name }}',
                    playerPosition: '{{ $player->position }}',
                    playerBirthDate: '{{ $player->birth_date }}',
                    playerNumber: '{{ $player->jersey_number }}',
                    playerNotes: '{{ $player->player_notes }}',
                    selectNewImage() {
                        this.$refs.fileInput.click();
                    },
                    handleImageChange(event) {
                        this.newImage = event.target.files[0];
                        this.editingImage = true;
                    }
                }" class="w-full md:w-1/3 mb-4 md:mb-0 bg-white rounded-lg p-4 border-2 border-gray-500 shadow-md dark:bg-rich_black dark:text-white dark:border-orange_fruit">
                    <!-- Profile Image -->
                    <div class="relative flex justify-center mb-4">
                        <!-- Add a border around the profile picture -->
                        <img :src="newImage ? URL.createObjectURL(newImage) : imagePreview" alt="Profile Picture" class="w-50 h-48 rounded-lg border-gray-500 border-2 dark:bg-rich_black dark:text-white dark:border-orange_fruit">
                        <!-- Button to change image -->
                        <input x-ref="fileInput" name="photo_path" type="file" @change="handleImageChange" class="absolute inset-0 opacity-0 cursor-pointer">
                        <button type="button" @click="selectNewImage" class="absolute bottom-0 mt-10 bg-blue-500 text-white px-2 py-1 rounded-md z-10 hover:bg-blue-700">Change</button>
                    </div>

                    <!-- Profile Details -->
                    <div class="w-full md:w-2/3 p-4 mx-auto text-center rounded border-gray-500 border-2 bg-flax text-rich_black font-extrabold dark:bg-rich_black dark:text-white dark:border-orange_fruit">
                        <!-- Editable Name -->
                        <div class="mb-2 flex justify-between items-center" x-show="!editingName">
                            <label class="text-sm font-bold"> Player Name: </label>
                            <div class="text-pacific_cyan font-bold" x-text="playerName"></div>
                            <!-- Icon to trigger editing -->
                            <button type="button" @click="editingName = true" class="text-orange_fruit hover:text-orange-800"><i class="fas fa-pencil-alt"></i></button>
                        </div>
                        <div x-show="editingName">
                            <input name="name" type="text" class="border-b border-gray-300 bg-transparent text-pacific_cyan font-bold w-full px-2 py-1 focus:outline-none mb-2" x-model="playerName">
                            <!-- Save and Cancel buttons -->
                            <div class="flex justify-between mb-2">
                                <button type="button" class="text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700" @click="editingName = false">Save</button>
                                <button type="button" class="text-red-700 hover:text-gray-700" @click="editingName = false">Cancel</button>
                            </div>
                        </div>
                        <!-- Editable Position -->
                        <div class="mb-2 flex justify-between items-center" x-show="!editingPosition">
                            <label class="text-sm font-bold"> Position: </label>
                            <div class="text-pacific_cyan font-bold" x-text="playerPosition"></div>
                            <!-- Icon to trigger editing -->
                            <button type="button" @click="editingPosition = true" class="text-orange_fruit hover:text-orange-800"><i class="fas fa-pencil-alt"></i></button>
                        </div>
                        <div x-show="editingPosition">
                            <input name="position" type="text" class="border-b border-gray-300 bg-transparent text-pacific_cyan font-bold w-full px-2 py-1 focus:outline-none mb-2" x-model="playerPosition">
                            <!-- Save and Cancel buttons -->
                            <div class="flex justify-between mb-2">
                                <button type="button" class="text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700" @click="editingPosition = false">Save</button>
                                <button type="button" class="text-red-700 hover:text-gray-700" @click="editingPosition = false">Cancel</button>
                            </div>
                        </div>
                        <!-- Editable Birth Date -->
                        <div class="mb-2 flex justify-between items-center" x-show="!editingBirthDate">
                            <label class="text-sm font-bold"> Birth Date: </label>
                            <div class="text-pacific_cyan font-bold" x-text="playerBirthDate"></div>
                            <!-- Icon to trigger editing -->
                            <button type="button" @click="editingBirthDate = true" class="text-orange_fruit hover:text-orange-800"><i class="fas fa-pencil-alt"></i></button>
                        </div>
                        <div x-show="editingBirthDate">
                            <input name="birth_date" type="date" class="border-b border-gray-300 bg-transparent text-pacific_cyan font-bold w-full px-2 py-1 focus:outline-none mb-2" x-model="playerBirthDate">
                            <!-- Save and Cancel buttons -->
                            <div class="flex justify-between mb-2">
                                <button type="button" class="text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700" @click="editingBirthDate = false">Save</button>
                                <button type="button" class="text-red-700 hover:text-gray-700" @click="editingBirthDate = false">Cancel</button>
                            </div>
                        </div>
                        <!-- Editable Player's Number -->
                        <div class="mb-2 flex justify-between items-center" x-show="!editingNumber">
                            <label class="text-sm font-bold"> Number: </label>
                            <div class="text-pacific_cyan font-bold" x-text="playerNumber"></div>
                            <!-- Icon to trigger editing -->
                            <button type="button" @click="editingNumber = true" class="text-orange_fruit hover:text-orange-800"><i class="fas fa-pencil-alt"></i></button>
                        </div>
                        <div x-show="editingNumber">
                            <input name="jersey_number" type="number" class="border-b border-gray-300 bg-transparent text-pacific_cyan font-bold w-full px-2 py-1 focus:outline-none mb-2" x-model="playerNumber">
                            <!-- Save and Cancel buttons -->
                            <div class="flex justify-between mb-2">
                                <button type="button" class="text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700" @click="editingNumber = false">Save</button>
                                <button type="button" class="text-red-700 hover:text-gray-700" @click="editingNumber = false">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="ml-auto text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700">Update</button>
                        <a href="{{url()->previous()}}" class="text-white-700 font-bold bg-red-500 rounded-full px-4 py-2 hover:text-gray-700">Cancel</a>
                    </div>
                </div>
                <div x-data="{
                    editingBio: false,
                    playerNotes: '{{ $player->player_notes }}'
                }" class="w-full md:w-2/3 ml-0 md:ml-4 bg-white border-2 border-gray-500 rounded-lg p-4 shadow-md dark:bg-rich_black dark:text-white dark:border-orange_fruit">
                    <!-- Editable Bio -->
                    <div class="mb-2" x-show="!editingBio">
                        <label class="mb-4 font-bold">Player Notes:</label>
                        <div class="text-pacific_cyan font-bold" x-text="playerNotes"></div>
                        <!-- Icon to trigger editing -->
                        <button type="button" @click="editingBio = true" class="text-orange_fruit hover:text-orange-800 mt-2"><i class="fas fa-pencil-alt"></i></button>
                    </div>
                    <div x-show="editingBio">
                        <textarea name="player_notes" class="border border-gray-300 bg-transparent text-pacific_cyan font-bold w-full px-2 py-1 focus:outline-none" rows="5" x-model="playerNotes"></textarea>
                        <!-- Save and Cancel buttons -->
                        <div class="mt-2 flex justify-between">
                            <button type="button" class="text-white bg-blue-500 rounded-full px-4 py-2 hover:bg-blue-700" @click="editingBio = false">Save</button>
                            <button type="button" class="text-red-700 hover:text-gray-700" @click="editingBio = false">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Danger zone section -->
        <div class="flex flex-col md:flex-row bg-red-900 rounded-lg p-2 border-2 border-red-900 shadow-md mt-6">
            <div class="w-full mb-4 md:mb-0 bg-rich_black bg-danger_stripes border-pacific_cyan rounded-lg p-4 shadow-md">
                <h2 class="text-white text-2xl font-bold">Danger Zone</h2>
                <span class="text-sm  text-white font-bold">After delete player you can't recover:</span>
                <!-- Delete player button -->
                <form method="POST" action="{{ route('players.delete',['players' => $player]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"  onclick="return confirm('Are you sure you want delete this player??')" class="text-white-700 font-bold bg-red-500 rounded-full px-4  py-2 hover:text-gray-700 mt-2">Delete Player</button>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
