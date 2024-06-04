<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Add Game') }} - <span class="text-orange_fruit dark:text-flax font-extrabold">{{$rosters->roster_name}} {{$rosters->age_squad}} {{getSeasonString($rosters->season_id)}}</span>
        </h2>

    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-white">
            <form method="POST" action="{{ route('games.store') }}">
            @csrf
                <input type="hidden"  name="roster_id" value="{{$rosters->id}}">
                <fieldset class="grid grid-cols-4 gap-6 p-6 text-orange_fruit bg-white font-extrabold rounded-md shadow-sm dark:bg-rich_black dark:text-white">
                    <div class="space-y-2 col-span-full lg:col-span-1 ">
                        <p class="font-medium">Game Info </p>
                        <p class="text-xs italic">Add another step to the process.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="opp_name" class="text-sm">Opponent</label>
                            <input id="opp_name" type="text" placeholder="Oklahoma City Thunder" name="opp_name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="comp_name" class="text-sm">Competition Name</label>
                            <input id="comp_name" type="text" placeholder="NBA" name="comp_name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="start_time" class="text-sm">Date and Start Time</label>
                            <input id="start_time" type="datetime-local" name="start_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">

                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="end_time" class="text-sm"> Date and End Time</label>
                            <input id="end_time" type="datetime-local" name="end_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="local" class="text-sm">Game Local</label>
                            <input id="local" type="text" name="local" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                            <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                            <x-orangeButton>Add Game</x-orangeButton>
                        </div>

                    </div>
                </fieldset>
            </form>
        </section>
    </div>
</x-app-layout>
