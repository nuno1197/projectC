<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$rosters->roster_name}} {{$rosters->age_squad}} - {{ __('Players List') }}
        </h2>

    </x-slot>


    <x-slot name="secondHeader">
        <h2 class="font-semibold text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            The Artists <i class="fa-solid fa-wand-magic-sparkles">.</i>
        </h2>
        <x-button class="ml-auto bg-orange_fruit"  href="{{ route('players.create', ['roster' => $rosters->id]) }}">Add Players</x-button>
        <x-button class="ml-auto"  href="{{ url()->previous()}}">Go Back</x-button>
    </x-slot>


    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap">
                    @if(count($players)==0)

                        <x-error-message class=" ml-auto bg-red-400">Add Players to this roster!</x-error-message>
                    @endif
                    @foreach($players as $player)
                        <div class="w-1/4 px-4 mb-8 mt-8">
                            <div class="relative rounded-lg overflow-hidden shadow-lg cursor-pointer transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl hover:scale-105 border border-gray-300">
                                <!-- Player photo and number -->
                                <a href="{{ route('players.edit', ['players' => $player->id]) }}">
                                    <div class="relative">
                                        <img class="w-full h-auto" src="{{asset($player->photo_path)}}" alt="Player Headshot">
                                        <div class="absolute top-0 right-0 bg-flax bg-opacity-50 text-rich_black text-xs px-2 py-1 rounded-l-full">
                                            {{$player->jersey_number}}
                                        </div>
                                    </div>

                                    <div class="p-4 bg-flax">
                                        <div class="flex justify-between items-center">
                                            <!-- Large player number -->
                                            <div class="text-3xl font-bold text-orange_fruit">
                                                {{$player->jersey_number}}
                                            </div>
                                            <!-- Player name and position -->
                                            <div class="text-pacific_cyan font-extraboldbold">
                                                <div class="font-bold">{{$player->name}}</div>
                                                <div>{{$player->position}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
