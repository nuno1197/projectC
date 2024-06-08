<template>
    <div class="flex h-screen">
        <div ref="canvasContainer" class="w-3/4 relative bg-yellow-100 h-full">
            <canvas ref="fabricCanvas"></canvas>
        </div>
        <div class="w-1/4 bg-gray-200 p-2 flex flex-col items-center">
            <h1 class="text-rich_black text-lg font-bold mb-2">Control Panel</h1>
            <div class="flex items-center justify-between w-full mb-1 space-x-1">
                <button @click="handleButtonClick(toggleCourt)" class="bg-blue-500 text-white px-1 py-1 rounded text-sm">
                    {{ buttonLabel }}
                </button>
                <button @click="handleButtonClick(addBasketball)" class="bg-flax text-white px-1 py-1 rounded text-sm relative group">
                    <img :src="basketballImage" class="w-6 h-6">
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Add Basketball</span>
                </button>
                <button @click="handleButtonClick(enableRemovePlayer)" :class="{'border-2 border-pacific_cyan shadow-md': removingPlayer}" class="bg-red-500 text-white px-2 py-1 rounded relative group text-sm">
                    X
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Remove Item</span>
                </button>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Offensive Players</h2>
            <div class="flex flex-col items-center mb-2">
                <div class="flex items-center mb-1">
                    <button @click="handleButtonClick(decreaseNumber)" class="bg-gray-500 text-white px-1 py-1 rounded-l text-sm">◀</button>
                    <span class="bg-white text-rich_black font-bold px-2 py-1 border text-sm">{{ selectedNumber }}</span>
                    <button @click="handleButtonClick(increaseNumber)" class="bg-gray-500 text-white px-1 py-1 rounded-r text-sm">▶</button>
                </div>
                <div class="flex items-center mb-2">
                    <button @click="handleButtonClick(toggleSelection)" :class="{'border-2 border-rich_black': selectedPlayer}" class="bg-white text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
                        <div class="w-8 h-8 rounded-full bg-rich_black text-white font-bold flex items-center justify-center border-4 border-orange_fruit">
                            {{ selectedNumber }}
                        </div>
                    </button>
                </div>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Defensive Players</h2>
            <div class="flex flex-col items-center mb-2">
                <div class="flex items-center mb-1">
                    <button @click="handleButtonClick(decreaseDefensiveNumber)" class="bg-gray-500 text-white px-1 py-1 rounded-l text-sm">◀</button>
                    <span class="bg-white text-rich_black font-bold px-2 py-1 border text-sm">{{ selectedDefensiveNumber }}</span>
                    <button @click="handleButtonClick(increaseDefensiveNumber)" class="bg-gray-500 text-white px-1 py-1 rounded-r text-sm">▶</button>
                </div>
                <div class="flex items-center mb-2">
                    <button @click="handleButtonClick(toggleDefensiveSelection)" :class="{'border-2 border-rich_black': selectedDefensivePlayer}" class="bg-white text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center border-4 border-white">
                            {{ selectedDefensiveNumber }}
                        </div>
                    </button>
                </div>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Action Lines</h2>
            <div class="flex flex-row items-center mb-2">
                <button @click="handleButtonClick(startDrawingArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="solidArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingDottedArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingDottedArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm">
                    <img :src="dottedArrowImage" class="w-20 h-20 rounded-md">
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { fabric } from 'fabric';

let canvas;

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
            courtImage: null,
            rotatingPlayer: null,
            defensivePlayers: [],
            selectedDefensiveNumber: 1,
            selectedDefensivePlayer: false,
            rotatingDefensivePlayer: null,
            basketball: null,
            isDrawingArrow: false,
            isDrawingDottedArrow: false,
            arrow: null,
            basketballImage: '/images/buttons/basketball.png',
            solidArrowImage: '/images/buttons/solid_arrow.png',
            dottedArrowImage: '/images/buttons/dotted_arrow.png', // Adicione a imagem da dotted arrow
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
            canvas = new fabric.Canvas(canvasElement);
            this.updateCanvasSize();
            window.addEventListener('resize', this.updateCanvasSize);
            canvas.on('mouse:down', this.handleMouseDown);
            canvas.on('mouse:move', this.handleMouseMove);
            canvas.on('mouse:up', this.handleMouseUp);
        },
        updateCanvasSize() {
            const canvasContainer = this.$refs.canvasContainer;
            const width = canvasContainer.clientWidth;
            const height = canvasContainer.clientHeight;
            canvas.setWidth(width);
            canvas.setHeight(height);
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
                canvas.setBackgroundImage(img, this.adjustCourtImageSize.bind(this));
            });
        },
        adjustCourtImageSize() {
            const canvasWidth = canvas.getWidth();
            const canvasHeight = canvas.getHeight();
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

            canvas.renderAll();
        },
        handleButtonClick(action) {
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            action();
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
            fabric.Image.fromURL(this.basketballImage, (img) => {
                img.scaleToWidth(30);
                img.set({
                    left: canvas.getWidth() / 2,
                    top: canvas.getHeight() / 2,
                    originX: 'center',
                    originY: 'center',
                    hasControls: true,
                    hasBorders: true,
                });
                img.on('mousedown', () => this.selectBasketball(img));
                canvas.add(img);
                this.basketball = img;
                canvas.renderAll();
            });
        },
        startDrawingArrow() {
            this.isDrawingArrow = true;
            this.isDrawingDottedArrow = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startDrawingDottedArrow() {
            this.isDrawingDottedArrow = true;
            this.isDrawingArrow = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        selectBasketball(img) {
            if (this.removingPlayer) {
                canvas.remove(img);
                this.basketball = null;
                canvas.renderAll();
            } else {
                this.draggingPlayer = img;
                if (this.rotatingPlayer) {
                    this.rotatingPlayer.set('shadow', null);
                }
                if (this.rotatingDefensivePlayer) {
                    this.rotatingDefensivePlayer.set('shadow', null);
                }
                img.set('shadow', new fabric.Shadow({
                    color: 'rgba(0,0,0,0.5)',
                    blur: 10,
                    offsetX: 5,
                    offsetY: 5,
                }));
                canvas.renderAll();
            }
        },
        handleMouseDown(options) {
            const pointer = canvas.getPointer(options.e);
            if (this.selectedPlayer && !this.draggingPlayer) {
                this.placePlayer(pointer);
            } else if (this.draggingPlayer) {
                this.dropPlayer(pointer);
            } else if (this.selectedDefensivePlayer && !this.draggingPlayer) {
                this.placeDefensivePlayer(pointer);
            } else if (this.draggingPlayer) {
                this.dropPlayer(pointer);
            } else if (this.isDrawingArrow) {
                this.startArrow(pointer);
            } else if (this.isDrawingDottedArrow) {
                this.startDottedArrow(pointer);
            }
        },
        handleMouseMove(options) {
            if (this.isDrawingArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateArrow(pointer);
            } else if (this.isDrawingDottedArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateDottedArrow(pointer);
            }
        },
        handleMouseUp() {
            if (this.isDrawingArrow && this.arrow) {
                this.finishDrawingArrow();
            } else if (this.isDrawingDottedArrow && this.arrow) {
                this.finishDrawingDottedArrow();
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
                    hasControls: true,
                    hasBorders: true,
                });

                group.on('mousedown', () => this.selectPlayer(group));
                canvas.add(group);
                canvas.renderAll();
                this.selectedPlayer = false;
            }
        },
        placeDefensivePlayer(pointer) {
            if (this.selectedDefensivePlayer && !this.draggingPlayer) {
                const svgStringTemplate = `
            <svg width="500" height="500" xmlns="http://www.w3.org/2000/svg">

             <g>
              <title>Layer 1</title>
              <ellipse stroke-width="5" transform="rotate(0.939269, 241.25, 237)" ry="46.89259" rx="47.85158" id="svg_1" cy="236.99996" cx="241.25003" stroke="#bf0000" fill="#7f0000"/>
              <path id="svg_3" d="m72.49996,67.9999" opacity="undefined" stroke="#000" fill="none"/>
              <path stroke-width="5" id="svg_12" d="m194.99992,235.99985l-104.49997,52.49999" opacity="undefined" stroke="#bf0000" fill="#ff0000"/>
              <path stroke-width="5" id="svg_13" d="m388.5902,235.72688l-102.18059,56.54599" transform="rotate(-117, 337.5, 264)" opacity="undefined" stroke="#bf0000" fill="none"/>
              <text transform="matrix(10.3022, 0, 0, 5.60117, -283.955, -197.254)" xml:space="preserve" text-anchor="start" font-family="Noto Sans JP" font-size="10" stroke-width="0" id="svg_14" y="80.61354" x="48.69844" stroke="#000" fill="#e5e5e5">{{number}}</text>
             </g>
            </svg>
            `;

                const svgString = svgStringTemplate.replace('{{number}}', this.selectedDefensiveNumber);

                fabric.loadSVGFromString(svgString, (objects, options) => {
                    const group = fabric.util.groupSVGElements(objects, options);
                    group.scaleToWidth(150); // Ajuste o tamanho conforme necessário
                    group.set({
                        left: pointer.x,
                        top: pointer.y,
                        originX: 'center',
                        originY: 'center',
                        hasControls: true,
                        hasBorders: true,
                    });

                    group.on('mousedown', () => this.selectPlayer(group));
                    canvas.add(group);
                    canvas.renderAll();
                    this.selectedDefensivePlayer = false;
                });
            }
        },

        selectPlayer(group) {
            if (this.removingPlayer) {
                canvas.remove(group);
                canvas.renderAll();
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
                canvas.renderAll();
            }
        },
        dropPlayer(pointer) {
            this.draggingPlayer = null;
        },
        startArrow(pointer) {
            this.arrow = new fabric.Line([pointer.x, pointer.y, pointer.x, pointer.y], {
                fill: 'black',
                stroke: 'black',
                strokeWidth: 5,
                selectable: false,
                evented: false,
            });
            canvas.add(this.arrow);
        },
        startDottedArrow(pointer) {
            this.arrow = new fabric.Line([pointer.x, pointer.y, pointer.x, pointer.y], {
                fill: 'black',
                stroke: 'black',
                strokeWidth: 5,
                strokeDashArray: [5, 5],
                selectable: false,
                evented: false,
            });
            canvas.add(this.arrow);
        },
        updateArrow(pointer) {
            this.arrow.set({
                x2: pointer.x,
                y2: pointer.y,
            });
            canvas.renderAll();
        },
        updateDottedArrow(pointer) {
            this.arrow.set({
                x2: pointer.x,
                y2: pointer.y,
            });
            canvas.renderAll();
        },
        finishDrawingArrow() {
            const pointer = {
                x: this.arrow.x2,
                y: this.arrow.y2,
            };

            const angle = Math.atan2(pointer.y - this.arrow.y1, pointer.x - this.arrow.x1);
            const arrowHead = new fabric.Triangle({
                width: 20,
                height: 20,
                fill: 'black',
                left: pointer.x,
                top: pointer.y,
                angle: angle * (180 / Math.PI) + 90,
                originX: 'center',
                originY: 'center',
            });

            const arrowGroup = new fabric.Group([this.arrow, arrowHead], {
                selectable: true,
                hasControls: true,
                hasBorders: true,
            });

            arrowGroup.on('mousedown', () => this.selectArrow(arrowGroup));
            canvas.remove(this.arrow);
            canvas.add(arrowGroup);
            this.arrow = null;
            this.isDrawingArrow = false;
            canvas.renderAll();
        },
        finishDrawingDottedArrow() {
            const pointer = {
                x: this.arrow.x2,
                y: this.arrow.y2,
            };

            const angle = Math.atan2(pointer.y - this.arrow.y1, pointer.x - this.arrow.x1);
            const arrowHead = new fabric.Triangle({
                width: 20,
                height: 20,
                fill: 'black',
                left: pointer.x,
                top: pointer.y,
                angle: angle * (180 / Math.PI) + 90,
                originX: 'center',
                originY: 'center',
            });

            const arrowGroup = new fabric.Group([this.arrow, arrowHead], {
                selectable: true,
                hasControls: true,
                hasBorders: true,
            });

            arrowGroup.on('mousedown', () => this.selectArrow(arrowGroup));
            canvas.remove(this.arrow);
            canvas.add(arrowGroup);
            this.arrow = null;
            this.isDrawingDottedArrow = false;
            canvas.renderAll();
        },
        selectArrow(arrowGroup) {
            if (this.removingPlayer) {
                canvas.remove(arrowGroup);
                canvas.renderAll();
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
