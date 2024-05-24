<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$roster->roster_name}} {{$roster->age_squad}} - {{ __('Plan Game ') }} vs {{$game->opp_name}} at <span class="text-flax font-bold">{{\Carbon\Carbon::parse($game->start_date)->format('Y-m-d H:i')  }}</span>
        </h2>
    </x-slot>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <section class="p-6 dark:bg-rich_black dark:text-gray-900">
            <form method="POST" action="#">
                @method('PATCH')
                @csrf
                <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Plan the Game Info</p>
                        <p class="text-xs italic">What are the keys for this game?</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full">
                            <label for="off_keys" class="text-sm">Offensive Keys</label>
                            <textarea id="off_keys" name="off_keys" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->off_keys}} </textarea>
                        </div>
                        <div class="col-span-full ">
                            <label for="def_keys" class="text-sm">Defensive Keys</label>
                            <textarea id="def_keys"  name="def_keys" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->def_keys}} </textarea>
                        </div>
                        <div class="col-span-full ">
                            <label for="notes" class="text-sm">Some Notes</label>
                            <textarea id="notes"  name="notes" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">{{$game->notes}} </textarea>
                        </div>
                    </div>
                </fieldset>

                <div class="mt-6 ml-auto mr-6 flex items-center justify-end gap-x-6">
                    <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                    <x-orangeButton>Create Game Plan</x-orangeButton>
                    <x-button href="#">Get PDF</x-button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
