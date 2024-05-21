<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Roster') }}
        </h2>
    </x-slot>

    <h2 class="text-base font-semibold leading-7 text-pacific_cyan ml-8 mt-4">Create a New Roster</h2>
    <p class="mt-1 text-sm leading-6 text-pacific_cyan ml-8">We just need a handful of details about your team.</p>
    <form method="POST" action="{{ route('roster.store') }}">
        @csrf
        <div class="py-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="roster_name">Team Name</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> You can change the team associated with your new roster. </span>

                        <div class="mt-2">
                            <x-form_components.form-input name="roster_name" id="roster_name" value="{{auth()->user()->current_club}}" placeholder="Oklahoma City Thunder" />
                            <x-form_components.form-error name="roster_name" />
                        </div>
                    </x-form_components.form-field>

                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="season">Season of The Team</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> This is your current season. </span>
                        <x-form_components.form-input name="season" id="season" value="{{$seasons->season_string}}" readonly />
                    </x-form_components.form-field>

                    <x-form_components.form-field class="border bg-gray-500 rounded-2xl border-orange_fruit p-4">
                        <x-form_components.form-label for="age_squad">Age Squad</x-form_components.form-label>
                        <span class="text-pacific_cyan text-xs ml-8"> Your players are under... </span>

                        <div class="mt-2">
                            <x-form_components.form-dropdown name="age_squad" default-option="Select Age" >
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
                            <x-form_components.form-dropdown name="gender" default-option="Select Gender">
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
            <a href="{{ url()->previous() }}" class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-900 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
            <x-orangeButton>Save</x-orangeButton>
        </div>
    </form>

</x-app-layout>
