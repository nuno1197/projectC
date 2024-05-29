<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$roster->roster_name}} {{$roster->age_squad}} - {{ __('Edit Game ') }} vs {{$game->opp_name}} at <span class="text-flax font-bold">{{\Carbon\Carbon::parse($game->start_date)->format('Y-m-d H:i')  }}</span>
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="{{ route('games.patch', ['game' => $game]) }}">
                @method('PATCH')
                @csrf
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Game Info</p>
                        <p class="text-xs italic">Edit this step of the process.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="opp_name" class="text-sm">Opponent Name</label>
                            <input id="opp_name" value="{{$game->opp_name}}" type="text" placeholder="Los Angeles Lakers" name="opp_name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="comp_name" class="text-sm">Competition name</label>
                            <input id="comp_name" type="text" value="{{$game->comp_name}}" placeholder="NBA" name="comp_name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="local" class="text-sm">Local</label>
                            <input id="local" type="text" value="{{$game->local}}" placeholder="California" name="local" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="start_date" class="text-sm">Start Game Time</label>
                            <input id="start_date" type="datetime-local" value="{{$game->start_date}}" name="start_date" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="end_date" class="text-sm">End Game Time</label>
                            <input id="end_date" type="datetime-local" value="{{$game->end_date}}" name="end_date" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                    </div>
                </fieldset>

                <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                    <x-button href="{{ route('games.indexplangame', ['game' =>$game]) }}"> Plan Game </x-button>
                    <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                    <x-orangeButton>Update Game</x-orangeButton>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
