<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage ') }} - {{$roster->roster_name}} {{$roster->age_squad}} <span class="text-orange_fruit dark:text-flax font-bold">{{getSeasonString($roster->season_id)}}</span>
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            <span class="italic">“If nobody will help you, do it alone.”</span> Michael Jordan
        </h2>
        <x-slot name="navlinks">
            <x-nav-link :href="route('roster.index',['season' => $roster->season_id])" :active="request()->routeIs('roster.index')">
                {{ __('Rosters') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
            <x-nav-link :href="route('roster.indexRoster',['roster' => $roster->id])" :active="request()->routeIs('roster.indexRoster')">
                {{ __('Roster Management') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
        </x-slot>
{{--        <x-button class="ml-auto"  href="{{ route('roster.index' ,['season' => $roster->season_id])}}">Go to Rosters</x-button>--}}
    </x-slot>
    <!--Aqui-->
    <div class="flex justify-center">
        <div class="grid grid-cols-4 gap-8">
            <x-menu.menu-button address="{{ route('players.index', ['roster' => $roster->id])}}" imgsrc="{{Vite::asset('/resources/images/buttons/ball_player.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Players</x-menu.menu-button>
            <x-menu.menu-button address="{{route('planning.index', ['roster' => $roster->id])}}" imgsrc="{{Vite::asset('/resources/images/buttons/blueprint_menu.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Planning Menu</x-menu.menu-button>
            <x-menu.menu-button address="#" imgsrc="{{Vite::asset('/resources/images/buttons/drills_menu.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Drills</x-menu.menu-button>
        </div>
    </div>
</x-app-layout>
