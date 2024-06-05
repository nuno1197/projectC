<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Drill Menu ') }}
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            <span class="font-extrabold">All the Drill Universe in one place.</span> <span class="text-flax font-extrabold"> <i class="fa-solid fa-infinity"></i></span>
        </h2>
        <x-slot name="navlinks">
            <x-nav-link :href="route('drill.menu')" :active="request()->routeIs('drill.menu')">
                {{ __('Drill Menu') }}
            </x-nav-link>
        </x-slot>
    </x-slot>
    <!--Aqui-->
    <div class="flex justify-center ">
        <div class="grid grid-cols-2 gap-8 w-3/6">
            <x-menu.menu-button address="#" imgsrc="{{Vite::asset('/resources/images/buttons/drills_library.jpg')}}" imgClass="w-full h-full" spanClass="text-flax text-4xl font-extrabold">Drills Library</x-menu.menu-button>
            <x-menu.menu-button address="#" imgsrc="{{Vite::asset('/resources/images/buttons/drill_basket.jpg')}}" imgClass="w-full h-full" spanClass="text-flax text-4xl font-extrabold">My Drills</x-menu.menu-button>
        </div>

    </div>
</x-app-layout>
