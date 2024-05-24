import './bootstrap';
import { createApp } from 'vue';
import EventCalendar from './components/EventCalendar.vue';
import DrillsComponent from './components/DrillsComponent.vue';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const app = createApp({});
app.component('event-calendar', EventCalendar);
app.component('drills-component', DrillsComponent);
app.mount('#app');
