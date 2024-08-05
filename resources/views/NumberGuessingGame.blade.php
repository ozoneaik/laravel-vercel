<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกมส์ทายเลข</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-600 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white bg-opacity-90 rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-yellow-400 p-6 text-center">
                <h1 class="text-4xl font-bold text-purple-800 mb-2">🔢 เกมส์ทายเลข 🎲</h1>
                <p class="text-lg text-purple-700">ลองทายตัวเลขลับระหว่าง 1 ถึง 100</p>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <input type="number" id="guessInput" class="w-full p-3 text-2xl text-center bg-purple-100 border-2 border-purple-300 rounded-lg focus:outline-none focus:border-purple-500" placeholder="ใส่ตัวเลขที่คุณทาย">
                </div>
                <button id="guessButton" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-lg text-xl transition duration-300 ease-in-out transform hover:scale-105">
                    🔍 ทาย!
                </button>
                <p id="message" class="text-xl font-bold text-center mt-6 min-h-[2em]"></p>
                <p id="attempts" class="text-md text-center mt-2 text-gray-600"></p>
            </div>

            <div class="bg-gray-100 p-4 text-center">
                <button id="newGameButton" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full text-lg transition duration-300 ease-in-out transform hover:scale-105">
                    🔄 เริ่มเกมใหม่
                </button>
            </div>
        </div>

        <div id="fireworks" class="fixed top-0 left-0 w-full h-full pointer-events-none hidden"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script>
        let targetNumber;
        let attempts = 0;

        const guessInput = document.getElementById('guessInput');
        const guessButton = document.getElementById('guessButton');
        const message = document.getElementById('message');
        const attemptsDisplay = document.getElementById('attempts');
        const newGameButton = document.getElementById('newGameButton');

        function startNewGame() {
            targetNumber = Math.floor(Math.random() * 100) + 1;
            attempts = 0;
            message.textContent = '';
            attemptsDisplay.textContent = '';
            guessInput.value = '';
            guessInput.disabled = false;
            guessButton.disabled = false;
        }

        function checkGuess() {
            const userGuess = parseInt(guessInput.value);
            attempts++;

            if (isNaN(userGuess) || userGuess < 1 || userGuess > 100) {
                message.textContent = '❌ กรุณาใส่ตัวเลขระหว่าง 1 ถึง 100';
                message.className = 'text-xl font-bold text-center mt-6 text-red-500';
            } else if (userGuess === targetNumber) {
                message.textContent = `🎉 ยินดีด้วย! คุณทายถูก ตัวเลขคือ ${targetNumber}`;
                message.className = 'text-xl font-bold text-center mt-6 text-green-500';
                guessInput.disabled = true;
                guessButton.disabled = true;
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            } else if (userGuess < targetNumber) {
                message.textContent = '👆 น้อยเกินไป ลองใหม่อีกครั้ง';
                message.className = 'text-xl font-bold text-center mt-6 text-blue-500';
            } else {
                message.textContent = '👇 มากเกินไป ลองใหม่อีกครั้ง';
                message.className = 'text-xl font-bold text-center mt-6 text-blue-500';
            }

            attemptsDisplay.textContent = `🔄 จำนวนครั้งที่ทาย: ${attempts}`;
        }

        guessButton.addEventListener('click', checkGuess);
        newGameButton.addEventListener('click', startNewGame);
        guessInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                checkGuess();
            }
        });

        startNewGame();
    </script>
</body>
</html>