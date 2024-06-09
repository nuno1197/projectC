<template>
    <div class="flex h-screen">
        <div ref="canvasContainer" class="w-3/4 relative bg-yellow-100 h-full">
            <canvas ref="fabricCanvas"></canvas>
        </div>
        <div class="w-1/4 bg-gray-200 p-2 flex flex-col items-center overflow-y-auto">
            <h1 class="text-rich_black text-lg font-bold mb-2">Control Panel</h1>
            <div class="flex items-center justify-between w-full mb-1 space-x-1">
                <button @click="handleButtonClick(toggleCourt)" class="bg-blue-500 text-white px-1 py-1 rounded text-sm">
                    {{ buttonLabel }}
                </button>
                <button @click="handleButtonClick(addBasketball)" class="bg-flax text-white px-1 py-1 rounded text-sm relative group">
                    <img :src="basketballImage" class="w-6 h-6">
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Add Basketball</span>
                </button>
                <button @click="deleteAllElements" class="bg-red-600 text-white px-2 py-1 rounded relative group text-sm">
                    <i class="fa-solid fa-trash"></i>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Delete All</span>
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
                    <button @click="handleButtonClick(toggleSelection)" :class="{'border-2 border-rich_black': selectedPlayer}" class="bg-white border-2 border-orange_fruit text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
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
                    <button @click="handleButtonClick(toggleDefensiveSelection)" :class="{'border-2 border-rich_black': selectedDefensivePlayer}" class="bg-white border-2 border-orange_fruit text-rich_black px-2 py-1 rounded flex items-center mr-1 text-sm">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center border-4 border-white">
                            {{ selectedDefensiveNumber }}
                        </div>
                    </button>
                </div>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Action Lines</h2>
            <div class="grid grid-cols-2 gap-4 items-center mb-2">
                <button @click="handleButtonClick(startDrawingArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingArrow}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="solidArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingDottedArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingDottedArrow}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="dottedArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingWavyArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingWavyArrow}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="wavyArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingBlockArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingBlockArrow}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm">
                    <img :src="blockArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingShootAction)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingShootAction}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm">
                    <img :src="ShootActionImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingHandoff)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingHandoff}" class="bg-white border-2 border-orange_fruit text-white px-1 py-1 rounded text-sm">
                    <img :src="handoffImage" class="w-20 h-20 rounded-md">
                </button>
            </div>
            <div class="w-full border-t border-gray-400 my-2"></div>
            <h2 class="text-rich_black text-lg font-bold mb-2">Other Actions</h2>
            <div class="grid grid-cols-2 gap-4 items-center mb-2">
                <button @click="handleButtonClick(addTextBox)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingAddingText}" class="bg-white border-2 border-orange_fruit text-rich_black px-1 py-1 rounded text-sm w-full h-20">
                    <span class="text-lg text-rich_black font-bold">Add Text </span>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Add Text</span>
                </button>
                <button @click="handleButtonClick(addCone)" class="bg-white items-center border-2 border-orange_fruit text-rich_black px-1 py-1 rounded text-sm w-full h-20">
                    <img :src="trafficConeImage" class="ml-4 w-10 h-10 ">
                </button>
            </div>
            <div class="w-full flex items-center justify-center my-2">
                <button @click="previousShape" class="bg-gray-500 text-white px-1 py-1 rounded-l text-sm">
                    &lt;
                </button>
                <div class="flex items-center justify-center border-2 border-gray-400 p-2">
                    <img :src="shapeIcon" class="w-20 h-20">
                </div>
                <button @click="nextShape" class="bg-gray-500 text-white px-1 py-1 rounded-r text-sm">
                    &gt;
                </button>

                <button @click="handleButtonClick(startDrawingShape)" class="bg-white border-2 border-orange_fruit text-rich_black px-1 py-1 rounded text-sm ml-4">
                    <span class="text-lg text-rich_black font-bold">Add Shape </span>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 w-max bg-black text-white text-xs font-bold py-1 px-2 rounded hidden group-hover:block">Add Shape</span>
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
            isDrawingWavyArrow: false,
            isDrawingBlockArrow: false,
            isDrawingShootAction: false,
            isDrawingHandoff: false,
            isDrawingAddingText: false,
            arrow: null,
            basketballImage: '/images/buttons/basketball.png',
            solidArrowImage: '/images/buttons/solid_arrow.png',
            dottedArrowImage: '/images/buttons/dotted_arrow.png',
            wavyArrowImage: '/images/buttons/wavy_arrow.png',
            blockArrowImage: '/images/buttons/block_arrow.png',
            ShootActionImage: '/images/buttons/target_button.png',
            handoffImage: '/images/buttons/handoff_action.png',
            trafficConeImage: '/images/buttons/traffic-cone.png',
            shapes: ['circle', 'rectangle', 'triangle'],
            currentShapeIndex: 0,
            isDrawingShape: false
        };
    },
    computed: {
        courtImageUrl() {
            return this.isFullCourt ? '/images/court/fullcourt.png' : '/images/court/halfcourt.png';
        },
        buttonLabel() {
            return this.isFullCourt ? 'Toggle Half-Court' : 'Toggle Full-Court';
        },
        shapeIcon() {
            switch (this.shapes[this.currentShapeIndex]) {
                case 'circle':
                    return '/images/buttons/circle.png'; // Atualize com o caminho correto da imagem
                case 'rectangle':
                    return '/images/buttons/rectangle.png'; // Atualize com o caminho correto da imagem
                case 'triangle':
                    return '/images/buttons/triangle.png'; // Atualize com o caminho correto da imagem
                default:
                    return '';
            }
        }
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
            if (canvasContainer) {
                const width = canvasContainer.clientWidth;
                const height = canvasContainer.clientHeight;
                canvas.setWidth(width);
                canvas.setHeight(height);
                if (this.courtImage) {
                    this.adjustCourtImageSize();
                }
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
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false;
            this.isDrawingAddingText = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingShape = false;

            if (typeof action === 'function') {
                action();
            }
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
        addCone() {
            fabric.Image.fromURL(this.trafficConeImage, (img) => {
                img.scaleToWidth(30);
                img.set({
                    left: canvas.getWidth() / 2,
                    top: canvas.getHeight() / 2,
                    originX: 'center',
                    originY: 'center',
                    hasControls: true,
                    hasBorders: true,
                });
                img.on('mousedown', () => this.selectCone(img));
                canvas.add(img);
                this.cone = img;
                canvas.renderAll();
            });
        },
        startDrawingArrow() {
            this.isDrawingArrow = true;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false; // Reset handoff flag
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingDottedArrow() {
            this.isDrawingDottedArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false; // Reset handoff flag
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingWavyArrow() {
            this.isDrawingWavyArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false; // Reset handoff flag
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingBlockArrow() {
            this.isDrawingBlockArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false; // Reset handoff flag
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingShootAction() {
            this.isDrawingShootAction = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingHandoff = false; // Reset handoff flag
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingHandoff() { // Adicionei a função para iniciar o handoff
            this.isDrawingHandoff = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
        },
        startDrawingShape() {
            this.isDrawingShape = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
            this.isDrawingAddingText = false;
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
        selectCone(img) {
            if (this.removingPlayer) {
                canvas.remove(img);
                this.cone = null;
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
            } else if (this.isDrawingWavyArrow) {
                this.startWavyArrow(pointer);
            } else if (this.isDrawingBlockArrow) {
                this.startBlockArrow(pointer);
            } else if (this.isDrawingShootAction) {
                this.startShootAction(pointer);
            } else if (this.isDrawingHandoff) {
                this.startHandoff(pointer);
            } else if (this.isDrawingAddingText) {
                this.addTextBox(pointer);
            } else if (this.isDrawingShape) { // Adicione esta verificação
                this.addShape(pointer);
            }
        },
        handleMouseMove(options) {
            if (this.isDrawingArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateArrow(pointer);
            } else if (this.isDrawingDottedArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateDottedArrow(pointer);
            } else if (this.isDrawingWavyArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateWavyArrow(pointer);
            } else if (this.isDrawingBlockArrow && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateBlockArrow(pointer);
            } else if (this.isDrawingShootAction && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateShootAction(pointer);
            } else if (this.isDrawingHandoff && this.arrow) {
                const pointer = canvas.getPointer(options.e);
                this.updateHandoff(pointer);
            }
        },
        handleMouseUp() {
            if (this.isDrawingArrow && this.arrow) {
                this.finishDrawingArrow();
            } else if (this.isDrawingDottedArrow && this.arrow) {
                this.finishDrawingDottedArrow();
            } else if (this.isDrawingWavyArrow && this.arrow) {
                this.finishDrawingWavyArrow();
            } else if (this.isDrawingBlockArrow && this.arrow) {
                this.finishDrawingBlockArrow();
            } else if (this.isDrawingShootAction && this.arrow) {
                this.finishDrawingShootAction();
            } else if (this.isDrawingHandoff && this.arrow) {
                this.finishDrawingHandoff();
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
        startWavyArrow(pointer) {
            fabric.loadSVGFromURL(this.wavyArrowImage, (objects, options) => {
                const group = fabric.util.groupSVGElements(objects || [], options || {});
                group.set({
                    left: pointer.x,
                    top: pointer.y,
                    hasControls: true,
                    hasBorders: true,
                    selectable: true,
                });
                group.scaleToWidth(100);
                group.on('mousedown', () => this.selectArrow(group));
                canvas.add(group);
                this.arrow = group;
            });
        },
        startBlockArrow(pointer) {
            fabric.loadSVGFromURL(this.blockArrowImage, (objects, options) => {
                const group = fabric.util.groupSVGElements(objects || [], options || {});
                group.set({
                    left: pointer.x,
                    top: pointer.y,
                    hasControls: true,
                    hasBorders: true,
                    selectable: true,
                });
                group.scaleToWidth(100);
                group.on('mousedown', () => this.selectArrow(group));
                canvas.add(group);
                this.arrow = group;
            });
        },
        startShootAction(pointer) {
            fabric.loadSVGFromURL(this.ShootActionImage, (objects, options) => {
                const group = fabric.util.groupSVGElements(objects || [], options || {});
                group.set({
                    left: pointer.x,
                    top: pointer.y,
                    hasControls: true,
                    hasBorders: true,
                    selectable: true,
                });
                group.scaleToWidth(100);
                group.on('mousedown', () => this.selectArrow(group));
                canvas.add(group);
                this.arrow = group;
            });
        },
        startHandoff(pointer) { // Adicionei a função para desenhar o handoff
            fabric.loadSVGFromURL(this.handoffImage, (objects, options) => {
                const group = fabric.util.groupSVGElements(objects || [], options || {});
                group.set({
                    left: pointer.x,
                    top: pointer.y,
                    hasControls: true,
                    hasBorders: true,
                    selectable: true,
                });
                group.scaleToWidth(100);
                group.on('mousedown', () => this.selectArrow(group));
                canvas.add(group);
                this.arrow = group;
            });
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
        updateWavyArrow(pointer) {
            this.arrow.set({
                left: pointer.x,
                top: pointer.y,
            });
            canvas.renderAll();
        },
        updateBlockArrow(pointer) {
            this.arrow.set({
                left: pointer.x,
                top: pointer.y,
            });
            canvas.renderAll();
        },
        updateShootAction(pointer) {
            this.arrow.set({
                left: pointer.x,
                top: pointer.y,
            });
            canvas.renderAll();
        },
        updateHandoff(pointer) {
            this.arrow.set({
                left: pointer.x,
                top: pointer.y,
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
            canvas.remove(this.arrow); // Remove the line alone
            canvas.add(arrowGroup); // Add the group containing the line and arrowhead
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
            canvas.remove(this.arrow); // Remove the line alone
            canvas.add(arrowGroup); // Add the group containing the line and arrowhead
            this.arrow = null;
            this.isDrawingDottedArrow = false;
            canvas.renderAll();
        },
        finishDrawingWavyArrow() {
            this.arrow = null;
            this.isDrawingWavyArrow = false;
            canvas.renderAll();
        },
        finishDrawingBlockArrow() {
            this.arrow = null;
            this.isDrawingBlockArrow = false;
            canvas.renderAll();
        },
        finishDrawingShootAction() {
            this.arrow = null;
            this.isDrawingShootAction = false;
            canvas.renderAll();
        },
        finishDrawingHandoff() { // Adicionei a função para finalizar o handoff
            this.arrow = null;
            this.isDrawingHandoff = false;
            canvas.renderAll();
        },
        addTextBox() {
            const text = new fabric.IText('Double-click to edit', {
                left: canvas.getWidth() / 2,
                top: canvas.getHeight() / 2,
                fontFamily: 'Arial',
                fontSize: 20,
                fill: 'black',
                editable: true,
                hasControls: true,
                hasBorders: true,
            });
            text.on('mousedown', () => this.selectTextBox(text));
            canvas.add(text);
            canvas.renderAll();
        },
        selectTextBox(text) {
            if (this.removingPlayer) {
                canvas.remove(text);
                canvas.renderAll();
            }
        },
        selectArrow(arrowGroup) {
            if (this.removingPlayer) {
                canvas.remove(arrowGroup);
                canvas.renderAll();
            }
        },
        deleteAllElements() {
            canvas.getObjects().forEach((obj) => {
                if (obj !== this.courtImage) {
                    canvas.remove(obj);
                }
            });
            canvas.renderAll();
        },
        previousShape() {
            if (this.currentShapeIndex > 0) {
                this.currentShapeIndex--;
            } else {
                this.currentShapeIndex = this.shapes.length - 1;
            }
        },
        nextShape() {
            if (this.currentShapeIndex < this.shapes.length - 1) {
                this.currentShapeIndex++;
            } else {
                this.currentShapeIndex = 0;
            }
        },
        addShape(pointer) {
            const shapeType = this.shapes[this.currentShapeIndex];
            let shape;
            switch (shapeType) {
                case 'circle':
                    shape = new fabric.Circle({
                        radius: 25,
                        fill: 'rgba(255, 255, 0, 0.5)', // cor amarela transparente
                        left: pointer.x,
                        top: pointer.y,
                        originX: 'center',
                        originY: 'center',
                        stroke: 'black',
                        strokeWidth: 2,
                    });
                    break;
                case 'rectangle':
                    shape = new fabric.Rect({
                        width: 50,
                        height: 50,
                        fill: 'rgba(255, 255, 0, 0.5)', // cor amarela transparente
                        left: pointer.x,
                        top: pointer.y,
                        originX: 'center',
                        originY: 'center',
                        stroke: 'black',
                        strokeWidth: 2,
                    });
                    break;
                case 'triangle':
                    shape = new fabric.Triangle({
                        width: 50,
                        height: 50,
                        fill: 'rgba(255, 255, 0, 0.5)', // cor amarela transparente
                        left: pointer.x,
                        top: pointer.y,
                        originX: 'center',
                        originY: 'center',
                        stroke: 'black',
                        strokeWidth: 2,
                    });
                    break;
            }
            shape.on('mousedown', () => this.selectShape(shape));
            canvas.add(shape);
            shape.moveTo(1); // Mover a forma para trás de todos os elementos, exceto o court
            canvas.renderAll();
            this.isDrawingShape = false;
        },
        selectShape(shape) {
            if (this.removingPlayer) {
                canvas.remove(shape);
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

.overflow-y-auto {
    overflow-y: auto;
}

button {
    cursor: pointer;
}

button:focus {
    outline: none;
}
</style>
