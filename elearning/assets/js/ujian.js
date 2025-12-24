function generateSoalFields(count) {
    const container = document.getElementById('soal_container');
    container.innerHTML = ''; 

    for (let i = 1; i <= count; i++) {
        const dataIndex = i - 1; 
        const data = retainedSoalData[dataIndex] || {}; 
        
        // Gunakan fungsi untuk menggantikan karakter khusus
        const escapeHtml = (unsafe) => {
            if (!unsafe) return '';
            return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        };

        const pertanyaanVal = escapeHtml(data.pertanyaan);
        const opsiAVal = escapeHtml(data.opsi_a);
        const opsiBVal = escapeHtml(data.opsi_b);
        const opsiCVal = escapeHtml(data.opsi_c);
        const opsiDVal = escapeHtml(data.opsi_d);
        const kunciVal = (data.kunci_jawaban || '').toUpperCase();
        
        // Mengganti class untuk menerapkan glass-sub-card
        const soalHtml = `
            <div class="glass-sub-card p-4 shadow-md rounded-xl space-y-3" id="soal-${i}"> 
                <p class="font-extrabold mb-3 text-indigo-700 text-lg border-b border-indigo-200 pb-2">Soal #${i}</p>
                
                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Pertanyaan</label>
                    <textarea name="soal[${dataIndex}][pertanyaan]" required 
                            class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                            rows="2">${pertanyaanVal}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div class="col-span-1">
                        <label class="block text-gray-700 text-sm font-semibold mb-1">Kunci Jawaban</label>
                        <select name="soal[${dataIndex}][kunci_jawaban]" required 
                                class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Kunci</option>
                            <option value="A" ${kunciVal === 'A' ? 'selected' : ''}>A</option>
                            <option value="B" ${kunciVal === 'B' ? 'selected' : ''}>B</option>
                            <option value="C" ${kunciVal === 'C' ? 'selected' : ''}>C</option>
                            <option value="D" ${kunciVal === 'D' ? 'selected' : ''}>D</option>
                        </select>
                    </div>
                    
                    <div class="col-span-1 md:col-span-4 grid grid-cols-1 sm:grid-cols-2 gap-3"> 
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Opsi A</label>
                            <input type="text" name="soal[${dataIndex}][opsi_a]" value="${opsiAVal}" required 
                                class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Opsi B</label>
                            <input type="text" name="soal[${dataIndex}][opsi_b]" value="${opsiBVal}" required 
                                class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Opsi C</label>
                            <input type="text" name="soal[${dataIndex}][opsi_c]" value="${opsiCVal}" required 
                                class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Opsi D</label>
                            <input type="text" name="soal[${dataIndex}][opsi_d]" value="${opsiDVal}" required 
                                class="form-input text-sm border border-gray-300 rounded-lg shadow-sm p-3 w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', soalHtml);
    }
}

// FUNGSI VALIDASI JAWABAN SISWA
function validateJawaban(form) {
    const allQuestions = document.querySelectorAll('#ujian_form .soal-item');
    let emptyQuestion = null;
    let firstEmptyElement = null;

    allQuestions.forEach((question, index) => {
        const soalId = question.getAttribute('data-soal-id');
        
        // Hapus kelas error lama dan ring-4
        question.classList.remove('border-red-500', 'border-2', 'ring-4', 'ring-red-200');

        // Dapatkan semua radio button untuk soal ini
        const radios = question.querySelectorAll(`input[name="jawaban[${soalId}]"]`);
        // Cek apakah ada radio button yang terpilih
        let isAnswered = Array.from(radios).some(radio => radio.checked);

        if (!isAnswered) {
            if (!emptyQuestion) {
                emptyQuestion = { element: question, number: index + 1 };
                firstEmptyElement = question;
            }
        }
    });

    if (emptyQuestion) {
        alert(`Harap Jawab Semua Pertanyaan! Soal #${emptyQuestion.number} belum dijawab.`);
        
        // Tambahkan kelas error dan scroll ke elemen pertama yang kosong
        firstEmptyElement.classList.add('border-red-500', 'border-2', 'ring-4', 'ring-red-200', 'transition-all', 'duration-500');
        firstEmptyElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false; 
    }

    // Konfirmasi terakhir sebelum submit
    return confirm("Apakah Anda yakin ingin menyelesaikan dan mengumpulkan ujian ini? Jawaban tidak dapat diubah lagi.");
}

// Fungsi untuk mengontrol modal (Tidak Diubah)
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.modal-content').classList.remove('modal-enter');
        }, 10);
    }
}
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.querySelector('.modal-content').classList.add('modal-enter');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Sesuai durasi transisi
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const jumlahSoalSelect = document.getElementById('jumlah_soal');
    if (jumlahSoalSelect) {
        const countOption = jumlahSoalSelect.querySelector(`option[value="${initialSoalCount}"]`);
        if (countOption) {
            jumlahSoalSelect.value = initialSoalCount;
        }
        generateSoalFields(initialSoalCount);
        jumlahSoalSelect.addEventListener('change', function() {
            const selectedCount = parseInt(this.value);
            // Reset data form jika jumlah soal diubah
            retainedSoalData = [];
            generateSoalFields(selectedCount);
        });
    }

    const errorMsg = '<?php echo $error_msg; ?>';
    const soalErrorMatch = errorMsg.match(/Soal #(\d+)/);
    if (soalErrorMatch) {
        const soalNumber = soalErrorMatch[1];
        const soalElement = document.getElementById(`soal-${soalNumber}`);
        const modal = document.getElementById('modal-create');
        if (modal && modal.classList.contains('hidden')) {
            // Open Modal
            openModal('modal-create');
        }
        if (soalElement) {
            setTimeout(() => {
                soalElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                soalElement.classList.add('border-red-500', 'border-2', 'ring-4', 'ring-red-200', 'transition-all', 'duration-500');
            }, 350); // Tambah sedikit delay agar setelah modal terbuka
        }
    }

    // Tambahkan event listener untuk tombol "Buat Ujian Baru" jika ada
    const createButton = document.getElementById('open-create-modal');
    if(createButton) {
        createButton.addEventListener('click', () => openModal('modal-create'));
    }

    // Close modal saat mengklik di luar konten modal
    const modalCreate = document.getElementById('modal-create');
    if (modalCreate) {
        modalCreate.addEventListener('click', function(e) {
            if (e.target.id === 'modal-create') {
                closeModal('modal-create');
            }
        });
    }

    // Tambahkan fungsionalitas tombol Hapus dengan konfirmasi yang lebih baik (opsional)
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function(e) {
            const ujianTitle = this.getAttribute('data-ujian-title');
            if (!confirm(`Apakah Anda yakin ingin menghapus ujian '${ujianTitle}'? Semua soal dan hasil akan HILANG PERMANEN!`)) {
                e.preventDefault();
            }
        });
    });
});