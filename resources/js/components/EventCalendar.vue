<template>
    <div ref="calendar"></div>
</template>

<script>
import { ref } from 'vue';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

export default {
    props: ['events'],

    data() {
        return {
            calendarEl: null
        };
    },

    mounted() {
        if (this.$refs.calendar) {
            this.calendarEl = this.$refs.calendar;
            const calendar = new Calendar(this.calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                slotMinTime: '09:00:00',
                slotMaxTime: '24:00:00',
                slotDuration: '00:30:00', // Definindo intervalo de tempo para 30 minutos
                events: this.events,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridWeek,timeGridDay,dayGridMonth'
                },
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventDidMount: function (info) {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    info.el.style.color = info.event.textColor;
                },
            });
            calendar.render();
        } else {
            console.error('Elemento calendar não encontrado.');
        }
    }
};
</script>
