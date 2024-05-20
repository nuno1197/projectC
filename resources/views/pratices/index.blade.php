<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Practices ') }} - {{$roster->roster_name}} {{$roster->season}}
        </h2>
    </x-slot>
    <!--Aqui-->
    <div class="mb-4">
        <a href="#" class="ml-auto font-bold text-white bg-pacific_cyan rounded px-4 py-2 hover:bg-rich_black"> Add Practice </a>
    </div>
    <div id="calendar"></div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridWeek',
                    slotMinTime: '09:00:00',
                    slotMaxTime: '24:00:00',
                    events: @json($events),
                    end: 'today prev,next',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay' // user can switch between the two
                    }
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
