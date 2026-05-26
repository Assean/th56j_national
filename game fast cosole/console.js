// ============================================
// 第56屆全國技能競賽 - 遊戲快速通關工具
// ============================================

(function() {
    'use strict';
    
    // 檢測當前遊戲
    const gameTitle = document.title || document.querySelector('h1')?.textContent || '';
    
    const GAMES = {
        '數字挑戰': 'number-challenge',
        '記憶挑戰': 'memory-challenge',
        '反應力測試': 'reaction-test',
        '打地鼠': 'whack-a-mole',
        '滑動拼圖': 'slide-puzzle'
    };
    
    let currentGame = null;
    for (let [name, id] of Object.entries(GAMES)) {
        if (gameTitle.includes(name)) {
            currentGame = { name, id };
            break;
        }
    }
    
    if (!currentGame) {
        alert('❌ 無法辨識遊戲！請確認在正確的遊戲頁面執行此腳本。');
        return;
    }
    
    // 創建控制面板
    const panel = document.createElement('div');
    panel.id = 'auto-complete-panel';
    panel.innerHTML = `
        <div class="panel-header">
            <div class="panel-title">
                <span class="icon">🎮</span>
                <span>快速通關工具</span>
            </div>
            <button class="close-btn" id="close-panel">✕</button>
        </div>
        <div class="panel-body">
            <div class="game-info">
                <div class="game-label">當前遊戲</div>
                <div class="game-name">${currentGame.name}</div>
            </div>
            <div class="mode-section">
                <div class="section-title">選擇模式</div>
                <div class="mode-buttons" id="mode-buttons">
                    <!-- 動態生成 -->
                </div>
            </div>
            <div class="status-section">
                <div class="status-label">狀態</div>
                <div class="status-text" id="status-text">等待開始...</div>
            </div>
        </div>
    `;
    
    // 添加樣式
    const style = document.createElement('style');
    style.textContent = `
        #auto-complete-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 380px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            z-index: 999999;
            font-family: 'Segoe UI', Arial, sans-serif;
            overflow: hidden;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }
        
        .panel-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .panel-title .icon {
            font-size: 24px;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }
        
        .panel-body {
            padding: 24px;
            background: white;
        }
        
        .game-info {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .game-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        
        .game-name {
            color: white;
            font-size: 22px;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .mode-section {
            margin-bottom: 20px;
        }
        
        .section-title {
            color: #333;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .mode-buttons {
            display: grid;
            gap: 10px;
        }
        
        .mode-btn {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .mode-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }
        
        .mode-btn:active {
            transform: translateY(0);
        }
        
        .mode-btn.win {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
        }
        
        .mode-btn.win:hover {
            box-shadow: 0 6px 20px rgba(67, 233, 123, 0.4);
        }
        
        .mode-btn.lose {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
        }
        
        .mode-btn.lose:hover {
            box-shadow: 0 6px 20px rgba(250, 112, 154, 0.4);
        }
        
        .mode-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .mode-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .status-section {
            background: #f7fafc;
            padding: 16px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
        }
        
        .status-label {
            color: #718096;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .status-text {
            color: #2d3748;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.6;
        }
        
        .status-text.running {
            color: #4299e1;
            animation: pulse 1.5s infinite;
        }
        
        .status-text.success {
            color: #48bb78;
        }
        
        .status-text.error {
            color: #f56565;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
    `;
    
    document.head.appendChild(style);
    document.body.appendChild(panel);
    
    const statusText = document.getElementById('status-text');
    const modeButtons = document.getElementById('mode-buttons');
    
    // 更新狀態
    function updateStatus(message, type = 'normal') {
        statusText.textContent = message;
        statusText.className = 'status-text ' + type;
    }
    
    // 隨機延遲（模擬真人）
    function randomDelay(min, max) {
        return new Promise(resolve => {
            const delay = min + Math.random() * (max - min);
            setTimeout(resolve, delay);
        });
    }
    
    // 模擬點擊
    function simulateClick(element) {
        const event = new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        });
        element.dispatchEvent(event);
    }
    
    // ==================== 遊戲自動化邏輯 ====================
    
    // 1. 數字挑戰 / 記憶挑戰
    async function autoNumberChallenge(shouldWin) {
        updateStatus('正在分析數字...', 'running');
        await randomDelay(800, 1500);
        
        const numbers = Array.from(document.querySelectorAll('.number'))
            .map(el => ({
                element: el,
                value: parseInt(el.textContent)
            }));
        
        if (shouldWin) {
            // 按升序點擊
            const sorted = [...numbers].sort((a, b) => a.value - b.value);
            updateStatus(`開始按順序點擊：${sorted.map(n => n.value).join(' → ')}`, 'running');
            
            for (let i = 0; i < sorted.length; i++) {
                await randomDelay(300, 800);
                updateStatus(`點擊第 ${i + 1} 個數字：${sorted[i].value}`, 'running');
                simulateClick(sorted[i].element);
            }
            
            updateStatus('✅ 挑戰成功！', 'success');
        } else {
            // 故意點錯順序
            updateStatus('故意點擊錯誤順序...', 'running');
            await randomDelay(300, 600);
            
            // 隨機點擊（不按順序）
            const shuffled = [...numbers].sort(() => Math.random() - 0.5);
            simulateClick(shuffled[0].element);
            await randomDelay(200, 400);
            simulateClick(shuffled[1].element);
            
            updateStatus('❌ 挑戰失敗！', 'error');
        }
    }
    
    // 2. 反應力測試
    async function autoReactionTest(shouldWin) {
        updateStatus('等待遊戲開始...', 'running');
        
        // 點擊開始按鈕
        const startBtn = document.getElementById('btn-start');
        if (startBtn && !startBtn.disabled) {
            simulateClick(startBtn);
            await randomDelay(1000, 1500);
        }
        
        const arena = document.getElementById('arena');
        let roundCount = 0;
        const maxRounds = 5;
        
        const observer = new MutationObserver(async (mutations) => {
            for (let mutation of mutations) {
                if (mutation.attributeName === 'class') {
                    const classList = arena.classList;
                    
                    if (classList.contains('go') && shouldWin) {
                        // 變綠了，快速點擊（模擬真人反應時間）
                        roundCount++;
                        updateStatus(`第 ${roundCount} 回合：反應中...`, 'running');
                        await randomDelay(150, 300);
                        simulateClick(arena);
                    } else if (classList.contains('ready') && !shouldWin) {
                        // 故意太早點擊
                        roundCount++;
                        updateStatus(`第 ${roundCount} 回合：故意太早點擊`, 'running');
                        await randomDelay(200, 400);
                        simulateClick(arena);
                    }
                    
                    if (classList.contains('done')) {
                        observer.disconnect();
                        if (shouldWin) {
                            updateStatus('✅ 測試完成！', 'success');
                        } else {
                            updateStatus('❌ 所有回合失敗！', 'error');
                        }
                    }
                }
            }
        });
        
        observer.observe(arena, { attributes: true });
    }
    
    // 3. 打地鼠
    async function autoWhackAMole() {
        updateStatus('準備打地鼠...', 'running');
        
        // 點擊開始按鈕
        const startBtn = document.getElementById('btn-start');
        if (startBtn && !startBtn.disabled) {
            simulateClick(startBtn);
            await randomDelay(500, 800);
        }
        
        updateStatus('正在打地鼠...', 'running');
        
        // 持續監控並點擊出現的地鼠
        const checkMoles = setInterval(() => {
            const moles = document.querySelectorAll('.mole.up');
            moles.forEach(async mole => {
                if (!mole.classList.contains('whacked')) {
                    // 模擬真人反應時間
                    await randomDelay(100, 250);
                    simulateClick(mole);
                }
            });
            
            // 檢查遊戲是否結束
            const overlay = document.getElementById('overlay');
            if (overlay && overlay.classList.contains('show')) {
                clearInterval(checkMoles);
                const score = document.getElementById('score-val').textContent;
                updateStatus(`✅ 遊戲結束！得分：${score}`, 'success');
            }
        }, 80);
    }
    
    // 4. 滑動拼圖
    async function autoSlidePuzzle() {
        updateStatus('準備解拼圖...', 'running');
        
        // 點擊開始按鈕
        const startBtn = document.getElementById('btn-start');
        if (startBtn) {
            simulateClick(startBtn);
            await randomDelay(1000, 1500);
        }
        
        updateStatus('正在自動解拼圖...', 'running');
        
        // 簡單的解法：持續點擊可移動的磚塊
        let moveCount = 0;
        const maxMoves = 200; // 防止無限循環
        
        const solvePuzzle = async () => {
            while (moveCount < maxMoves) {
                const movableTiles = document.querySelectorAll('.tile.movable');
                
                if (movableTiles.length === 0) {
                    // 遊戲完成
                    break;
                }
                
                // 隨機選擇一個可移動的磚塊
                const randomTile = movableTiles[Math.floor(Math.random() * movableTiles.length)];
                
                await randomDelay(200, 500);
                simulateClick(randomTile);
                moveCount++;
                
                updateStatus(`正在解拼圖... (${moveCount} 步)`, 'running');
                
                // 檢查是否完成
                await randomDelay(100, 200);
                const overlay = document.getElementById('overlay');
                if (overlay && overlay.classList.contains('show')) {
                    updateStatus('✅ 拼圖完成！', 'success');
                    return;
                }
            }
        };
        
        await solvePuzzle();
    }
    
    // ==================== 按鈕生成 ====================
    
    function generateButtons() {
        modeButtons.innerHTML = '';
        
        switch (currentGame.id) {
            case 'number-challenge':
            case 'memory-challenge':
                modeButtons.innerHTML = `
                    <button class="mode-btn win" data-mode="win">
                        <span style="position: relative; z-index: 1;">✅ 通關模式（贏）</span>
                    </button>
                    <button class="mode-btn lose" data-mode="lose">
                        <span style="position: relative; z-index: 1;">❌ 失敗模式（輸）</span>
                    </button>
                `;
                break;
                
            case 'reaction-test':
                modeButtons.innerHTML = `
                    <button class="mode-btn win" data-mode="win">
                        <span style="position: relative; z-index: 1;">✅ 完成測試（贏）</span>
                    </button>
                    <button class="mode-btn lose" data-mode="lose">
                        <span style="position: relative; z-index: 1;">❌ 全部失敗（輸）</span>
                    </button>
                `;
                break;
                
            case 'whack-a-mole':
                modeButtons.innerHTML = `
                    <button class="mode-btn win" data-mode="win">
                        <span style="position: relative; z-index: 1;">🎯 自動打地鼠</span>
                    </button>
                `;
                break;
                
            case 'slide-puzzle':
                modeButtons.innerHTML = `
                    <button class="mode-btn win" data-mode="win">
                        <span style="position: relative; z-index: 1;">🧩 自動解拼圖</span>
                    </button>
                `;
                break;
        }
        
        // 綁定事件
        document.querySelectorAll('.mode-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const mode = btn.dataset.mode;
                const shouldWin = mode === 'win';
                
                // 禁用所有按鈕
                document.querySelectorAll('.mode-btn').forEach(b => b.disabled = true);
                
                try {
                    switch (currentGame.id) {
                        case 'number-challenge':
                        case 'memory-challenge':
                            await autoNumberChallenge(shouldWin);
                            break;
                        case 'reaction-test':
                            await autoReactionTest(shouldWin);
                            break;
                        case 'whack-a-mole':
                            await autoWhackAMole();
                            break;
                        case 'slide-puzzle':
                            await autoSlidePuzzle();
                            break;
                    }
                } catch (error) {
                    updateStatus('❌ 發生錯誤：' + error.message, 'error');
                    console.error(error);
                }
                
                // 重新啟用按鈕
                setTimeout(() => {
                    document.querySelectorAll('.mode-btn').forEach(b => b.disabled = false);
                }, 2000);
            });
        });
    }
    
    generateButtons();
    
    // 關閉按鈕
    document.getElementById('close-panel').addEventListener('click', () => {
        panel.remove();
        style.remove();
    });
    
    console.log('%c🎮 快速通關工具已啟動！', 'color: #667eea; font-size: 20px; font-weight: bold;');
    console.log('%c當前遊戲：' + currentGame.name, 'color: #4facfe; font-size: 16px;');
    
})();