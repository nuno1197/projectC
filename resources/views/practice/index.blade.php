<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Practices ') }} - <span class="text-text-orange_fruit dark:text-flax font-extrabold">{{$roster->roster_name}} {{$roster->age_squad}} {{getSeasonString($roster->season_id)}}</span>
        </h2>
    </x-slot>

    <x-slot name="secondHeader">
        <h2 class="font-semibold italic text-xl text-pacific_cyan dark:text-pacific_cyan leading-tight">
            Past, Present and Future Practices.
        </h2>
        <x-slot name="navlinks">
            <x-nav-link :href="route('roster.index',['season' => $roster->season_id])" :active="request()->routeIs('roster.index')">
                {{ __('Rosters') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
            <x-nav-link :href="route('roster.indexRoster',['roster' => $roster->id])" :active="request()->routeIs('roster.indexRoster')">
                {{ __('Roster Management') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
            <x-nav-link :href="route('planning.index',['roster' => $roster->id])" :active="request()->routeIs('planning.index')">
                {{ __('Planning Menu') }}&nbsp;&nbsp; <i class="fa-solid fa-arrow-right"></i>
            </x-nav-link>
            <x-nav-link :href="route('practice.index',['roster' => $roster->id])" :active="request()->routeIs('practice.index')">
                {{ __('Practices List') }}
            </x-nav-link>
        </x-slot>
    </x-slot>

    <div class="mb-4">
        <x-button href="{{ route('practice.create',['roster'=>$roster->id]) }}" class="ml-auto font-bold text-white bg-orange_fruit rounded px-4 py-2 hover:bg-rich_black"> Add Practice </x-button>
    </div>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif
    <div id="app">
        <practice-table :initial-practices="{{ $practice->toJson() }}" initial-links="{{ json_encode($practice->links('pagination::bootstrap-4')->render()) }}"></practice-table>
    </div>
{{--    <div>--}}
{{--        @livewire('practice-table', ['roster' => $roster])--}}
{{--    </div>--}}

    <script type="module" src="{{ mix('js/app.js') }}"></script>
</x-app-layout>
