<template>
    <div class="p-4">
        <div class="mb-4 flex items-center space-x-4">
            <input
                v-model="search"
                type="text"
                placeholder="Search drills..."
                class="px-3 py-2 border text-black rounded focus:outline-none focus:ring focus:border-blue-300"
            >
        </div>
        <table class="min-w-full bg-white dark:bg-rich_black">
            <thead class="bg-flax text-rich_black dark:bg-rich_black dark:text-white">
            <tr>
                <th @click="sort('drill_name')" class="px-4 py-2 cursor-pointer text-left">
                    Name <span v-if="sortKey === 'drill_name'">{{ sortOrders.drill_name > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('objective')" class="px-4 py-2 cursor-pointer text-left">
                    Objective <span v-if="sortKey === 'objective'">{{ sortOrders.objective > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('rules')" class="px-4 py-2 cursor-pointer text-left">
                    Rules <span v-if="sortKey === 'rules'">{{ sortOrders.rules > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('public')" class="px-4 py-2 cursor-pointer text-left">
                    Public <span v-if="sortKey === 'public'">{{ sortOrders.public > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('number_players')" class="px-4 py-2 cursor-pointer text-left">
                    Minimum Players <span v-if="sortKey === 'number_players'">{{ sortOrders.number_players > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('age_squad')" class="px-4 py-2 cursor-pointer text-left">
                    Age Squad <span v-if="sortKey === 'age_squad'">{{ sortOrders.age_squad > 0 ? '▲' : '▼' }}</span>
                </th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(drill, index) in filteredDrills" :key="drill.id"
                :class="{
                        'bg-white dark:bg-rich_black text-rich_black dark:text-white font-extrabold': index % 2 === 0,
                        'bg-gray-400 dark:bg-gray-800 text-rich_black dark:text-white font-extrabold': index % 2 !== 0,
                        'hover:scale-105 transition-transform duration-200': true
                    }"
                class="border-b border-gray-200 dark:border-gray-700"
            >
                <td class="px-4 py-4">{{ drill.drill_name }}</td>
                <td class="px-4 py-4">{{ drill.objective }}</td>
                <td class="px-4 py-4">{{ drill.rules }}</td>
                <td class="px-4 py-4">
                    <i :class="drill.public ? 'fa fa-check text-green-500' : 'fa fa-times text-red-500'"></i>
                </td>
                <td class="px-4 py-4">{{ drill.number_players }}</td>
                <td class="px-4 py-4">{{ drill.age_squad }}</td>
                <td class="px-4 py-4 flex space-x-2">
                    <a :href="'/drill/mydrills/' + drill.id + '/edit'" class="px-3 py-1 border rounded bg-pacific_cyan text-rich_black hover:bg-blue-800">
                        Edit
                    </a>
                    <button @click="deleteDrill(drill.id)" class="px-3 py-1 border rounded bg-red-500 text-white hover:bg-red-600">
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
        initialDrills: {
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
            drills: this.initialDrills.data,
            search: '',
            sortKey: '',
            sortOrders: {
                drill_name: 1,
                objective: 1,
                rules: 1,
                public: 1,
                number_players: 1,
                age_squad: 1
            },
            paginationLinks: this.initialLinks.trim() // Trim whitespace from the links
        };
    },
    computed: {
        filteredDrills() {
            return this.sortedDrills.filter(drill => {
                const searchLower = this.search.toLowerCase();
                const matchesSearch = (
                    (typeof drill.drill_name === 'string' && drill.drill_name.toLowerCase().includes(searchLower)) ||
                    (typeof drill.objective === 'string' && drill.objective.toLowerCase().includes(searchLower)) ||
                    (typeof drill.rules === 'string' && drill.rules.toLowerCase().includes(searchLower)) ||
                    (typeof drill.number_players === 'number' && drill.number_players.toString().includes(searchLower)) ||
                    (typeof drill.age_squad === 'string' && drill.age_squad.toLowerCase().includes(searchLower))
                );
                return matchesSearch;
            });
        },
        sortedDrills() {
            const sorted = this.drills.slice().sort((a, b) => {
                const order = this.sortOrders[this.sortKey] || 1;
                if (a[this.sortKey] > b[this.sortKey]) return order;
                if (a[this.sortKey] < b[this.sortKey]) return -order;
                return 0;
            });
            return sorted;
        }
    },
    methods: {
        fetchDrills(pageUrl) {
            axios.get(pageUrl || '/api/drills', {
                params: {
                    search: this.search
                }
            }).then(response => {
                this.drills = response.data.data;
                this.paginationLinks = response.data.links.trim();
            });
        },
        sort(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        confirmDelete() {
            return confirm('Are you sure you want to delete this drill?');
        },
        deleteDrill(drillId) {
            if (this.confirmDelete()) {
                axios.post(`/drills/${drillId}`, {
                    _method: 'DELETE',
                })
                    .then(response => {
                        this.drills = this.drills.filter(drill => drill.id !== drillId);
                        alert('Drill deleted successfully!');
                    })
                    .catch(error => {
                        console.error('There was an error deleting the drill!', error);
                        alert('Failed to delete drill');
                    });
            }
        }
    }
};
</script>
