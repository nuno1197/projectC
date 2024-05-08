<div x-data="{ open: false }" class="inline-flex relative mb-4">
    <button @click="open = ! open" class="px-4 pe-10 py-2 border border-gray-200 rounded-lg shadow-sm">
        <span class="select-none absolute inset-y-0 right-0 flex items-center cursor-pointer pr-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </span>
        {{$slot}}
    </button>
    <div x-cloak x-show="open" @click.away="open = false" class="w-full absolute top-12 left-0 p-2 bg-white border border-gray-200 rounded-lg shadow">
        <div class="px-2 py-1 cursor-pointer hover:bg-sky-100 rounded-lg">First Menu</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-sky-100 rounded-lg">Second Menu</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-sky-100 rounded-lg">Third Menu</div>
    </div>
</div>

