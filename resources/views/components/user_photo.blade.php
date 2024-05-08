@props(['active' => "icon1"])

<div class="h-auto flex items-center justify-center ">
    <button class="ml-10" name="icon_choosed" value="icon1">
        <img class = "rounded-full border-2 border-gray-400" src="{{Vite::asset('resources/images/icons/icon1.png')}}">
    </button>
    <button class="ml-10" value="icon2" name="icon_choosed" value="icon2">
        <img class = " rounded-full border-2 border-gray-400" src="{{Vite::asset('resources/images/icons/icon2.png')}}"  >
    </button>
    <button class="ml-10" name="icon_choosed" value="icon3">
        <img class = " rounded-full border-2 border-gray-400" src="{{Vite::asset('resources/images/icons/icon3.png')}}" >
    </button>
</div>
