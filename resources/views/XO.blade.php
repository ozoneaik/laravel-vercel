<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XO Neon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        neon: {
                            pink: '#f0f',
                            blue: '#0ff',
                        }
                    },
                    boxShadow: {
                        neon: '0 0 20px rgba(255, 0, 255, 0.5)',
                        'neon-hover': '0 0 15px #0ff',
                    },
                    textShadow: {
                        neon: '0 0 10px #fff',
                    },
                },
            },
        }
    </script>
    <style>
        @layer utilities {
            .text-shadow-neon {
                text-shadow: 0 0 10px #fff;
            }
        }
    </style>
</head>
<body class="bg-black text-white flex justify-center items-center h-screen m-0 flex-col font-sans">
<div class="text-center">
    <div class="mb-4">
        <input type="number" id="boardSize" min="3" value="3" placeholder="ขนาดกระดาน"
               class="bg-gray-800 text-white border-2 border-neon-blue p-2 m-2 rounded">
        <button onclick="initializeGame()"
                class="bg-gray-800 text-white border-2 border-neon-blue p-2 m-2 rounded hover:bg-neon-blue hover:text-black transition duration-300">
            เริ่มเกมใหม่
        </button>
    </div>
    <div id="board" class="inline-grid gap-2 bg-gray-900 p-5 rounded-lg shadow-neon"></div>
    <div id="message" class="text-2xl mt-4 text-shadow-neon"></div>
</div>

<audio id="winSound" src="https://assets.mixkit.co/sfx/preview/mixkit-winning-chimes-2015.mp3"></audio>

<script>
    let currentPlayer = 'X';
    let gameBoard = [];
    let gameActive = true;
    let boardSize = 3;

    function initializeGame() {
        boardSize = parseInt(document.getElementById('boardSize').value) || 3;
        if (boardSize < 3) boardSize = 3;
        gameBoard = Array(boardSize).fill().map(() => Array(boardSize).fill(''));
        gameActive = true;
        currentPlayer = 'X';
        document.getElementById('message').textContent = '';
        renderBoard();
    }

    function renderBoard() {
        const board = document.getElementById('board');
        board.innerHTML = '';
        board.style.gridTemplateColumns = `repeat(${boardSize}, minmax(0, 1fr))`;

        for (let i = 0; i < boardSize; i++) {
            for (let j = 0; j < boardSize; j++) {
                const cell = document.createElement('div');
                cell.classList.add('w-20', 'h-20', 'bg-black', 'border-2', 'border-neon-blue', 'rounded', 'flex', 'justify-center', 'items-center', 'text-4xl', 'cursor-pointer', 'transition', 'duration-300', 'hover:bg-gray-800', 'hover:shadow-neon-hover');
                cell.addEventListener('click', () => handleCellClick(i, j));
                board.appendChild(cell);
            }
        }
    }

    function handleCellClick(row, col) {
        if (!gameActive || gameBoard[row][col] !== '') return;

        gameBoard[row][col] = currentPlayer;
        updateBoard();
        checkWinner();

        currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
    }

    function checkWinner() {
        // Check rows and columns
        for (let i = 0; i < boardSize; i++) {
            if (checkLine(gameBoard[i]) || checkLine(gameBoard.map(row => row[i]))) {
                endGame(true);
                return;
            }
        }

        // Check diagonals
        if (checkLine(gameBoard.map((row, i) => row[i])) ||
            checkLine(gameBoard.map((row, i) => row[boardSize - 1 - i]))) {
            endGame(true);
            return;
        }

        // Check for draw
        if (gameBoard.every(row => row.every(cell => cell !== ''))) {
            endGame(false);
        }
    }

    function checkLine(line) {
        return line.every(cell => cell === currentPlayer);
    }

    function endGame(isWin) {
        gameActive = false;
        if (isWin) {
            document.getElementById('message').textContent = `ผู้เล่น ${currentPlayer} ชนะ!`;
            document.getElementById('winSound').play();
        } else {
            document.getElementById('message').textContent = 'เสมอ!';
        }
    }

    function updateBoard() {
        const cells = document.querySelectorAll('#board > div');
        cells.forEach((cell, index) => {
            const row = Math.floor(index / boardSize);
            const col = index % boardSize;
            cell.textContent = gameBoard[row][col];
            cell.classList.remove('text-neon-pink', 'text-neon-blue');
            if (gameBoard[row][col] === 'X') cell.classList.add('text-neon-pink');
            if (gameBoard[row][col] === 'O') cell.classList.add('text-neon-blue');
        });
    }

    initializeGame();
</script>
</body>
</html>
