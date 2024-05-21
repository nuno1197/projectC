<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Roster') }}
        </h2>

        @if (session('success'))
            <x-success-message>{{ session('success') }}</x-success-message>
        @endif
    </x-slot>

    <h2 class="text-base font-semibold leading-7 text-pacific_cyan ml-8 mt-4">Edit {{$roster->roster_name}} {{$roster->age_squad}}</h2>
    <p class="mt-1 text-sm leading-6 text-pacific_cyan ml-8">If you need to edit the roster, do it here, coach.</p>
    <form method="POST" action="{{ route('roster.patch', ['roster' => $roster->id]) }}">
        @method('PATCH')
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="roster_name">Team Name</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> You can change the team associated with your new roster. </span>

                        <div class="mt-2">
                            <x-form_components.form-input name="roster_name" id="roster_name" value="{{$roster->roster_name}}" placeholder="Oklahoma City Thunder" />
                            <x-form_components.form-error name="roster_name" />
                        </div>
                    </x-form_components.form-field>

                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="season">Season of The Team</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> Change Season of the Roster. </span>

                        <div class="mt-2">

                            <x-form_components.form-dropdown name="season" default-option="{{getSeasonString($roster->seasons_id)}}" >
                                <li>
                                    <a></a>
                                    @foreach($seasons as $season)
                                        <a href="#" x-on:click.prevent="selectedOption = '{{$season->season_string}}'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4" @click.stop>{{$season->season_string}}</a>
                                    @endforeach
                                </li>
                            </x-form_components.form-dropdown>
                            <x-form_components.form-error name="season" />

                        </div>
                    </x-form_components.form-field>

                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="age_squad">Age Squad</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> Your players are under... </span>

                        <div class="mt-2">
                            <x-form_components.form-dropdown name="age_squad" default-option="{{$roster->age_squad}}" >
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 8'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 8</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 10'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 10</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 12'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 12</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 14'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 14</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 16'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 16</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 18'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 18</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Under 23'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Under 23 </a>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Senior'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Senior</a>
                                </li>
                                </li>
                            </x-form_components.form-dropdown>
                            <x-form_components.form-error name="age_squad" />

                        </div>
                    </x-form_components.form-field>

                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="gender">Gender</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> Gender of your team </span>

                        <div class="mt-2">
                            <x-form_components.form-dropdown name="gender" default-option="{{$roster->gender}}">
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Male'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Male</a>
                                </li>
                                <li>
                                    <a href="#" x-on:click.prevent="selectedOption = 'Female'; open = false;" class="block hover:bg-gray-200 whitespace-no-wrap py-2 px-4">Female</a>
                                </li>
                            </x-form_components.form-dropdown>
                            <x-form_components.form-error name="gender" />

                        </div>
                    </x-form_components.form-field>


                </div>

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</button>
            <x-orangeButton>Save</x-orangeButton>
        </div>
    </form>

</x-app-layout>
