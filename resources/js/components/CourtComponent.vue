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
            <div class="grid grid-cols-2 gap-4 items-center mb-2">
                <button @click="handleButtonClick(startDrawingArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="solidArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingDottedArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingDottedArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="dottedArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingWavyArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingWavyArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm mr-2">
                    <img :src="wavyArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingBlockArrow)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingBlockArrow}" class="bg-green-500 text-white px-1 py-1 rounded text-sm">
                    <img :src="blockArrowImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingShootAction)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingShootAction}" class="bg-green-500 text-white px-1 py-1 rounded text-sm">
                    <img :src="ShootActionImage" class="w-20 h-20 rounded-md">
                </button>
                <button @click="handleButtonClick(startDrawingHandoff)" :class="{'border-2 border-pacific_cyan shadow-md': isDrawingHandoff}" class="bg-green-500 text-white px-1 py-1 rounded text-sm">
                    <img :src="handoffImage" class="w-20 h-20 rounded-md">
                </button>
            </div>
        </div>
    </div>
</template>


<script>
import { fabric } from 'fabric';

let canvas;

// Adicione o código SVG da seta ondulada aqui
const wavyArrowSVG = `<svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" version="1.0">
 <g>
  <title>Layer 1</title>
  <g id="svg_1" fill="#000000" transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
   <path id="svg_2" d="m4355,4861c-258,-70 -482,-131 -498,-135c-38,-9 -67,-41 -67,-72c0,-21 38,-65 177,-206c141,-142 175,-181 163,-188c-8,-5 -94,-35 -190,-66c-274,-89 -374,-148 -455,-269c-67,-101 -88,-193 -105,-462c-16,-235 -41,-317 -127,-413c-33,-37 -69,-62 -136,-95c-104,-51 -188,-74 -397,-111c-185,-32 -277,-56 -367,-93c-154,-63 -290,-178 -339,-285c-51,-111 -51,-217 1,-381c14,-44 30,-107 35,-141c25,-157 -73,-305 -273,-410c-98,-51 -186,-79 -401,-125c-105,-23 -227,-52 -271,-66c-241,-75 -383,-189 -467,-372c-17,-36 -50,-150 -74,-255c-33,-142 -54,-212 -84,-272c-51,-105 -115,-166 -196,-189c-33,-10 -65,-24 -72,-33c-18,-23 -15,-56 8,-77c44,-40 195,19 275,108c91,100 131,196 185,439c48,220 92,314 183,395c102,89 236,141 529,204c224,48 310,75 421,130c160,79 266,179 324,305c22,48 28,77 31,154c3,87 0,106 -34,220c-47,158 -51,241 -14,315c46,96 167,187 318,242c78,29 109,36 342,78c102,19 221,46 265,60c187,61 313,160 379,298c45,94 62,176 76,387c18,272 44,355 139,444c63,58 129,89 336,155c88,28 182,62 210,76l49,24l162,-159c110,-109 168,-160 183,-160c35,0 59,17 70,52c25,78 271,1002 271,1019c0,28 -36,59 -67,58c-16,0 -239,-58 -498,-128z"/>
  </g>
 </g>
</svg>`;

// Adicione o código SVG da seta block aqui
const blockArrowSVG = `<svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" version="1.0" preserveAspectRatio="xMidYMid meet">
 <g>
  <title>Layer 1</title>
  <line stroke-width="30" stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_6" y2="264" x2="357.99999" y1="266" x1="45" stroke="#000" fill="none"/>
  <line transform="rotate(-90, 352.5, 265)" stroke-width="30" stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_7" y2="264" x2="508.99999" y1="266" x1="196" stroke="#000" fill="none"/>
 </g>
</svg>`;

// Adicione o código SVG da nova ação aqui
const ShootActionSVG = `<svg width="524" height="512" xmlns="http://www.w3.org/2000/svg" style="vector-effect: non-scaling-stroke;" preserveAspectRatio="xMidYMid meet" version="1.0">

 <g>
  <title>Layer 1</title>
  <g id="svg_1" fill="#000000" transform="translate(0, 512) scale(0.1, -0.1)">
   <path id="svg_2" d="m1755.57218,3448.22802c-9.25233,-6.81392 -10.86143,-15.57468 -10.86143,-60.10852l0,-39.4234l-13.47622,-1.70348c-69.19132,-8.03069 -130.73942,-32.36612 -185.64997,-72.76294c-115.85524,-85.66072 -190.47727,-227.53628 -205.56259,-390.34032l-2.41365,-27.25568l-32.78542,0c-37.00931,0 -44.65254,-2.19019 -49.68098,-14.3579c-4.02275,-9.24746 -4.02275,-15.57468 0,-24.82214c5.02844,-12.16772 12.67167,-14.3579 49.68098,-14.3579l32.78542,0l2.41365,-27.25568c22.52741,-244.81444 180.4204,-435.84758 382.16137,-462.12984l22.52741,-2.92025l0,-39.91011c0,-44.77719 1.81024,-54.02466 11.86712,-60.10852c7.64323,-4.86709 12.8728,-4.86709 20.51603,0c10.05688,6.08386 11.86712,15.33132 11.86712,60.10852l0,39.91011l22.72854,2.92025c201.53984,26.28227 360.03624,218.04547 381.7591,462.12984l2.41365,27.25568l32.98656,0c37.00931,0 44.65254,2.19019 49.68098,14.3579c4.22389,9.73417 4.02275,16.79145 -0.80455,26.28227c-5.43071,10.70759 -13.47622,12.89778 -50.48553,12.89778l-31.37746,0l-2.41365,27.49904c-12.8728,142.84898 -74.01862,273.53025 -168.151,359.43432c-65.77198,59.86516 -137.98037,93.44806 -222.65928,103.42558l-13.67735,1.70348l0,39.91011c0,45.02055 -1.81024,54.26801 -11.86712,60.35187c-8.0455,5.11044 -13.87849,4.86709 -21.52172,-0.73006zm-10.86143,-203.20085l0,-52.32118l-9.45347,-1.46013c-72.40952,-11.43765 -130.136,-45.02055 -179.61584,-104.399c-48.87643,-58.40504 -78.84593,-133.11481 -87.49484,-217.3154l-1.40796,-12.89778l-42.64116,0l-42.64116,0l1.6091,19.95505c15.68873,196.63029 134.96331,361.62451 294.26426,407.13177c17.90124,5.11044 39.02069,9.24746 59.33558,11.68101c3.82161,0.48671 7.24095,1.21677 7.64323,1.21677c0.20114,0.24335 0.40228,-22.87531 0.40228,-51.59111zm89.50622,44.53384c77.43796,-16.54809 149.44521,-62.05535 205.16032,-129.70785c63.76061,-77.63003 102.7813,-176.67523 111.22907,-283.26442l1.6091,-19.95505l-42.64116,0l-42.64116,0l-1.40796,12.89778c-11.06257,108.77938 -58.12876,201.74073 -132.54965,262.33595c-39.42296,32.12277 -82.4664,51.10441 -134.35989,59.37845l-9.6546,1.46013l0,51.83447l0,51.59111l16.49328,-1.94683c9.05119,-0.97342 21.92399,-3.16361 28.76267,-4.62373zm-89.50622,-189.81637c0,-44.53384 1.81024,-52.80789 13.07394,-59.1351c3.62048,-2.19019 7.64323,-3.89367 9.05119,-3.89367c1.40796,0 5.43071,1.70348 9.05119,3.89367c11.2637,6.32721 13.07394,14.60126 13.07394,59.1351l0,39.18004l6.63754,0c17.90124,-0.24335 60.54241,-15.08797 84.88005,-29.68923c48.67529,-29.44587 92.92555,-82.98382 117.2632,-141.87557c12.06825,-29.44587 24.33765,-81.03699 24.53878,-102.69552l0,-8.03069l-29.9695,0c-35.19907,0 -40.83093,-0.97342 -47.26733,-9.00411c-6.83868,-8.27405 -8.24664,-18.00822 -4.22389,-28.47245c5.43071,-13.8712 12.06825,-16.06138 49.07757,-16.06138l32.38315,0l0,-7.78734c-0.20114,-21.90189 -12.47053,-73.493 -24.53878,-102.93888c-24.13651,-58.16168 -67.9845,-111.69963 -115.25182,-140.41544c-25.34333,-15.57468 -58.32989,-27.49904 -86.89143,-31.87942l-6.63754,-0.97342l0,40.15346c0,43.56042 -1.81024,52.80789 -11.06257,58.89174c-6.4364,4.13702 -15.68873,4.13702 -22.12513,0c-9.25233,-6.08386 -11.06257,-15.33132 -11.06257,-58.89174l0,-40.15346l-6.4364,0.97342c-28.76267,4.38038 -61.74923,16.30474 -87.09257,31.87942c-47.26733,28.71581 -91.11532,82.25376 -115.25182,140.41544c-12.06825,29.44587 -24.33765,81.03699 -24.53878,102.93888l0,7.78734l32.38315,0c36.80817,0 43.64685,2.19019 48.87643,15.81803c4.02275,9.97753 4.02275,11.92436 0,21.90189c-5.22958,13.62784 -12.06825,15.81803 -48.87643,15.81803l-32.38315,0l0,8.03069c0.20114,21.65853 12.47053,73.24965 24.53878,102.69552c24.33765,58.89174 68.58791,112.42969 117.2632,141.87557c24.73992,14.84461 65.16857,28.95916 84.0755,29.44587l7.44209,0.24335l0,-39.18004zm-276.56415,-309.30333c8.64892,-84.44395 38.61841,-159.15372 87.49484,-217.55876c49.07757,-58.89174 109.2177,-94.17812 178.61016,-104.399l10.45915,-1.70348l0,-52.07782l0,-52.07782l-7.44209,1.21677c-4.22389,0.48671 -15.28645,2.19019 -24.73992,3.65031c-79.85161,12.41107 -158.69754,60.35187 -218.43539,132.38475c-63.35833,76.89996 -102.58016,176.67523 -111.02794,283.26442l-1.6091,19.95505l42.64116,0l42.64116,0l1.40796,-12.65442zm682.45976,-7.30063c-8.44778,-106.58919 -47.46847,-205.6344 -111.22907,-283.26442c-59.13444,-71.78952 -138.38264,-119.97368 -218.23426,-132.38475c-9.45347,-1.46013 -20.51603,-3.16361 -24.53878,-3.65031l-7.64323,-1.21677l0,52.07782l0,52.07782l10.66029,1.70348c69.39246,10.46424 129.53259,45.50726 178.61016,104.64236c49.07757,58.89174 78.64479,132.87146 87.2937,217.3154l1.40796,12.65442l42.64116,0l42.64116,0l-1.6091,-19.95505z"/>
   <path id="svg_3" d="m1751.34829,2905.5479c-11.86712,-3.65031 -27.75698,-16.30474 -35.19907,-28.2291c-24.94106,-39.66675 -13.67735,-95.8816 23.5331,-118.02684c8.24664,-4.86709 13.07394,-6.08386 27.15357,-6.08386c20.11376,0 32.18201,5.8405 45.25595,21.90189c38.61841,46.72403 13.67735,127.51766 -40.62979,131.41133c-7.44209,0.48671 -16.49328,0.24335 -20.11376,-0.97342zm26.7513,-54.26801c8.85005,-5.11044 12.26939,-22.63195 6.83868,-34.79967c-1.40796,-3.16361 -5.63185,-7.54398 -9.45347,-9.73417c-21.11944,-12.16772 -40.02638,21.17183 -23.33196,41.12688c7.24095,8.76076 15.28645,9.73417 25.94675,3.40696z"/>
  </g>
  <line transform="rotate(-90, 365, 229)" stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_4" y2="89" x2="365" y1="369" x1="365" stroke-width="7" stroke="#000" fill="none"/>
 </g>
</svg>`;

const handoffSVG = `<svg width="524" height="512" xmlns="http://www.w3.org/2000/svg" style="vector-effect: non-scaling-stroke;" preserveAspectRatio="xMidYMid meet" version="1.0">

 <g>
  <title>Layer 1</title>
  <line stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_5" y2="356" x2="186" y1="164" x1="187" stroke-width="7" stroke="#000" fill="none"/>
  <line stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_6" y2="258" x2="374" y1="260" x1="117" stroke-width="7" stroke="#000" fill="none"/>
  <line stroke-linecap="undefined" stroke-linejoin="undefined" id="svg_9" y2="358" x2="311" y1="166" x1="312" stroke-width="7" stroke="#000" fill="none"/>
 </g>
</svg>`;

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
            arrow: null,
            basketballImage: '/images/buttons/basketball.png',
            solidArrowImage: '/images/buttons/solid_arrow.png',
            dottedArrowImage: '/images/buttons/dotted_arrow.png',
            wavyArrowImage: '/images/buttons/wavy_arrow.png',
            blockArrowImage: '/images/buttons/block_arrow.png',
            ShootActionImage: '/images/buttons/target_button.png', // Adicione a imagem da nova ação
            handoffImage: '/images/buttons/handoff_action.png',
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
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.isDrawingHandoff = false; // Adicione esta linha
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
        startDrawingHandoff() {
            this.isDrawingHandoff = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startDrawingDottedArrow() {
            this.isDrawingDottedArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startDrawingWavyArrow() {
            this.isDrawingWavyArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingBlockArrow = false;
            this.isDrawingShootAction = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startDrawingBlockArrow() {
            this.isDrawingBlockArrow = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingShootAction = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startDrawingShootAction() {
            this.isDrawingShootAction = true;
            this.isDrawingArrow = false;
            this.isDrawingDottedArrow = false;
            this.isDrawingWavyArrow = false;
            this.isDrawingBlockArrow = false;
            this.removingPlayer = false;
            this.selectedPlayer = false;
            this.selectedDefensivePlayer = false;
        },
        startHandoff(pointer) {
            fabric.loadSVGFromString(handoffSVG, (objects, options) => {
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
            } else if (this.isDrawingWavyArrow) {
                this.startWavyArrow(pointer);
            } else if (this.isDrawingBlockArrow) {
                this.startBlockArrow(pointer);
            } else if (this.isDrawingShootAction) {
                this.startShootAction(pointer);
            } else if (this.isDrawingHandoff) { // Adicione esta linha
                this.startHandoff(pointer); // Adicione esta linha
            }
        },
        handleMouseMove(options) {
            const pointer = canvas.getPointer(options.e);
            if (this.isDrawingArrow && this.arrow) {
                this.updateArrow(pointer);
            } else if (this.isDrawingDottedArrow && this.arrow) {
                this.updateDottedArrow(pointer);
            } else if (this.isDrawingWavyArrow && this.arrow) {
                this.updateWavyArrow(pointer);
            } else if (this.isDrawingBlockArrow && this.arrow) {
                this.updateBlockArrow(pointer);
            } else if (this.isDrawingShootAction && this.arrow) {
                this.updateShootAction(pointer);
            } else if (this.isDrawingHandoff && this.arrow) { // Adicione esta linha
                this.updateHandoff(pointer); // Adicione esta linha
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
            } else if (this.isDrawingHandoff && this.arrow) { // Adicione esta linha
                this.finishDrawingHandoff(); // Adicione esta linha
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
            fabric.loadSVGFromString(wavyArrowSVG, (objects, options) => {
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
            fabric.loadSVGFromString(blockArrowSVG, (objects, options) => {
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
            fabric.loadSVGFromString(ShootActionSVG, (objects, options) => {
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
        updateHandoff(pointer) {
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
        finishDrawingHandoff() {
            this.arrow = null;
            this.isDrawingHandoff = false;
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

.overflow-y-auto {
    overflow-y: auto;
}
</style>
