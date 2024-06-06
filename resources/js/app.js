import './bootstrap';
import { createApp } from 'vue';
import EventCalendar from './components/EventCalendar.vue';
import DrillsComponent from './components/DrillsComponent.vue';
import GameTable from './components/GameTable.vue';
import PracticeTable from './components/PracticeTable.vue';
import DrillTable from './components/DrillTable.vue';
import CourtComponent from './components/CourtComponent.vue';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const app = createApp({});
app.component('event-calendar', EventCalendar);
app.component('drills-component', DrillsComponent);
app.component('game-table', GameTable);
app.component('practice-table', PracticeTable);
app.component('drill-table', DrillTable);
app.component('court-component', CourtComponent);
app.mount('#app');

// DARK MODE TOGGLE BUTTON
var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

// Check initial theme and apply
if (
    localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    document.documentElement.classList.add("dark");
    themeToggleLightIcon.classList.remove("hidden");
    themeToggleDarkIcon.classList.add("hidden");
} else {
    document.documentElement.classList.remove("dark");
    themeToggleLightIcon.classList.add("hidden");
    themeToggleDarkIcon.classList.remove("hidden");
}

// Toggle theme button
var themeToggleBtn = document.getElementById("theme-toggle");

themeToggleBtn.addEventListener("click", function () {
    // Toggle icons inside button
    themeToggleDarkIcon.classList.toggle("hidden");
    themeToggleLightIcon.classList.toggle("hidden");

    // Toggle theme and save preference in localStorage
    if (document.documentElement.classList.contains("dark")) {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
    } else {
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
    }
});
