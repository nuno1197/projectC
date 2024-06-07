<template>
    <div class="flex h-screen">
        <div ref="canvasContainer" class="w-3/4 relative bg-yellow-100 h-full">
            <canvas ref="fabricCanvas"></canvas>
        </div>
        <div class="w-1/4 bg-gray-200 p-2 flex flex-col items-center">
            <h1 class="text-rich_black text-lg font-bold mb-2">Control Panel</h1>
            <div class="flex items-center justify-between w-full mb-2 ">
                <button @click="toggleCourt" class="bg-blue-500 text-white px-1 py-1 rounded text-sm">
                    {{ buttonLabel }}
                </button>
                <button @click="addBasketball" class="bg-orange-500 text-white px-1 py-1 rounded text-sm">
                    Basketball
                </button>
                <button @click="enableRemovePlayer" :class="{'border-2 border-red-500': removingPlayer}" class="bg-red-500 text-white px-2 py-1 rounded relative group text-sm">
                    X
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Remove Player</span>
                </button>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Offensive Players</h2>
            <div class="flex flex-col items-center mb-2">
                <div class="flex items-center mb-1">
                    <button @click="decreaseNumber" class="bg-gray-500 text-white px-1 py-1 rounded-l text-sm">◀</button>
                    <span class="bg-white text-rich_black font-bold px-2 py-1 border text-sm">{{ selectedNumber }}</span>
                    <button @click="increaseNumber" class="bg-gray-500 text-white px-1 py-1 rounded-r text-sm">▶</button>
                </div>
                <div class="flex items-center mb-2">
                    <button @click="toggleSelection" :class="{'border-2 border-rich_black': selectedPlayer}" class="bg-white text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
                        <div class="w-8 h-8 rounded-full bg-rich_black text-white font-bold flex items-center justify-center border-4 border-orange_fruit">
                            {{ selectedNumber }}
                        </div>
                    </button>
                </div>
                <button @click="rotatePlayer" class="bg-purple-500 text-white px-2 py-1 rounded text-sm">
                    Rotate Player
                </button>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Defensive Players</h2>
            <div class="flex flex-col items-center mb-2">
                <div class="flex items-center mb-1">
                    <button @click="decreaseDefensiveNumber" class="bg-gray-500 text-white px-1 py-1 rounded-l text-sm">◀</button>
                    <span class="bg-white text-rich_black font-bold px-2 py-1 border text-sm">{{ selectedDefensiveNumber }}</span>
                    <button @click="increaseDefensiveNumber" class="bg-gray-500 text-white px-1 py-1 rounded-r text-sm">▶</button>
                </div>
                <div class="flex items-center mb-2">
                    <button @click="toggleDefensiveSelection" :class="{'border-2 border-rich_black': selectedDefensivePlayer}" class="bg-white text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center border-4 border-white">
                            {{ selectedDefensiveNumber }}
                        </div>
                    </button>
                </div>
                <button @click="rotateDefensivePlayer" class="bg-purple-500 text-white px-2 py-1 rounded text-sm">
                    Rotate Defensive Player
                </button>
            </div>
        </div>
    </div>
</template>


<script>
import { fabric } from 'fabric';

export default {
    data() {
        return {
            isFullCourt: true,
            selectedNumber: 1,
            selectedPlayer: false,
            removingPlayer: false,
            fullCourtPlayers: [],
            halfCourtPlayers: [],
            draggingPlayer: null,
            canvas: null,
            courtImage: null,
            rotatingPlayer: null,
            defensivePlayers: [],
            selectedDefensiveNumber: 1,
            selectedDefensivePlayer: false,
            rotatingDefensivePlayer: null,
            basketball: null, // Adicionado para a bola de basquete
        };
    },
    computed: {
        courtImageUrl() {
            return this.isFullCourt ? '/images/court/fullcourt.png' : '/images/court/halfcourt.png';
        },
        buttonLabel() {
            return this.isFullCourt ? 'Toggle Half-Court' : 'Toggle Full-Court';
        },
        currentPlayers() {
            return this.isFullCourt ? this.fullCourtPlayers : this.halfCourtPlayers;
        },
    },
    watch: {
        courtImageUrl: 'loadCourtImage',
    },
    mounted() {
        this.initCanvas();
        this.loadCourtImage();
    },
    methods: {
        initCanvas() {
            const canvasElement = this.$refs.fabricCanvas;
            this.canvas = new fabric.Canvas(canvasElement);
            this.updateCanvasSize();
            window.addEventListener('resize', this.updateCanvasSize);
            this.canvas.on('mouse:down', this.handleMouseDown);
        },
        updateCanvasSize() {
            const canvasContainer = this.$refs.canvasContainer;
            const width = canvasContainer.clientWidth;
            const height = canvasContainer.clientHeight;
            this.canvas.setWidth(width);
            this.canvas.setHeight(height);
            if (this.courtImage) {
                this.adjustCourtImageSize();
            }
        },
        loadCourtImage() {
            fabric.Image.fromURL(this.courtImageUrl, (img) => {
                this.courtImage = img;
                img.set({
                    left: 0,
                    top: 0,
                    selectable: false,
                    evented: false,
                });
                this.canvas.setBackgroundImage(img, this.adjustCourtImageSize.bind(this));
            });
        },
        adjustCourtImageSize() {
            const canvasWidth = this.canvas.getWidth();
            const canvasHeight = this.canvas.getHeight();
            const imageAspectRatio = this.courtImage.width / this.courtImage.height;
            const canvasAspectRatio = canvasWidth / canvasHeight;

            if (canvasAspectRatio > imageAspectRatio) {
                this.courtImage.scaleToHeight(canvasHeight);
            } else {
                this.courtImage.scaleToWidth(canvasWidth);
            }

            this.courtImage.set({
                left: (canvasWidth - this.courtImage.getScaledWidth()) / 2,
                top: (canvasHeight - this.courtImage.getScaledHeight()) / 2,
            });

            this.canvas.renderAll();
        },
        toggleCourt() {
            this.isFullCourt = !this.isFullCourt;
            this.loadCourtImage();
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
            this.removingPlayer = false;
        },
        increaseDefensiveNumber() {
            if (this.selectedDefensiveNumber < 9) {
                this.selectedDefensiveNumber++;
            }
        },
        decreaseDefensiveNumber() {
            if (this.selectedDefensiveNumber > 1) {
                this.selectedDefensiveNumber--;
            }
        },
        toggleDefensiveSelection() {
            this.selectedDefensivePlayer = !this.selectedDefensivePlayer;
            this.removingPlayer = false;
        },
        enableRemovePlayer() {
            this.removingPlayer = !this.removingPlayer;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        addBasketball() {
            const circle = new fabric.Circle({
                radius: 10,
                fill: 'orange',
                stroke: 'black',
                strokeWidth: 2,
                originX: 'center',
                originY: 'center',
                left: this.canvas.getWidth() / 2,
                top: this.canvas.getHeight() / 2,
                hasControls: false,
                hasBorders: false,
            });
            circle.on('mousedown', () => this.selectBasketball(circle));
            this.canvas.add(circle);
            this.basketball = circle;
            this.canvas.renderAll();
        },
        selectBasketball(circle) {
            if (this.removingPlayer) {
                this.canvas.remove(circle);
                this.basketball = null;
                this.canvas.renderAll();
            } else {
                this.draggingPlayer = circle;
                if (this.rotatingPlayer) {
                    this.rotatingPlayer.set('shadow', null);
                }
                if (this.rotatingDefensivePlayer) {
                    this.rotatingDefensivePlayer.set('shadow', null);
                }
                circle.set('shadow', new fabric.Shadow({
                    color: 'rgba(0,0,0,0.5)',
                    blur: 10,
                    offsetX: 5,
                    offsetY: 5,
                }));
                this.canvas.renderAll();
            }
        },
        handleMouseDown(options) {
            const pointer = this.canvas.getPointer(options.e);
            if (this.selectedPlayer && !this.draggingPlayer) {
                this.placePlayer(pointer);
            } else if (this.draggingPlayer) {
                this.dropPlayer(pointer);
            } else if (this.selectedDefensivePlayer && !this.draggingPlayer) {
                this.placeDefensivePlayer(pointer);
            } else if (this.draggingPlayer) {
                this.dropPlayer(pointer);
            }
        },
        placePlayer(pointer) {
            if (this.selectedPlayer && !this.draggingPlayer) {
                const circle = new fabric.Circle({
                    radius: 15,
                    fill: 'black',
                    stroke: 'orange',
                    strokeWidth: 2,
                    originX: 'center',
                    originY: 'center',
                    hasControls: false,
                    hasBorders: false,
                    lockMovementX: false,
                    lockMovementY: false,
                });

                const text = new fabric.Text(this.selectedNumber.toString(), {
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold',
                    fill: 'white',
                    originX: 'center',
                    originY: 'center',
                    textAlign: 'center',
                });

                const group = new fabric.Group([circle, text], {
                    left: pointer.x,
                    top: pointer.y,
                    originX: 'center',
                    originY: 'center',
                    hasControls: false,
                    hasBorders: false,
                    lockMovementX: false,
                    lockMovementY: false,
                });

                group.on('mousedown', () => this.selectPlayer(group));
                this.canvas.add(group);
                this.canvas.renderAll();
                this.selectedPlayer = false;
            }
        },
        placeDefensivePlayer(pointer) {
            if (this.selectedDefensivePlayer && !this.draggingPlayer) {
                const rect = new fabric.Rect({
                    width: 30,
                    height: 30,
                    fill: 'blue',
                    stroke: 'white',
                    strokeWidth: 2,
                    originX: 'center',
                    originY: 'center',
                    hasControls: false,
                    hasBorders: false,
                    lockMovementX: false,
                    lockMovementY: false,
                });

                const line1 = new fabric.Line([15, -15, -15, -15], {
                    stroke: 'white',
                    strokeWidth: 2,
                    originX: 'center',
                    originY: 'center',
                });

                const line2 = new fabric.Line([-15, 15, 15, 15], {
                    stroke: 'white',
                    strokeWidth: 2,
                    originX: 'center',
                    originY: 'center',
                });

                const text = new fabric.Text(this.selectedDefensiveNumber.toString(), {
                    fontSize: 20,
                    fontFamily: 'Arial',
                    fontWeight: 'bold',
                    fill: 'white',
                    originX: 'center',
                    originY: 'center',
                    textAlign: 'center',
                });

                const group = new fabric.Group([rect, line1, line2, text], {
                    left: pointer.x,
                    top: pointer.y,
                    originX: 'center',
                    originY: 'center',
                    hasControls: false,
                    hasBorders: false,
                    lockMovementX: false,
                    lockMovementY: false,
                });

                group.on('mousedown', () => this.selectPlayer(group));
                this.canvas.add(group);
                this.canvas.renderAll();
                this.selectedDefensivePlayer = false;
            }
        },
        selectPlayer(group) {
            if (this.removingPlayer) {
                this.canvas.remove(group);
                this.canvas.renderAll();
            } else {
                if (this.rotatingPlayer) {
                    this.rotatingPlayer.set('shadow', null);
                }
                if (this.rotatingDefensivePlayer) {
                    this.rotatingDefensivePlayer.set('shadow', null);
                }
                this.draggingPlayer = group;
                if (group.getObjects()[0].type === 'circle') {
                    this.rotatingPlayer = group;
                } else {
                    this.rotatingDefensivePlayer = group;
                }
                group.set('shadow', new fabric.Shadow({
                    color: 'rgba(0,0,0,0.5)',
                    blur: 10,
                    offsetX: 5,
                    offsetY: 5,
                }));
                this.canvas.renderAll();
            }
        },
        dropPlayer(pointer) {
            this.draggingPlayer = null;
        },
        rotatePlayer() {
            if (this.rotatingPlayer) {
                this.rotatingPlayer.rotate((this.rotatingPlayer.angle + 45) % 360);
                this.canvas.renderAll();
            }
        },
        rotateDefensivePlayer() {
            if (this.rotatingDefensivePlayer) {
                this.rotatingDefensivePlayer.rotate((this.rotatingDefensivePlayer.angle + 45) % 360);
                this.canvas.renderAll();
            }
        },
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.updateCanvasSize);
    },
};
</script>



<style scoped>
.bg-gray-200 {
    background-color: #e2e8f0;
}

.h-full {
    height: 100%;
}
</style>
