<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Create Practice') }}
        </h2>
    </x-slot>
    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            The Process.
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="{{ route('practice.store') }}">
            @csrf
                <input type="hidden"  name="roster_id" value="{{$rosters->id}}">
                <fieldset class="grid grid-cols-4 gap-6 text-orange_fruit font-extrabold p-6 rounded-md shadow-sm dark:bg-rich_black dark:text-white">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Practice Info (TU)</p>
                        <p class="text-xs italic">Add another step to the process.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="practice_number" class="text-sm">Practice Number</label>
                            <input id="practice_number" type="number" placeholder="1" name="practice_number" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="practice_number" class="text-sm">Practice Location</label>
                            <input id="practice_location" type="text" placeholder="Staples Center" name="practice_location" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="start_time" class="text-sm">Start Practice Time</label>
                            <input id="start_time" type="datetime-local" name="start_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="end_time" class="text-sm">End Practice Time</label>
                            <input id="end_time" type="datetime-local" name="end_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="comments" class="text-sm">Comments</label>
                            <textarea id="comments" type="text" placeholder="Some comments about this UT." name="comments" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"> </textarea>
                        </div>
                        <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                            <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                            <x-orangeButton>Create Practice</x-orangeButton>
                        </div>

                    </div>
                </fieldset>
            </form>
        </section>
    </div>
</x-app-layout>
