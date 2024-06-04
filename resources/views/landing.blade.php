<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl font-extrabold text-rich_black dark:text-orange_fruit leading-tight">
            {{ __('Season') }} - Choose Season
        </h2>
    </x-slot>
    <!--Aqui-->
    <div class="flex justify-center">
        <div class="grid grid-cols-4 gap-8">
            @foreach($seasons as $season)
                <x-menu.seasons_menu-button address="/roster/{{$season->id}}" >{{$season->season_string}}</x-menu.seasons_menu-button>
            @endforeach
                <x-menu.seasons_menu-button address="#" ><i class="fa-solid fa-plus"></i></x-menu.seasons_menu-button>
        </div>
    </div>
</x-app-layout>
