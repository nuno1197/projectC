<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Plan your Team ') }} - {{$roster->roster_name}} {{$roster->age_squad}} <span class="text-flax font-bold">{{getSeasonString($roster->seasons_id)}}</span>
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            <span class="font-extrabold">Plan. Test. Fail. Learn. Repeat.</span> <span class="text-flax font-extrabold"> <i class="fa-solid fa-repeat"></i></span>
        </h2>
        <x-button class="ml-auto"  href="{{ route('roster.indexRoster' ,['roster' => $roster])}}">Go Back</x-button>
    </x-slot>
    <!--Aqui-->
    <div class="flex justify-center">
        <div class="grid grid-cols-4 gap-8">
            <x-menu.menu-button address="{{route('planning.events' , ['roster'=> $roster])}}" imgsrc="{{Vite::asset('/resources/images/buttons/calendar.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Calendar</x-menu.menu-button>
            <x-menu.menu-button address="#" imgsrc="{{Vite::asset('/resources/images/buttons/balls.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-flax text-4xl font-extrabold">Practices</x-menu.menu-button>
            <x-menu.menu-button address="#" imgsrc="{{Vite::asset('/resources/images/buttons/arena.jpg')}}" imgClass="w-full h-full object-cover" spanClass="text-white text-4xl font-extrabold">Games</x-menu.menu-button>
        </div>
    </div>
</x-app-layout>
