<div x-data="{ open: false, selectedOption: '{{ $defaultOption }}' }" class="relative ml-8">
    <input type="hidden" x-model="selectedOption" x-bind:value="selectedOption" name="{{$name}}">
    <button type="button" x-on:click.prevent="open = !open" class="flex items-center bg-pacific_cyan focus:bg-orange_fruit text-gray-700 focus:text-gray-900 font-semibold rounded focus:outline-none focus:shadow-inner py-2 px-4 relative z-10">
        <span x-text="selectedOption" class="mr-4"></span>
        <svg class="fill-current h-4 w-4 absolute right-4 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
        </svg>
    </button>
    <ul x-show="open" class="bg-orange_fruit text-rich_black rounded shadow-lg absolute py-2 mt-1 w-32 max-h-60 overflow-y-auto z-20" x-on:click.away="open = false">
        {{ $slot }}
    </ul>
</div>
