<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Games ') }} - <span class="text-orange_fruit font-extrabold">{{$roster->roster_name}} {{$roster->age_squad}} {{getSeasonString($roster->season_id)}}</span>
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            Past, Present and Future Games.
        </h2>
        <x-button class="ml-auto bg-flax text-orange_fruit"  href="{{ route('planning.index', ['roster' => $roster])}}">Go Back to Planning Menu</x-button>
    </x-slot>

    <div class="mb-4">
        <x-button href="{{ route('games.create',['roster'=>$roster->id]) }}" class="ml-auto font-bold text-white bg-orange_fruit rounded px-4 py-2 hover:bg-rich_black"> Add Game </x-button>
    </div>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif

    <div>
        @livewire('games-table', ['roster' => $roster])
    </div>

    <script type="module" src="{{ mix('js/app.js') }}"></script>
</x-app-layout>
