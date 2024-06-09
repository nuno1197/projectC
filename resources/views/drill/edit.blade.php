<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Drill') }} <span class="text-orange_fruit dark:text-flax font-bold">{{$drill->drill_name}} </span>
        </h2>

    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-white">
            <form method="POST" action="{{route('drill.patch' , ['drill'=> $drill])}}">
                @method('PATCH')
                @csrf
                <fieldset class="grid grid-cols-4 gap-6 p-6 text-orange_fruit bg-white font-extrabold rounded-md shadow-sm dark:bg-rich_black dark:text-white">
                    <div class="space-y-2 col-span-full lg:col-span-1 ">
                        <p class="font-medium">Drill Info </p>
                        <p class="text-xs italic">The basic block of the Practice Unit.</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full sm:col-span-3">
                            <label for="drill_name" class="text-sm">Drill Name</label>
                            <input id="drill_name" value="{{$drill->drill_name}}" type="text" placeholder="3X3 defense" name="drill_name" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="objective" class="text-sm">Drill Objective</label>
                            <textarea id="objective" placeholder="Create Pick and Roll Routines..." name="objective" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$drill->objective}}</textarea>
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="rules" class="text-sm">Drill Rules</label>
                            <textarea id="rules" placeholder="No Drible, only 3 dribles,..." name="rules" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$drill->rules}}</textarea>
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="public" class="text-sm"> Do you want this drill to be Public? (If so check box)</label>
                            <input id="public" type="checkbox" value="1" {{ $drill->public ? 'checked' : '' }} name="public" class="w-5 h-5 ml-2 rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full flex items-center justify-center mt-6">
                            <hr class="w-full border-t border-gray-300 dark:border-gray-700">
                            <span class="px-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">Optional Fields</span>
                            <hr class="w-full border-t border-gray-300 dark:border-gray-700">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="number_players" class="text-sm">Minimum Players for the Drill</label>
                            <input id="number_players" value="{{$drill->number_players}}" placeholder="10" type="number" name="number_players" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="age_squad" class="text-sm">Recommended Age</label>
                            <input id="age_squad" value="{{$drill->age_squad}}" placeholder="Under 14, Under 16..." type="text" name="age_squad" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                        </div>
                        <div class="col-span-full">
                            <label for="material" class="text-sm">Material</label>
                            <textarea id="material" placeholder="2 Balls, 2 baskets..." name="material" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$drill->material}}</textarea>
                        </div>


                        <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                            <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                            <x-orangeButton>Update Game</x-orangeButton>
                        </div>

                    </div>
                </fieldset>
            </form>
        </section>
    </div>
    <!--2. Link VueKonva Javascript (Plugin automatically installed)-->
    <script src="./lib/vue-konva.min.js"></script>
</x-app-layout>
