<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Drills ') }}
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            Your Creations.
        </h2>
        <x-slot name="navlinks">
            <x-nav-link :href="route('drill.menu')" :active="request()->routeIs('drill.menu')">
                {{ __('Drill Menu') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
            <x-nav-link :href="route('drill.index')" :active="request()->routeIs('drill.index')">
                {{ __('My Drills') }}
            </x-nav-link>
        </x-slot>
    </x-slot>

    <div class="mb-4">
        <x-button href="{{route('drill.create')}}" class="ml-auto font-bold text-white bg-orange_fruit rounded px-4 py-2 hover:bg-rich_black"> Create Drill </x-button>
    </div>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif

    {{--    <div>--}}
    {{--        @livewire('games-table', ['roster' => $roster])--}}
    {{--    </div>--}}

    <div id="app">
        <drill-table :initial-drills="{{ $drills->toJson() }}" :initial-links="{{ json_encode($drills->links()->render()) }}"></drill-table>
    </div>

    <script type="module" src="{{ mix('js/app.js') }}"></script>
</x-app-layout>
