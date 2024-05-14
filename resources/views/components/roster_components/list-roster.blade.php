<div class="bg-gray-300 rounded-lg shadow-md transition duration-300 hover:shadow-lg hover:scale-105 w-full mb-4">
    <div class="p-6 flex justify-between items-center">
        <!-- Image -->
        <img src="{{Vite::asset('/resources/images/badge.png')}}" alt="Image" class="mr-4 h-20 w-20">
        <div>
            <!-- Slot for small title -->
            <h3 class="text-sm font-semibold text-gray-700 mb-1">{{ $attributes['smallTitle'] ?? '' }}</h3>
            <!-- Slot for central title -->
            <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $slot }}</h2>
            <!-- Slot for another small title -->
            <h3 class="text-sm font-semibold text-gray-700">{{ $attributes['anotherSmallTitle'] ?? '' }}</h3>
        </div>
        <!-- Slot for actions -->
        <div class="ml-4 flex items-center"> <!-- Added items-center class here -->
            <div class="mr-2">{{ $actions }}</div>
            <div class="mr-2">{{ $actions2 }}</div>
            <div>{{ $actions3 }}</div>
        </div>
    </div>
</div>
