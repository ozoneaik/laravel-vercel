<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกมจับคู่การ์ด</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card {
            perspective: 1000px;
            transform-style: preserve-3d;
            transition: transform 0.5s;
        }
        .card.flipped {
            transform: rotateY(180deg);
        }
        .card-front, .card-back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .card-back {
            transform: rotateY(180deg);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-purple-500 to-pink-500 min-h-screen flex items-center justify-center">
<div class="text-center">
    <h1 class="text-4xl font-bold text-white mb-4">เกมจับคู่การ์ด</h1>
    <div id="game-board" class="grid grid-cols-4 gap-4 mb-4"></div>
    <div id="stats" class="text-white text-xl mb-4">
        การเปิด: <span id="flips">0</span> | คู่ที่จับได้: <span id="matches">0</span>
    </div>
    <button id="reset-btn" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
        เริ่มเกมใหม่
    </button>
</div>

<script>
    const emojis = ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼'];
    let cards = [...emojis, ...emojis];
    let flippedCards = [];
    let matchedPairs = 0;
    let flips = 0;

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    function createCard(emoji, index) {
        const card = document.createElement('div');
        card.className = 'card w-20 h-20 bg-white rounded-lg cursor-pointer';
        card.innerHTML = `
                <div class="card-front flex items-center justify-center text-4xl">❓</div>
                <div class="card-back flex items-center justify-center text-4xl">${emoji}</div>
            `;
        card.dataset.index = index;
        card.addEventListener('click', flipCard);
        return card;
    }

    function flipCard() {
        if (flippedCards.length === 2) return;
        if (this.classList.contains('flipped')) return;

        this.classList.add('flipped');
        flippedCards.push(this);
        flips++;
        updateStats();

        if (flippedCards.length === 2) {
            setTimeout(checkMatch, 500);
        }
    }

    function checkMatch() {
        const [card1, card2] = flippedCards;
        const isMatch = card1.querySelector('.card-back').textContent === card2.querySelector('.card-back').textContent;

        if (isMatch) {
            card1.removeEventListener('click', flipCard);
            card2.removeEventListener('click', flipCard);
            matchedPairs++;
            updateStats();
            if (matchedPairs === emojis.length) {
                setTimeout(() => alert('ยินดีด้วย! คุณชนะแล้ว!'), 500);
            }
        } else {
            setTimeout(() => {
                card1.classList.remove('flipped');
                card2.classList.remove('flipped');
            }, 500);
        }

        flippedCards = [];
    }

    function updateStats() {
        document.getElementById('flips').textContent = flips;
        document.getElementById('matches').textContent = matchedPairs;
    }

    function initializeGame() {
        const gameBoard = document.getElementById('game-board');
        gameBoard.innerHTML = '';
        shuffleArray(cards);
        cards.forEach((emoji, index) => {
            gameBoard.appendChild(createCard(emoji, index));
        });
        flips = 0;
        matchedPairs = 0;
        updateStats();
    }

    document.getElementById('reset-btn').addEventListener('click', initializeGame);

    initializeGame();
</script>
</body>
</html>
