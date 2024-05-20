<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage ') }} - {{$roster->roster_name}} {{$roster->season}}
        </h2>
    </x-slot>
    <!--Aqui-->
    <div class="flex justify-center">
        <div class="grid grid-cols-4 gap-8">
            <x-menu.menu-button address="{{ route('players.index', ['roster' => $roster->id])}}" imgsrc="{{Vite::asset('/resources/images/buttons/ball_player.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Players</x-menu.menu-button>
            <x-menu.menu-button address="/roster" imgsrc="{{Vite::asset('/resources/images/buttons/roster_button.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-rich_black text-4xl font-extrabold"></x-menu.menu-button>
            <x-menu.menu-button address="{{route('pratices.index', ['roster' => $roster->id])}}" imgsrc="{{Vite::asset('/resources/images/buttons/blueprint_menu.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Practices Menu</x-menu.menu-button>
        </div>
    </div>
</x-app-layout>
