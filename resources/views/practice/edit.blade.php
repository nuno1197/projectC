<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Edit Practice Nr ') }} {{$practice->pratice_number}} <span class="text-flax font-bold">{{$practice->start_time}}</span>
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 bg-white text-rich_black font-extrabold dark:bg-rich_black dark:text-white">
            <form method="POST" action="{{ route('practice.patch' ,["practice" => $practice->id]) }}">
                @method('PATCH')
                @csrf
                <input type="hidden" name="roster_id" value="{{$rosters->id}}">
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm bg-white text-rich_black dark:bg-rich_black dark:text-white">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Practice Info (TU)</p>
                        <p class="text-xs italic">Edit this step of the process.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="pratice_number" class="text-sm">Practice Number</label>
                            <input id="pratice_number" value="{{$practice->practice_number}}" type="number" placeholder="1" name="pratice_number" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="pratice_location" class="text-sm">Practice Location</label>
                            <input id="pratice_location" type="text" value="{{$practice->practice_location}}" placeholder="Staples Center" name="pratice_location" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="start_time" class="text-sm">Start Practice Time</label>
                            <input id="start_time" type="datetime-local" value="{{$practice->start_time}}" name="start_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="end_time" class="text-sm">End Practice Time</label>
                            <input id="end_time" type="datetime-local" value="{{$practice->end_time}}" name="end_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="comments" class="text-sm">Comments</label>
                            <textarea id="comments" type="text" placeholder="Some comments about this UT." name="comments" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$practice->comments}}</textarea>
                        </div>
                    </div>
                </fieldset>
{{--                <hr class="rounded h-0.5 bg-gray-500 dark:border-orange_fruit font-extrabold">--}}
{{--                <div id="app" class="mt-6">--}}
{{--                    <div class="  border-2 rounded-md border-gray-500 space-y-2 col-span-full lg:col-span-1 bg-gray-300 text-rich_black dark:bg-rich_black dark:text-white dark:border-orange_fruit">--}}
{{--                        <p class="font-medium ml-2">Drills</p>--}}
{{--                        <p class="text-xs italic ml-2 mb-2">Add drills to this practice.</p>--}}
{{--                    </div>--}}
{{--                    <drills-component></drills-component>--}}
{{--                </div>--}}

                <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                    <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                    <x-orangeButton>Update</x-orangeButton>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
