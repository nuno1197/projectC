<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Practices ') }} - {{$roster->roster_name}} {{$roster->season}}
        </h2>
    </x-slot>
    <!--Aqui-->
    <div class="mb-4">
        <x-button href="{{ route('practices.create',['roster'=>$roster->id]) }}" class="ml-auto font-bold text-white bg-pacific_cyan rounded px-4 py-2 hover:bg-rich_black"> Add Practice </x-button>
    </div>

    @if (session('success'))
        <x-success-message>{{ session('success') }}</x-success-message>
    @endif

    <div id="calendar"></div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    slotMinTime: '09:00:00',
                    slotMaxTime: '24:00:00',
                    events: @json($events),
                    end: 'today prev,next',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridWeek,timeGridDay,dayGridMonth' // user can switch between the two
                    },
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false // Define a visualização de 24 horas para os slots
                    },
                    eventTimeFormat: { // Formato de 24 horas para eventos
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                });
                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
