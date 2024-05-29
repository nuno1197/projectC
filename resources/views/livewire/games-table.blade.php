<div x-data="{ search: '' }">
    <input x-model="search" type="text" placeholder="Search games..." class="ring-2 ring-orange_fruit p-2 mb-4 bg-gray-800 text-white rounded">

    <!-- Button to toggle between showing finished and unfinished games -->
    <button wire:click="toggleShowFinishedGames()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 float-right">
        {{ $showFinishedGames ? 'Hide Finished Games' : 'Show Finished Games' }}
    </button>

    <!-- Dropdown with checkboxes to filter by competition name -->
    <div x-data="{ buttonText: 'Filter by Competition', toggleText() { this.buttonText = this.buttonText === 'Filter by Competition' ? 'Load Results' : 'Filter by Competition'; } }" class="relative inline-block text-left float-right">
        <div>
            <button @click="toggleText" wire:click="toggleDropdown" class="mr-4 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <span x-text="buttonText"></span>
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.293 7.293a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Dropdown panel, show/hide based on dropdown state -->
        @if($isDropdownOpen)
            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5">
                <div class="px-2 py-2 divide-y divide-gray-700">
                    @foreach($competitions as $competition)
                        <label class="flex items-center justify-between py-1 px-2 hover:bg-gray-700 rounded-md">
                            <input type="checkbox" wire:model="selectedNames" value="{{ $competition }}" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-300">{{ $competition }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <table class="min-w-full leading-normal bg-gray-800 text-white">
        <thead>
        <tr>
            <th wire:click="sortBy('opp_name')" class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Opponent Name {!! $sortField === 'opp_name' ? ($sortAsc ? '↑' : '↓') : '' !!}
            </th>
            <th wire:click="sortBy('comp_name')" class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Competition {!! $sortField === 'comp_name' ? ($sortAsc ? '↑' : '↓') : '' !!}
            </th>
            <th wire:click="sortBy('local')" class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Local {!! $sortField === 'local' ? ($sortAsc ? '↑' : '↓') : '' !!}
            </th>
            <th wire:click="sortBy('start_date')" class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Start Date {!! $sortField === 'start_date' ? ($sortAsc ? '↑' : '↓') : '' !!}
            </th>
            <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Finished?</th>
            <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-900 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($games as $game)
            <tr x-show="search === '' ||
                ({{ json_encode($game->opp_name) }}.toLowerCase().includes(search.toLowerCase()) ||
                {{ json_encode($game->comp_name) }}.toLowerCase().includes(search.toLowerCase()) ||
                {{ json_encode($game->local) }}.toLowerCase().includes(search.toLowerCase()) ||
                {{ json_encode($game->start_date) }}.toLowerCase().includes(search.toLowerCase()))" >
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">{{ $game->opp_name }}</td>
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">{{ $game->comp_name }}</td>
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">{{ $game->local }}</td>
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">{{ \Carbon\Carbon::parse($game->start_date)->format('Y-m-d H:i')  }}</td>
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">{{ getStateGame($game->id) ? 'Yes' : 'No' }}</td>
                <td class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm">@if($game->off_keys || $game->def_keys || $game->notes)<x-button class="bg-green-700 hover:bg-green-950" href="{{route('games.indexplangame' , ['game' => $game])}}" > <i class="fa-solid fa-check"></i> Plan Game</x-button>@else<x-button class="bg-green-700 hover:bg-green-950" href="{{route('games.indexplangame' , ['game' => $game])}}" >Plan Game</x-button>@endif <x-button href="{{ route('games.edit',['roster' => $game->roster_id , 'game' => $game->id]) }}">Edit</x-button> <x-button href="#" class="bg-red-700 hover:bg-red-950 text-white">Delete</x-button> </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-5 py-5 border-b border-gray-700 bg-gray-800 text-sm text-center">No results found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-2">
        {{ $games->links() }}
    </div>
</div>
