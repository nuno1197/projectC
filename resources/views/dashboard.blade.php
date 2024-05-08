<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!--Aqui-->
                    <div class="flex justify-center">
                        <div class="grid grid-cols-4 gap-8">
                            <x-menu.menu-button imgsrc="{{Vite::asset('/resources/images/buttons/badge_team.png')}}" imgClass="w-full h-full object-contain" spanClass="text-white text-4xl font-semibold">Create Team</x-menu.menu-button>
                            <x-menu.menu-button imgsrc="{{Vite::asset('/resources/images/buttons/roster_button.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-white text-4xl font-semibold">Create Roster</x-menu.menu-button>
                            <x-menu.menu-button imgsrc="{{Vite::asset('/resources/images/buttons/ball_player.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-white text-4xl font-semibold">Add Players</x-menu.menu-button>
                            <x-menu.menu-button imgsrc="{{Vite::asset('/resources/images/buttons/blueprint_menu.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-white text-4xl font-semibold">Practices Menu</x-menu.menu-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
