<div x-data="{ submitForm: function() { document.getElementById('season_form').submit(); } }" x-on:change="submitForm()" class="relative">
    <select name="season" id="season" class="ml-8 form-control bg-pacific_cyan focus:bg-orange_fruit text-gray-700 focus:text-gray-900 font-semibold rounded focus:outline-none focus:shadow-inner" >
        {{$slot}}
    </select>
</div>
