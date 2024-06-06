<template>
    <div class="p-4">
        <div class="mb-4 flex items-center space-x-4">
            <input
                v-model="search"
                type="text"
                placeholder="Search practices..."
                class="px-3 py-2 border text-black rounded focus:outline-none focus:ring focus:border-blue-300"
            >
            <button
                @click="toggleFinishedPractices"
                class="px-4 py-2 rounded text-white bg-flax dark:bg-pacific_cyan hover:bg-blue-600"
            >
                {{ showFinishedPractices ? 'Hide' : 'Show' }} Finished Practices
            </button>
        </div>
        <table class="min-w-full bg-white dark:bg-rich_black">
            <thead class="bg-flax text-rich_black dark:bg-rich_black dark:text-white">
            <tr>
                <th @click="sort('practice_number')" class="px-4 py-2 cursor-pointer text-left">
                    Practice Number <span v-if="sortKey === 'practice_number'">{{ sortOrders.practice_number > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('practice_location')" class="px-4 py-2 cursor-pointer text-left">
                    Location <span v-if="sortKey === 'practice_location'">{{ sortOrders.practice_location > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('start_time')" class="px-4 py-2 cursor-pointer text-left">
                    Start Time <span v-if="sortKey === 'start_time'">{{ sortOrders.start_time > 0 ? '▲' : '▼' }}</span>
                </th>
                <th class="px-4 py-2 text-left">Finished?</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(practice, index) in filteredPractices" :key="practice.id"
                :class="{
                        'bg-white dark:bg-rich_black text-rich_black dark:text-white font-extrabold': index % 2 === 0,
                        'bg-gray-400 dark:bg-gray-800 text-rich_black dark:text-white font-extrabold': index % 2 !== 0,
                        'hover:scale-105 transition-transform duration-200': true
                    }"
                class="border-b border-gray-200 dark:border-gray-700"
            >
                <td class="px-4 py-4">{{ practice.practice_number }}</td>
                <td class="px-4 py-4">{{ practice.practice_location }}</td>
                <td class="px-4 py-4">{{ new Date(practice.start_time).toLocaleString() }}</td>
                <td class="px-4 py-4">{{ isFinished(practice.end_time) ? 'Yes' : 'No' }}</td>
                <td class="px-4 py-4 flex space-x-2">
                    <a :href="'/planning/practice/planpractice/' + practice.id" class="px-3 py-1 border rounded bg-emerald-950 text-white hover:bg-green-600">
                        Plan Practice
                    </a>
                    <a :href="'/planning/practice/'+ practice.id+'/edit' " class="px-3 py-1 border rounded bg-pacific_cyan text-rich_black hover:bg-blue-800">
                        Edit
                    </a>
                    <button @click="deletePractice(practice.id)" class="px-3 py-1 border rounded bg-red-500 text-white hover:bg-red-600">
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <!-- Laravel Pagination Links -->
        <div v-if="paginationLinks.trim().length" v-html="paginationLinks" class="mt-4"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        initialPractices: {
            type: Object,
            required: true
        },
        initialLinks: {
            type: String,
            required: true
        },
        csrfToken: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            practices: this.initialPractices.data,
            search: '',
            showFinishedPractices: false,
            sortKey: '',
            sortOrders: {
                practice_number: 1,
                practice_location: 1,
                start_time: 1
            },
            paginationLinks: this.initialLinks.trim() // Trim whitespace from the links
        };
    },
    computed: {
        filteredPractices() {
            return this.sortedPractices.filter(practice => {
                const searchLower = this.search.toLowerCase();
                const matchesSearch = (
                    (typeof practice.practice_number === 'string' && practice.practice_number.toLowerCase().includes(searchLower)) ||
                    (typeof practice.practice_number === 'number' && practice.practice_number.toString().includes(searchLower)) ||
                    (typeof practice.practice_location === 'string' && practice.practice_location.toLowerCase().includes(searchLower)) ||
                    new Date(practice.start_time).toLocaleString().toLowerCase().includes(searchLower)
                );
                const isFinished = this.isFinished(practice.end_time);
                return matchesSearch && (this.showFinishedPractices || !isFinished);
            });
        },
        sortedPractices() {
            const sorted = this.practices.slice().sort((a, b) => {
                const order = this.sortOrders[this.sortKey] || 1;
                if (a[this.sortKey] > b[this.sortKey]) return order;
                if (a[this.sortKey] < b[this.sortKey]) return -order;
                return 0;
            });
            return sorted;
        }
    },
    methods: {
        fetchPractices(pageUrl) {
            axios.get(pageUrl || '/api/practices', {
                params: {
                    search: this.search,
                    finished: this.showFinishedPractices ? null : 0
                }
            }).then(response => {
                this.practices = response.data.data;
                this.paginationLinks = response.data.links.trim();
            });
        },
        toggleFinishedPractices() {
            this.showFinishedPractices = !this.showFinishedPractices;
            this.fetchPractices();
        },
        sort(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        isFinished(endTime) {
            return new Date(endTime) < new Date();
        },
        confirmDelete() {
            return confirm('All plan and practice will be deleted, are you sure?');
        },
        deletePractice(practiceId) {
            if (this.confirmDelete()) {
                axios.post(`/practices/${practiceId}`, {
                    _method: 'DELETE',
                })
                    .then(response => {
                        this.practices = this.practices.filter(practice => practice.id !== practiceId);
                        alert('Practice deleted successfully!');
                    })
                    .catch(error => {
                        console.error('There was an error deleting the practice!', error);
                        alert('Failed to delete practice');
                    });
            }
        }
    }
};
</script>
