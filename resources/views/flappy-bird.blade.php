<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>มาริโอ้บิน</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #5C94FC;
            font-family: 'Arial', sans-serif;
        }
        #gameCanvas {
            border: 4px solid #F83800;
            background: linear-gradient(to bottom, #5C94FC 0%, #5C94FC 70%, #00C700 70%, #00C700 100%);
        }
        #startScreen {
            position: absolute;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        #startButton {
            background: #F83800;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<canvas id="gameCanvas" width="320" height="480"></canvas>
<div id="startScreen">
    <h1>มาริโอ้บิน</h1>
    <p>กดเพื่อบิน หลบท่อให้ได้!</p>
    <button id="startButton">เริ่มเกม</button>
</div>

<script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const startScreen = document.getElementById('startScreen');
    const startButton = document.getElementById('startButton');

    let mario, pipes, score, gameLoop;
    const gravity = 0.5;
    const jump = -8;
    const pipeWidth = 50;
    const pipeGap = 150;

    class Mario {
        constructor() {
            this.x = 50;
            this.y = canvas.height / 2;
            this.velocity = 0;
            this.width = 30;
            this.height = 30;
        }

        draw() {
            ctx.fillStyle = 'red';
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }

        flap() {
            this.velocity = jump;
        }

        update() {
            this.velocity += gravity;
            this.y += this.velocity;

            if (this.y + this.height > canvas.height - 50) {
                this.y = canvas.height - this.height - 50;
                this.velocity = 0;
            }
        }
    }

    class Pipe {
        constructor() {
            this.x = canvas.width;
            this.topHeight = Math.random() * (canvas.height - pipeGap - 100) + 50;
            this.bottomY = this.topHeight + pipeGap;
        }

        draw() {
            ctx.fillStyle = 'green';
            ctx.fillRect(this.x, 0, pipeWidth, this.topHeight);
            ctx.fillRect(this.x, this.bottomY, pipeWidth, canvas.height - this.bottomY);
        }

        update() {
            this.x -= 2;
        }
    }

    function drawScore() {
        ctx.fillStyle = 'white';
        ctx.font = '24px Arial';
        ctx.fillText(`คะแนน: ${score}`, 10, 30);
    }

    function checkCollision() {
        for (let pipe of pipes) {
            if (mario.x + mario.width > pipe.x && mario.x < pipe.x + pipeWidth) {
                if (mario.y < pipe.topHeight || mario.y + mario.height > pipe.bottomY) {
                    return true;
                }
            }
        }
        return false;
    }

    function gameOver() {
        cancelAnimationFrame(gameLoop);
        ctx.fillStyle = 'rgba(0,0,0,0.7)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'white';
        ctx.font = '30px Arial';
        ctx.fillText('เกมจบ!', canvas.width / 2 - 50, canvas.height / 2 - 30);
        ctx.fillText(`คะแนน: ${score}`, canvas.width / 2 - 60, canvas.height / 2 + 10);
        startScreen.style.display = 'block';
    }

    function update() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        mario.update();
        mario.draw();

        if (pipes.length === 0 || pipes[pipes.length - 1].x < canvas.width - 200) {
            pipes.push(new Pipe());
        }

        for (let i = pipes.length - 1; i >= 0; i--) {
            pipes[i].update();
            pipes[i].draw();

            if (pipes[i].x + pipeWidth < 0) {
                pipes.splice(i, 1);
                score++;
            }
        }

        drawScore();

        if (checkCollision()) {
            gameOver();
            return;
        }

        gameLoop = requestAnimationFrame(update);
    }

    function startGame() {
        mario = new Mario();
        pipes = [];
        score = 0;
        startScreen.style.display = 'none';
        update();
    }

    canvas.addEventListener('click', () => mario.flap());
    startButton.addEventListener('click', startGame);
</script>
</body>
</html>
