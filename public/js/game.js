// public/js/game.js - Client-side game logic

$(document).ready(function() {
    const canvas = document.getElementById('game-canvas');
    const ctx = canvas.getContext('2d');
    let timeLeft = 60; // Get this from server
    let score = 0;
    let clawPosition = { x: 400, y: 50 }; // Starting position
    let prizes = []; // We'll populate this from the server
    let gameState = 'ready'; // 'ready', 'moving', 'dropping', 'resetting'
    
    // Load game assets
    const clawImage = new Image();
    clawImage.src = 'images/claw.png';
    
    const prizeImages = {};
    
    const sounds = {
        move: new Audio('sounds/move.mp3'),
        drop: new Audio('sounds/drop.mp3'),
        win: new Audio('sounds/win.mp3'),
        lose: new Audio('sounds/lose.mp3')
    };

    function drawClaw() {
        ctx.drawImage(clawImage, clawPosition.x - 25, clawPosition.y - 25, 50, 50);
    }

    function drawPrizes() {
        prizes.forEach(prize => {
            if (prizeImages[prize.id]) {
                ctx.drawImage(prizeImages[prize.id], prize.x, prize.y, prize.width, prize.height);
            }
        });
    }

    function updateGame() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawPrizes();
        drawClaw();
        
        // Draw score
        ctx.fillStyle = 'black';
        ctx.font = '20px Arial';
        ctx.fillText(`Score: ${score}`, 10, 30);
    }

    // Initialize game
    function initGame() {
        // Fetch initial game state from server
        $.ajax({
            url: 'index.php',
            method: 'POST',
            data: { action: 'init' },
            dataType: 'json',
            success: function(response) {
                timeLeft = response.timeLimit;
                prizes = response.prizes;
                
                // Load prize images
                prizes.forEach(prize => {
                    prizeImages[prize.id] = new Image();
                    prizeImages[prize.id].src = prize.image;
                });
                
                updateGame();
                updateTimer();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching game state:", error);
                alert("An error occurred while initializing the game. Please try again.");
            }
        });
    }

    initGame();
});