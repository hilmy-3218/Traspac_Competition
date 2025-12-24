// JS untuk menangani Modal Konfirmasi Hapus
function showModal(tugasId) {
    document.getElementById('tugasIdToDelete').value = tugasId;
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('modalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex', 'opacity-100');
    
    // Simple animation: show content
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('modalContent');

    // Simple animation: hide content
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    modal.classList.remove('opacity-100');
    
    // Wait for animation to finish (300ms) before truly hiding the modal container
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

// Close modal on outside click
document.getElementById('deleteModal').addEventListener('click', (e) => {
    if (e.target.id === 'deleteModal') {
        closeModal();
    }
});

// JS untuk menangani Toggle Form Tugas (Khusus Guru)
function toggleTaskForm() {
    const form = document.getElementById('taskFormContainer');
    const icon = document.getElementById('toggleIcon');
    
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        // Ganti ikon dari + menjadi X (Close)
        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>`;
    } else {
        form.classList.add('hidden');
        // Ganti ikon dari X menjadi + (Open)
        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>`;
    }
}

// JS untuk menangani Collapsible Submissions (Guru)
function toggleSubmissions(button, targetId) {
    const targetDiv = document.getElementById(targetId);
    const arrow = document.getElementById('arrow-' + targetId.split('-')[1]);

    if (targetDiv.classList.contains('hidden')) {
        // Show
        targetDiv.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        // Hide
        targetDiv.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}