const ACHIEVEMENTS = {
    API: { id: 'achievement-api', icon: 'fa-fire', color: 'text-orange-600' },
    BOOK: { id: 'achievement-book', icon: 'fa-book', color: 'text-orange-500' },
    CAP: { id: 'achievement-cap', icon: 'fa-graduation-cap', color: 'text-blue-500' },
    TROPHY: { id: 'achievement-trophy', icon: 'fa-trophy', color: 'text-yellow-500' },
    KING: { id: 'achievement-king', icon: 'fa-crown', color: 'text-amber-500' }
};

// 2. Fungsi Filter & Keamanan Input
function sanitizeScore(value) {
    // Hapus karakter non-angka
    let num = parseInt(value.toString().replace(/[^0-9]/g, ''));
    if (isNaN(num) || num < 0) return 0;
    if (num > 100) return 100; // Batasi maksimal 100
    return num;
}

// 3. Render Input Materi
function renderMaterialInputs() {
    const container = document.getElementById('materi-inputs');
    container.innerHTML = '';
    progressData.materi.forEach(materi => {
        const div = document.createElement('div');
        div.className = `flex items-center justify-between p-4 rounded-xl border transition-all ${materi.completed ? 'bg-white border-blue-100' : 'bg-slate-50/50 border-slate-100'}`;
        div.innerHTML = `
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" data-id="${materi.id}" data-type="completed" ${materi.completed ? 'checked' : ''} class="w-6 h-6 rounded-lg accent-blue-600">
                <span class="text-sm font-bold ${materi.completed ? 'text-slate-800' : 'text-slate-400'}">Materi ${materi.id}</span>
            </label>
            <input type="number" data-id="${materi.id}" data-type="score" min="0" max="100" value="${materi.score}" 
                    class="w-20 p-2 text-center font-bold border rounded-lg ${!materi.completed ? 'opacity-30' : 'text-blue-600 bg-blue-50'} shadow-sm" 
                    ${!materi.completed ? 'disabled' : ''}>
        `;
        container.appendChild(div);
    });
}

// 4. Update Logika Visual
function updateProgress() {
    const completed = progressData.materi.filter(m => m.completed);
    const allCompleted = progressData.materi.every(m => m.completed);
    const avg = completed.length > 0 ? completed.reduce((s, m) => s + m.score, 0) / completed.length : 0;
    const exam = progressData.examScore;

    const res = {
        api: completed.length >= 3 && avg >= 78,
        book: allCompleted,
        cap: allCompleted && avg >= 80,
        trophy: allCompleted && avg >= 80 && exam >= 85,
        king: allCompleted && avg >= 90 && exam >= 90
    };

    let count = 0;
    Object.keys(ACHIEVEMENTS).forEach(key => {
        const config = ACHIEVEMENTS[key];
        const isUnlocked = res[key.toLowerCase()];
        const card = document.getElementById(config.id);
        if (isUnlocked) {
            count++;
            card.className = `achievement-card p-6 rounded-2xl text-center unlocked bg-white`;
            card.querySelector('i').className = `fas ${config.icon} text-3xl ${config.color} mb-3`;
        } else {
            card.className = `achievement-card p-6 rounded-2xl text-center bg-white/50`;
            card.querySelector('i').className = `fas ${config.icon} text-3xl text-slate-400 mb-3`;
        }
    });

    document.getElementById('badge-count').textContent = `${count}/5 TERBUKA`;
    document.getElementById('avg-score-display').textContent = avg.toFixed(1) + '%';
    document.getElementById('avg-progress-bar').style.width = Math.min(avg, 100) + '%';
}

// 5. Event Listeners dengan Validasi Ketat
document.getElementById('materi-inputs').addEventListener('input', (e) => {
    const id = parseInt(e.target.dataset.id);
    const type = e.target.dataset.type;
    const idx = progressData.materi.findIndex(m => m.id === id);

    if (type === 'completed') {
        progressData.materi[idx].completed = e.target.checked;
        renderMaterialInputs(); 
    } else if (type === 'score') {
        const safeVal = sanitizeScore(e.target.value);
        e.target.value = safeVal; // Paksa input user berubah jika > 100
        progressData.materi[idx].score = safeVal;
    }
    updateProgress();
});

document.getElementById('exam-score-input').addEventListener('input', (e) => {
    const safeVal = sanitizeScore(e.target.value);
    e.target.value = safeVal;
    progressData.examScore = safeVal;
    updateProgress();
});

document.getElementById('auto-fill').onclick = () => {
    progressData.materi.forEach(m => { m.completed = true; m.score = 100; });
    progressData.examScore = 100;
    document.getElementById('exam-score-input').value = 100;
    renderMaterialInputs();
    updateProgress();
};

// Initialize
renderMaterialInputs();
updateProgress();