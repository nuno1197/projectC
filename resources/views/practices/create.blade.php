<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Create Practice') }}
        </h2>

    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Practice Info</p>
                        <p class="text-xs italic">Add another step to the process.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="title" class="text-sm">Practice Number</label>
                            <input id="title" type="number" placeholder="1" name="title" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="start_time" class="text-sm">Start Practice Time</label>
                            <input id="start_time" type="date" name="start_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="end_time" class="text-sm">End Practice Time</label>
                            <input id="end_time" type="date" name="end_time" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="comments" class="text-sm">Comments</label>
                            <textarea id="comments" type="text" placeholder="Some comments about this UT." name="comments" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"> </textarea>
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
</x-app-layout>
