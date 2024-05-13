<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roster Menu') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif



    <h1 class="text-3xl font-bold tracking-tight text-pacific_cyan">My Rosters</h1>
    <span class=" text-sm font-bold tracking-tight text-pacific_cyan">First select the season in the dropdown on the left, then add, update or delete roster's. </span>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">


                    <form method="GET" id="season_form">
                        <x-dropdown-page x-on:change="submitForm()">
                            <option value="{{$auxSeason}}">{{$auxSeason}}</option>
                            @foreach($seasons as $season)
                                @if ($season->seasons != $auxSeason)
                                    <option value="{{$season->seasons}}">{{$season->seasons}}</option>
                                @endif
                            @endforeach
                        </x-dropdown-page>
                    </form>

                    <x-button  href="{{ route('roster.create') }}">Add Roster</x-button>



                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!--Aqui-->
                    @if(count($rosters)===0)
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                            <x-error-message>There's no roster's for this season, create a new roster!</x-error-message>
                        </h3>

                    @endif
                    @foreach($rosters as $roster)
                        <x-list-roster smallTitle="{{$roster->roster_name}}" anotherSmallTitle="{{$roster->season}}">
                            {{$roster->age_squad}}
                            <x-slot name="actions" class="mb-4">

                                <form method="POST" action="{{ route('roster.delete', ['roster' => $roster->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')"  class="text-white bg-red-600 hover:bg-red-800 font-semibold py-2 px-4 rounded-full" type="submit">Delete</button>
                                </form>

                            </x-slot>
                            <x-slot name="actions2">
                                <a href="/roster/{{$roster->id}}" class=" mt-8 text-white bg-pacific_cyan hover:bg-orange_fruit font-semibold py-2 px-4 rounded-full">Edit</a>
                            </x-slot>
                        </x-list-roster>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
