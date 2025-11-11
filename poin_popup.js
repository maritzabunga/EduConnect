// point_popup.js
function showPointPopup(points) {
    if (!points || document.getElementById('point-popup')) return;

    const popup = document.createElement('div');
    popup.id = 'point-popup';
    popup.innerHTML = `
        <div style="
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.25);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 15px;
            min-width: 220px;
            animation: slideInRight 0.4s ease-out;
        ">
            <span style="
                background: white;
                color: #10b981;
                width: 36px; height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 16px;
            ">+${points}</span>
            <div>
                <div>Selamat!</div>
                <div style="font-size: 13px; opacity: 0.9;">Kamu mendapatkan ${points} poin belajar</div>
            </div>
        </div>
    `;

    popup.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: fadeOut 0.5s 4.6s forwards;
    `;

    document.body.appendChild(popup);
    setTimeout(() => popup.remove(), 5000);
}

// Tambahkan animasi
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeOut {
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);