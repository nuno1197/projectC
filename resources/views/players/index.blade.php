<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Players') }}
        </h2>

    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-dropdown-button>Choose Season</x-dropdown-button>
                    <!--aqui-->
                    <div class="bg-gray-800 rayshadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
                        <table class="w-full table-fixed">
                            <thead>
                            <tr class="bg-sky-600 text">
                                <th class="w-1/4 py-4 px-6 text-left text-orange-400 font-bold uppercase">Name</th>
                                <th class="w-1/4 py-4 px-6 text-left text-orange-400 font-bold uppercase">Number</th>
                                <th class="w-1/4 py-4 px-6 text-left text-orange-400 font-bold uppercase">Position</th>
                                <th class="w-1/4 py-4 px-6 text-left text-orange-400 font-bold uppercase">Birth Date</th>
                            </tr>
                            </thead>
                            <tbody class="bg-gray-800">
                                <tr>
                                    <td class="py-4 px-6 border-b border-gray-200"></td>
                                    <td class="py-4 px-6 border-b border-gray-200"></td>
                                    <td class="py-4 px-6 border-b border-gray-200"></td>
                                    <td class="py-4 px-6 border-b border-gray-200"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
