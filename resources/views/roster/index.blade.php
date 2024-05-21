<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roster Menu') }} - Season <span class="text-flax font-bold">{{$seasons->season_string}} </span>
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            Team is one.
        </h2>

    </x-slot>


    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">
                    <x-button class="h-10" href="{{ route('roster.create',['season' => $seasons]) }}">Add Roster</x-button>
                    <x-button class="h-10" href="{{ route('landing') }}">Go Back</x-button>


                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!--Aqui-->
                    @if(count($rosters)===0)
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                            <x-error-message>There's no roster's for this season, create a new roster!</x-error-message>
                        </h3>

                    @endif
                    @foreach($rosters as $roster)
                        <x-roster_components.list-roster smallTitle="{{$roster->roster_name}}"
                                                         anotherSmallTitle="{{$roster->season}}">
                            {{$roster->age_squad}}

{{--                            <x-slot name="actions">--}}
{{--                                <a href="{{ route('players.index', ['roster' => $roster->id])}}"--}}
{{--                                   class=" mt-8 text-white bg-blue-500 hover:bg-blue-700 font-semibold py-2 px-4 rounded-full"><i--}}
{{--                                        class="fa-solid fa-users "></i> Players</a>--}}
{{--                            </x-slot>--}}

                            <x-slot name="actions">
                                <a href="{{ route('roster.indexRoster', ['roster' => $roster->id])}}"
                                   class=" mt-8 text-white bg-blue-500 hover:bg-blue-700 font-semibold py-2 px-4 rounded-full"><i
                                        class="fa-solid fa-bars-progress mr-2"></i>Manage</a>
                            </x-slot>

                            <x-slot name="actions2" class="mb-4">

                                <form method="POST" action="{{ route('roster.delete', ['roster' => $roster->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure? All players in this roster will be deleted, so be carefull')"
                                            class="text-white bg-red-600 hover:bg-red-800 font-semibold py-2 px-4 rounded-full"
                                            type="submit"><i class="fa-regular fa-trash-can mr-2"></i>Delete
                                    </button>
                                </form>

                            </x-slot>
                            <x-slot name="actions3">
                                <a href="{{ route('roster.edit', ['roster' => $roster->id , 'season' => $seasons->id])}}"
                                   class=" mt-8 text-white bg-pacific_cyan hover:bg-orange_fruit font-semibold py-2 px-4 rounded-full"><i
                                        class="fa-solid fa-pen-to-square mr-2"></i>Edit</a>
                            </x-slot>

                        </x-roster_components.list-roster>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
