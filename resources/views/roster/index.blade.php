<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roster Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!--Aqui-->
                    <div class="border border-gray-300 rounded-lg p-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4"><span class="text-sky-600">Roster List</span></h1>
                        <div class="flex flex-col items-center">

                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 w-full mb-4">
                                <div class="p-6 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-700 mb-1">Small Title</h3>
                                        <h2 class="text-xl font-bold text-gray-900 mb-1">Central Title</h2>
                                        <h3 class="text-sm font-semibold text-gray-700">Small Title</h3>
                                    </div>
                                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-full">Edit</button>
                                </div>
                            </div>
                            <!-- Add more elements as needed -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
