<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events ') }} - {{$roster->roster_name}} {{$roster->season}}
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            Team is one.
        </h2>
        <x-button class="ml-auto bg-flax text-orange_fruit"  href="{{ route('roster.indexRoster', ['roster' => $roster->id])}}">Go Back</x-button>
    </x-slot>
    <!--Aqui-->
    <div class="mb-4">
        <x-button href="{{ route('practices.create',['roster'=>$roster->id]) }}" class="ml-auto font-bold text-white bg-pacific_cyan rounded px-4 py-2 hover:bg-rich_black"> Add Practice </x-button>
        <x-button href="{{ route('games.create',['roster'=>$roster->id]) }}" class="ml-auto font-bold text-white bg-orange_fruit rounded px-4 py-2 hover:bg-rich_black"> Add Game </x-button>
    </div>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif

    <div id="app">
        <event-calendar :events="{{ json_encode($events) }}"></event-calendar>
    </div>

    <!-- Inclua o script gerado pelo Vite -->
    <script type="module" src="{{ mix('js/app.js') }}"></script>
</x-app-layout>
