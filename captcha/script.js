const dropZoneContainer = document.querySelector('#dropzones');

/* Build a playable game on startup */
rebuild();

/* facade of build() */
function rebuild() {
	const imgList = ['captcha_logo'];
	/*aléatoire*/
    const img = imgList[Math.floor(Math.random() * imgList.length)];
	/*découpage en 3 par 3 les images */
	build(dropZoneContainer, 3, 3, "./captcha" + img + ".jpg");
}

/* création ligne, colonne etc..*/
function build(container, rows, cols, imageSource) {
	container.innerHTML = '';
	/**/
	const image = new Image();
	image.addEventListener('load', e => {
		initialDropZoneContainer(container, rows, cols, e.target);
	});
	image.addEventListener('error', e => {
		rebuild();
	});
	image.src = imageSource;
}

/* Drag Drop Event handlers */
/*mouvement avec la souris*/
function onDragStart(e) {
	e.dataTransfer.setData('text/elm-id', e.currentTarget.id);
	// DO NOT use "text/plain" channel, FF will treat it as url and page is redirected.
	e.currentTarget.classList.add('dragging');
}

function onDragOver(e) {
	e.preventDefault();
}

function onDrop(e) {
	if (isSolved(dropZoneContainer)) {
		console.log('solved');
	}
	//alterne deux cases 
	const elementIdAttribute = e.dataTransfer.getData('text/elm-id');
	const elementA = document.getElementById(elementIdAttribute);
	const elementB = e.currentTarget.querySelector('.puzzle');
	swapPuzzleElements(elementA, elementB);
	elementA.classList.remove('dragging');
	if (isSolved(dropZoneContainer)) {
		onSolved();
	}
}

/* interesting moments */
function onSolved() {
	// TODO Validation du captcha
	dropZoneContainer.style.animation = null;
	dropZoneContainer.offsetHeight;
	dropZoneContainer.style.animation = 'solved 1s forwards';
	//setTimeout(() => {
		//alert('Captcha solved !');
	//}, 1500);
}

/*
Setup drop zone container
1- deploy container element
2- create drop zone elements and append to container
3- create puzzle elements and append drop zone elements
4- shuffle puzzle elements
*/
function initialDropZoneContainer(container, rows, cols, image) {
	// 1 (container grid layout)
	container.style.gridTemplateRows = `repeat(${rows}, 1fr)`;
	container.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;

	// 1 (container dimensions)
	if (image.width > image.height) {
		const containerWidth = Number.parseFloat(
			getComputedStyle(container).width,
			10,
		);
		const containerHeight = (containerWidth * image.height) / image.width;
		container.style.height = `${containerHeight}px`;
	} else {
		const containerHeight = Number.parseFloat(
			getComputedStyle(container).height,
			10,
		);
		const containerWidth = (containerHeight * image.width) / image.height;
		container.style.width = `${containerWidth}px`;
	}

	// 2
	const dropZoneElements = createDropZoneElements(rows * cols);
	for (const el of dropZoneElements) container.appendChild(el);

	// 3
	const puzzleElements = createPuzzleElements(rows, cols, image);
	for (const [i, el] of puzzleElements.entries())
		dropZoneElements[i].appendChild(el);

	// 4
	shufflePuzzleElements(container);
}

/* 
Create array of puzzle elms 
*/
function createPuzzleElements(rows, cols, image) {
	const elements = [];
	for (let y = 0; y < rows; ++y) {
		for (let x = 0; x < cols; ++x) {
			const el = document.createElement('div');
			const i = cols * y + x;
			el.draggable = true;
			el.addEventListener('dragstart', onDragStart);
			el.id = `puzzle-${i}`;
			el.dataset.puzzleId = i;
			el.classList.add('puzzle');
			//el.textContent = i; // debug only
			el.style.backgroundImage = `url(${image.src})`;
			el.style.backgroundSize = `${cols * 100}% ${rows * 100}%`;
			el.style.backgroundPosition = `${(x / (cols - 1)) * 100}% ${
				(y / (rows - 1)) * 100
			}%`;
			elements.push(el);
		}
	}
	return elements;
}

/* 
Create array of dropzone elms 
*/
function createDropZoneElements(n) {
	const elements = [];
	for (let i = 0; i < n; ++i) {
		const el = document.createElement('div');
		el.addEventListener('dragover', onDragOver);
		el.addEventListener('drop', onDrop);
		el.dataset.dropZoneId = i;
		el.classList.add('dropzone');
		//el.textContent = i; // debug only
		elements.push(el);
	}
	return elements;
}

/*
Shuffle puzzles --> position des pièces 
*/
function shufflePuzzleElements(container) {
	const puzzleElements = container.querySelectorAll('.puzzle');
	for (let i = puzzleElements.length; i > 0; --i) {
		const index = Math.floor(Math.random() * i);
		swapPuzzleElements(puzzleElements[index], puzzleElements[i - 1]);
	}
}

/*
Is solved? --> vérification à chaque bloc déplacé
*/
function isSolved(container) {
	const dropzoneElements = container.querySelectorAll('.dropzone');
	for (const [i, el] of dropzoneElements.entries()) {
		const puzzleElement = el.querySelector('.puzzle');
		if (Number(puzzleElement.dataset.puzzleId) !== i) return false;
	}
	return true;
}

/* 
Swap puzzle elements
*/
function swapPuzzleElements(elementA, elementB) {
	const containerA = elementA.parentNode;
	const containerB = elementB.parentNode;

	containerB.appendChild(elementA);
	containerA.appendChild(elementB);
}
