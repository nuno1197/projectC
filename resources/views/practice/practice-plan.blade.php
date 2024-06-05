<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Plan Practice Nr ') }} {{$practice->practice_number}} <span class="text-flax font-bold">{{$practice->start_time}}</span>
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 bg-white text-rich_black font-extrabold dark:bg-rich_black dark:text-white">
            <form method="POST" action="{{route('drill.store')}}">
                @method('PATCH')
                @csrf
                <input type="hidden" name="practice_id" value="{{$practice->id}}">
                <div id="app" class="mt-6">
                    <div class="  border-2 rounded-md border-gray-500 space-y-2 col-span-full lg:col-span-1 bg-gray-300 text-rich_black dark:bg-rich_black dark:text-white dark:border-orange_fruit">
                        <p class="font-medium ml-2">Drills</p>
                        <p class="text-xs italic ml-2 mb-2">Add drills to this practice.</p>
                    </div>
                    <drills-component></drills-component>
                </div>

                <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                    <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                    <x-orangeButton>Update</x-orangeButton>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
