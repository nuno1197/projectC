<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$roster->roster_name}} {{$roster->age_squad}} - {{ __('Plan Game ') }} vs {{$game->opp_name}} at <span class="text-flax font-bold">{{\Carbon\Carbon::parse($game->start_date)->format('Y-m-d H:i')  }}</span>
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="{{ route('games.updategameplan' , ['game' => $game]) }}">
                @method('PATCH')
                @csrf
                <!-- Campo escondido para armazenar os jogadores selecionados -->
                <input type="hidden" name="selected_players" id="selectedPlayersInput">
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Plan the Game Info</p>
                        <p class="text-xs italic">What are the keys for this game?</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full">
                            <label for="off_keys" class="text-sm">Offensive Keys</label>
                            <textarea id="off_keys" name="off_keys" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->off_keys}}</textarea>
                        </div>
                        <div class="col-span-full">
                            <label for="def_keys" class="text-sm">Defensive Keys</label>
                            <textarea id="def_keys" name="def_keys" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->def_keys}}</textarea>
                        </div>
                        <div class="col-span-full">
                            <label for="notes" class="text-sm">Some Notes</label>
                            <textarea id="notes" name="notes" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->notes}}</textarea>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <div class="container rounded-l mx-auto p-4">
                            <h1 class="text-2xl font-bold mb-4">Players Called Up</h1>
                            <div class="flex">
                                <div class="w-1/2 bg-gray-100 p-4">
                                    <h2 class="text-xl font-semibold mb-2">Available Players</h2>
                                    <ul id="availablePlayers" class="space-y-2">
                                        @foreach($players as $player)
                                            <li data-id="{{ $player['id'] }}" class="p-2 bg-flax border-2 border-orange_fruit rounded cursor-pointer cursor-move">
                                                <span class="font-bold text-pacific_cyan">{{ $player['position'] }}</span> <span class="font-bold">{{ $player['name'] }}</span>  <span class="font-bold text-orange_fruit">#{{ $player['jersey_number'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="w-1/2 bg-gray-100 p-4">
                                    <h2 class="text-xl font-semibold mb-2">Selected Players</h2>
                                    <ul id="selectedPlayers" class="space-y-2 min-h-[56px]">
                                        @foreach($selected_players as $player)
                                            <li data-id="{{ $player->id}}" class="p-2 bg-flax border-2 border-orange_fruit rounded cursor-pointer cursor-move">
                                                <span class="font-bold text-pacific_cyan">{{ $player->position }}</span> <span class="font-bold">{{ $player->name }}</span>  <span class="font-bold text-orange_fruit">#{{ $player->jersey_number}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                    <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                    <x-orangeButton onclick="submitForm()">Update Game Plan</x-orangeButton>
                </div>
            </form>
            <x-button href="{{route('games.game_plan_pdf' , ['game' =>$game])}}">Get PDF</x-button>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const availablePlayers = document.getElementById('availablePlayers');
            const selectedPlayers = document.getElementById('selectedPlayers');

            Sortable.create(availablePlayers, {
                group: 'shared',
                animation: 150,
                sort: false
            });

            Sortable.create(selectedPlayers, {
                group: 'shared',
                animation: 150,
                onAdd: function (event) {
                    // Remove the duplicate player from the available players list
                    const playerId = event.item.getAttribute('data-id');
                    const duplicatePlayer = availablePlayers.querySelector(`[data-id="${playerId}"]`);
                    if (duplicatePlayer) {
                        duplicatePlayer.remove();
                    }

                    // Restrict the maximum number of selected players to 12
                    if (selectedPlayers.children.length > 12) {
                        event.from.insertBefore(event.item, event.from.children[event.oldIndex]);
                    }
                }
            });

            // Remove selected players from the available players list
            const selectedPlayerIds = Array.from(selectedPlayers.children).map(li => li.getAttribute('data-id'));
            selectedPlayerIds.forEach(playerId => {
                const selectedPlayer = availablePlayers.querySelector(`[data-id="${playerId}"]`);
                if (selectedPlayer) {
                    selectedPlayer.remove();
                }
            });

        });
        // Function to submit the form
        function submitForm() {
            document.getElementById('selectedPlayersInput').value = Array.from(document.getElementById('selectedPlayers').children)
                .map(li => li.getAttribute('data-id'));
            document.forms[0].submit();
        }
    </script>
</x-app-layout>
