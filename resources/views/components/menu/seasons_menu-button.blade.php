<a href="{{$address}}"
   class=" mr-4 group relative overflow-hidden w-64 h-40 bg-[#FFFDD0] dark:bg-rich_black border border-gray-400 rounded-lg transition transform hover:scale-110 flex items-center justify-center">
    <div class="absolute inset-0 bg-gray-500 opacity-0 transition-opacity duration-300 group-hover:opacity-50"></div>
    <div class="absolute top-0 left-0 w-full h-1 bg-orange_fruit transition duration-300 transform scale-x-0 group-hover:scale-x-100 origin-left translate-y-6"></div> <!-- Another Line Above -->
    <span class="relative z-10 text-2xl font-bold text-orange_fruit">{{$slot}}</span>
    <div class="absolute bottom-0 left-0 w-full h-1 bg-sky-600 transition duration-300 transform scale-x-0 group-hover:scale-x-100 origin-left top-full -translate-y-6"></div> <!-- Bottom Line -->
</a>
