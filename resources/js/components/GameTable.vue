<template>
    <div class="p-4">
        <div class="mb-4 flex items-center space-x-4">
            <input
                v-model="search"
                type="text"
                placeholder="Search games..."
                class="px-3 py-2 border text-black rounded focus:outline-none focus:ring focus:border-blue-300"
            >
            <button
                @click="toggleFinishedGames"
                class="px-4 py-2 rounded text-white bg-flax dark:bg-pacific_cyan hover:bg-blue-600"
            >
                {{ showFinishedGames ? 'Hide' : 'Show' }} Finished Games
            </button>
            <div class="relative">
                <button
                    @click="toggleDropdown"
                    class="px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 flex items-center"
                >
                    Select Competitions
                    <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div v-if="showDropdown" class="absolute mt-2 py-2 w-48 bg-white dark:bg-rich_black border rounded shadow-xl">
                    <div v-for="competition in competitions" :key="competition" class="flex items-center px-4 py-2">
                        <input
                            type="checkbox"
                            :value="competition"
                            v-model="selectedCompetitions"
                            @change="fetchGames"
                            class="form-checkbox"
                        >
                        <span class="ml-2">{{ competition }}</span>
                    </div>
                </div>
            </div>
        </div>
        <table class="min-w-full bg-white dark:bg-rich_black">
            <thead class="bg-flax text-rich_black dark:bg-rich_black dark:text-white">
            <tr>
                <th @click="sort('opp_name')" class="px-4 py-2 cursor-pointer text-left">
                    Opponent Name <span v-if="sortKey === 'opp_name'">{{ sortOrders.opp_name > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('comp_name')" class="px-4 py-2 cursor-pointer text-left">
                    Competition <span v-if="sortKey === 'comp_name'">{{ sortOrders.comp_name > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('local')" class="px-4 py-2 cursor-pointer text-left">
                    Local <span v-if="sortKey === 'local'">{{ sortOrders.local > 0 ? '▲' : '▼' }}</span>
                </th>
                <th @click="sort('start_date')" class="px-4 py-2 cursor-pointer text-left">
                    Start Date <span v-if="sortKey === 'start_date'">{{ sortOrders.start_date > 0 ? '▲' : '▼' }}</span>
                </th>
                <th class="px-4 py-2 text-left">Finished?</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(game, index) in filteredGames" :key="game.id"
                :class="{
                        'bg-white dark:bg-rich_black text-rich_black dark:text-white font-extrabold': index % 2 === 0,
                        'bg-gray-400 dark:bg-gray-800 text-rich_black dark:text-white font-extrabold': index % 2 !== 0,
                        'hover:scale-105 transition-transform duration-200': true
                    }"
                class="border-b border-gray-200 dark:border-gray-700"
            >
                <td class="px-4 py-4">{{ game.opp_name }}</td>
                <td class="px-4 py-4">{{ game.comp_name }}</td>
                <td class="px-4 py-4">{{ game.local }}</td>
                <td class="px-4 py-4">{{ new Date(game.start_date).toLocaleString() }}</td>
                <td class="px-4 py-4">{{ isFinished(game.end_date) ? 'Yes' : 'No' }}</td>
                <td class="px-4 py-4 flex space-x-2">
                    <a :href="'/plangame/' + game.id"
                       class="px-3 py-1 border rounded bg-emerald-950 text-white hover:bg-green-600 flex items-center justify-between">
                        Plan Game
                        <span v-if="game.off_keys || game.def_keys || game.notes" class="ml-1"><i
                            class="fa fa-check"></i></span>
                    </a>
                    <a :href="'/planning/games/'+ game.roster_id +'/edit/' + game.id"
                       class="px-3 py-1 border rounded bg-pacific_cyan text-rich_black hover:bg-blue-800">
                        Edit
                    </a>
                    <button @click="deleteGame(game.id)"
                            class="px-3 py-1 border rounded bg-red-500 text-white hover:bg-red-600">
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <!-- Laravel Pagination Links -->
        <div v-html="paginationLinks" class="mt-4"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        initialGames: {
            type: Object,
            required: true
        },
        initialCompetitions: {
            type: Array,
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
            games: this.initialGames.data,
            competitions: this.initialCompetitions.map(item => item),
            search: '',
            showFinishedGames: false,
            selectedCompetitions: [],
            sortKey: '',
            sortOrders: {
                opp_name: 1,
                comp_name: 1,
                local: 1,
                start_date: 1
            },
            showDropdown: false,
            paginationLinks: this.initialLinks
        };
    },
    computed: {
        filteredGames() {
            return this.sortedGames.filter(game => {
                const searchLower = this.search.toLowerCase();
                const matchesSearch = (
                    game.opp_name.toLowerCase().includes(searchLower) ||
                    game.comp_name.toLowerCase().includes(searchLower) ||
                    game.local.toLowerCase().includes(searchLower) ||
                    new Date(game.start_date).toLocaleString().toLowerCase().includes(searchLower)
                );
                const isFinished = this.isFinished(game.end_date);
                const matchesCompetition = this.selectedCompetitions.length === 0 || this.selectedCompetitions.includes(game.comp_name);
                return matchesSearch && matchesCompetition && (this.showFinishedGames || !isFinished);
            });
        },
        sortedGames() {
            const sorted = this.games.slice().sort((a, b) => {
                const order = this.sortOrders[this.sortKey] || 1;
                if (a[this.sortKey] > b[this.sortKey]) return order;
                if (a[this.sortKey] < b[this.sortKey]) return -order;
                return 0;
            });
            return sorted;
        }
    },
    methods: {
        fetchGames(pageUrl) {
            axios.get(pageUrl || '/api/games', {
                params: {
                    search: this.search,
                    finished: this.showFinishedGames ? null : 0,
                    competition: this.selectedCompetitions.length ? this.selectedCompetitions : null
                }
            }).then(response => {
                this.games = response.data.data;
                this.paginationLinks = response.data.links;
            });
        },
        toggleFinishedGames() {
            this.showFinishedGames = !this.showFinishedGames;
            this.fetchGames();
        },
        sort(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        isFinished(endDate) {
            return new Date(endDate) < new Date();
        },
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
        confirmDelete() {
            return confirm('All plan and game will be deleted, are you sure?');
        },
        deleteGame(gameId) {
            if (this.confirmDelete()) {
                axios.post(`/games/${gameId}`, {
                    _method: 'DELETE',
                })
                    .then(response => {
                        this.games = this.games.filter(game => game.id !== gameId);
                        alert('Game deleted successfully!');
                    })
                    .catch(error => {
                        console.error('There was an error deleting the game!', error);
                        alert('Failed to delete game');
                    });
            }
        }
    }
};
</script>
