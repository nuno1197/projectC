<a href="{{$address}}" class="group relative overflow-hidden w-70 h-54 transition duration-300 hover:scale-110">
            <div class="rounded-lg overflow-hidden border border-gray-300 w-full h-full relative">
                <img src="{{ $imgsrc }}" alt="Button 1" class="{{$imgClass}}">
                <div class="absolute inset-0 bg-gray-500 opacity-0 transition duration-300 group-hover:opacity-50"></div>
                <div class="absolute top-0 left-0 w-full h-1 bg-orange_fruit transition duration-300 transform scale-x-0 group-hover:scale-x-100 origin-left translate-y-6"></div> <!-- Another Line Above -->
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center opacity-0 transition duration-300 group-hover:opacity-100">
                    <span class="{{$spanClass}}">{{$slot}}</span>
                </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-sky-600 transition duration-300 transform scale-x-0 group-hover:scale-x-100 origin-left top-full -translate-y-6"></div> <!-- Bottom Line -->
    </div>
</a>

