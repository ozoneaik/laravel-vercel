<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกมเดาคำ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-full mx-4">
    <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">🧠 เกมเดาคำ 🎮</h1>
    <p id="word" class="text-3xl mb-6 text-center font-bold tracking-widest text-blue-600"></p>
    <div class="relative">
        <input type="text" id="guess" maxlength="1" class="w-full p-3 mb-4 border-2 border-gray-300 rounded-lg text-center text-xl focus:outline-none focus:border-blue-500 transition duration-300" placeholder="ใส่ตัวอักษร">
        <button onclick="checkGuess()" class="absolute right-2 top-2 bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
    <p id="message" class="mt-4 text-center text-lg font-semibold text-gray-700"></p>
    <p id="attempts" class="mt-2 text-center text-gray-600">จำนวนครั้งที่เดา: <span class="font-bold text-blue-600">0</span></p>
    <div class="mt-6 text-center">
        <button onclick="newGame()" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">เกมใหม่</button>
    </div>
</div>

<script>
    const words = ['สวัสดี', 'ไทย', 'กรุงเทพ', 'อาหาร', 'ทะเล', 'ภูเขา', 'แม่น้ำ', 'ดอกไม้', 'ผลไม้', 'รถไฟ'];
    let word, guessedWord, attempts;

    function newGame() {
        word = words[Math.floor(Math.random() * words.length)];
        guessedWord = Array(word.length).fill('_');
        attempts = 0;
        updateWord();
        document.getElementById('message').textContent = '';
        document.getElementById('attempts').innerHTML = 'จำนวนครั้งที่เดา: <span class="font-bold text-blue-600">0</span>';
        document.getElementById('guess').disabled = false;
        document.getElementById('guess').value = '';
        document.getElementById('guess').focus();
    }

    function updateWord() {
        document.getElementById('word').textContent = guessedWord.join(' ');
    }

    function checkGuess() {
        const guess = document.getElementById('guess').value.toLowerCase();
        document.getElementById('guess').value = '';

        if (guess.length !== 1) {
            document.getElementById('message').textContent = 'กรุณาใส่ตัวอักษรเพียงหนึ่งตัว';
            return;
        }

        attempts++;
        document.getElementById('attempts').innerHTML = `จำนวนครั้งที่เดา: <span class="font-bold text-blue-600">${attempts}</span>`;

        let correct = false;
        for (let i = 0; i < word.length; i++) {
            if (word[i] === guess) {
                guessedWord[i] = guess;
                correct = true;
            }
        }

        updateWord();

        if (correct) {
            document.getElementById('message').textContent = '🎉 ถูกต้อง!';
        } else {
            document.getElementById('message').textContent = '❌ ลองใหม่อีกครั้ง';
        }

        if (guessedWord.join('') === word) {
            document.getElementById('message').textContent = '🏆 ยินดีด้วย! คุณชนะแล้ว!';
            document.getElementById('guess').disabled = true;
        }
    }

    newGame();

    document.getElementById('guess').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            checkGuess();
        }
    });
</script>
</body>
</html>
