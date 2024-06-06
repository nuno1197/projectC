<template>
    <div class="flex h-screen">
        <!-- Court Image -->
        <div class="flex-1 flex items-center justify-center bg-yellow-100 relative" @mousemove="updateCursor" @click="placePlayer">
            <img :src="courtImage" ref="courtImage" alt="Basketball Court" class="max-w-full max-h-full">
            <div v-for="player in currentPlayers" :key="player.id" :style="{top: player.y + 'px', left: player.x + 'px'}" class="absolute" @click="removePlayer(player.id)">
                <div class="w-12 h-12 rounded-full bg-rich_black text-white font-bold flex items-center justify-center border-4 border-orange_fruit">
                    {{ player.number }}
                </div>
            </div>
            <div v-if="selectedPlayer" :style="{top: cursorY + 'px', left: cursorX + 'px'}" class="absolute">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center border-2 border-blue-500 opacity-50">
                    {{ selectedNumber }}
                </div>
            </div>
        </div>

        <!-- Control Panel -->
        <div class="w-1/4 bg-gray-200 p-4 flex flex-col items-center">
            <h1 class="text-rich_black text-xl font-bold mb-4">Control Panel</h1>
            <button @click="toggleCourt" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">
                {{ buttonLabel }}
            </button>
            <div class="w-full border-t border-gray-400 my-4"></div>
            <h2 class="text-rich_black text-xl font-bold mb-4">Offensive Players</h2>
            <div class="flex flex-col items-center mb-4">
                <div class="flex items-center mb-2">
                    <button @click="decreaseNumber" class="bg-gray-500 text-white px-2 py-1 rounded-l">◀</button>
                    <span class="bg-white text-rich_black font-bold px-4 py-2 border">{{ selectedNumber }}</span>
                    <button @click="increaseNumber" class="bg-gray-500 text-white px-2 py-1 rounded-r">▶</button>
                </div>
                <div class="flex items-center mb-4">
                    <button @click="toggleSelection" :class="{'border-2 border-rich_black': selectedPlayer}" class="bg-white text-rich_black px-4 py-2 rounded flex items-center mr-2">
                        <div class="w-12 h-12 rounded-full bg-rich_black text-white font-bold flex items-center justify-center border-4 border-orange_fruit">
                            {{ selectedNumber }}
                        </div>
                    </button>
                    <button @click="enableRemovePlayer" :class="{'border-2 border-red-500': removingPlayer}" class="bg-red-500 text-white px-4 py-2 rounded relative group">
                        X
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Remove Offensive Player</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isFullCourt: true,
            selectedNumber: 1,
            selectedPlayer: false,
            removingPlayer: false,
            cursorX: 0,
            cursorY: 0,
            fullCourtPlayers: [],
            halfCourtPlayers: []
        };
    },
    computed: {
        courtImage() {
            return this.isFullCourt ? '/images/court/fullcourt.png' : '/images/court/halfcourt.png';
        },
        buttonLabel() {
            return this.isFullCourt ? 'Toggle Half-Court' : 'Toggle Full-Court';
        },
        currentPlayers() {
            return this.isFullCourt ? this.fullCourtPlayers : this.halfCourtPlayers;
        }
    },
    methods: {
        toggleCourt() {
            this.isFullCourt = !this.isFullCourt;
            this.resetCursor();
        },
        increaseNumber() {
            if (this.selectedNumber < 9) {
                this.selectedNumber++;
            }
        },
        decreaseNumber() {
            if (this.selectedNumber > 1) {
                this.selectedNumber--;
            }
        },
        toggleSelection() {
            this.selectedPlayer = !this.selectedPlayer;
            this.removingPlayer = false; // Disable removal mode if selecting a player
        },
        enableRemovePlayer() {
            this.removingPlayer = !this.removingPlayer;
            this.selectedPlayer = false; // Disable player selection mode if enabling removal
        },
        resetCursor() {
            this.cursorX = 0;
            this.cursorY = 0;
        },
        updateCursor(event) {
            const rect = this.$refs.courtImage.getBoundingClientRect();
            const scaleX = this.$refs.courtImage.naturalWidth / rect.width;
            const scaleY = this.$refs.courtImage.naturalHeight / rect.height;
            this.cursorX = (event.clientX - rect.left) * scaleX;
            this.cursorY = (event.clientY - rect.top) * scaleY;
        },
        placePlayer() {
            if (this.selectedPlayer) {
                const newPlayer = {
                    id: this.currentPlayers.length + 1,
                    number: this.selectedNumber,
                    x: this.cursorX,
                    y: this.cursorY
                };
                if (this.isFullCourt) {
                    this.fullCourtPlayers.push(newPlayer);
                } else {
                    this.halfCourtPlayers.push(newPlayer);
                }
            }
        },
        removePlayer(id) {
            if (this.removingPlayer) {
                if (this.isFullCourt) {
                    this.fullCourtPlayers = this.fullCourtPlayers.filter(player => player.id !== id);
                } else {
                    this.halfCourtPlayers = this.halfCourtPlayers.filter(player => player.id !== id);
                }
            }
        }
    }
};
</script>

<style scoped>
</style>
