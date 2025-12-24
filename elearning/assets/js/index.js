        // Mengganti alert() dengan fungsi kustom karena batasan iframe
        window.alert = function(message) {
            // Menggunakan modal kustom sederhana untuk pesan
            const modal = document.getElementById('course-modal');
            const title = document.getElementById('modal-title');
            const body = document.getElementById('modal-body');
            
            // Simpan konten asli sebelum menimpa
            const originalTitle = title.textContent;
            const originalBody = body.innerHTML;
            const originalButtonDisplay = modal.querySelector('button.w-full').style.display;

            title.textContent = "Pemberitahuan";
            body.innerHTML = `<p class="text-center text-lg">${message}</p>`;
            
            // Sembunyikan tombol 'Daftar Sekarang'
            modal.querySelector('button.w-full').style.display = 'none';

            modal.classList.remove('hidden');
            document.getElementById('modal-content-box').classList.add('is-open');

            // Override fungsi close untuk mengembalikan konten asli
            modal.setAttribute('onclick', `closeCourseModal(event, true, '${originalTitle}', '${originalBody.replace(/'/g, "\\'")}', '${originalButtonDisplay}')`); 
        };
        
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('menu-button');
        const messageStatus = document.getElementById('message-status');
        const submitButton = document.getElementById('submit-button');
        const courseModal = document.getElementById('course-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalBody = document.getElementById('modal-body');
        const modalContentBox = document.getElementById('modal-content-box');
        const navLinks = document.querySelectorAll('.nav-link-desktop');
        const sections = document.querySelectorAll('main section[id]');

        // Data detail Jurusan
        const courseDetails = {
            tkj: {
                title: "TKJ (Teknik Komputer & Jaringan)",
                content: `
                    <p>Jurusan ini dirancang untuk membekali siswa dengan keahlian komprehensif dalam instalasi, konfigurasi, dan pemeliharaan perangkat keras dan perangkat lunak jaringan komputer. Lulusan akan menguasai berbagai sistem operasi server (Linux, Windows Server) dan teknik pengkabelan (fiber optic, UTP) sesuai standar industri.</p>
                    <h4 class="font-bold text-white mt-4 mb-2">Materi Utama:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Pengenalan Komputer</li>
                        <li>Dasar Dasar jaringan Komputer</li>
                        <li>Konfigurasi Jaringan Dasar</li>
                        <li>Sistem Operasi Jaringan Dasar</li>
                        <li>Keselamatan dan Kesehatan Kerja</li>
                    </ul>
                    <p class="text-sm italic mt-4 text-gray-400">Prospek Karir: Network Administrator, Technical Support, Cloud Technician.</p>
                `
            },
            rpl: {
                title: "RPL (Rekayasa Perangkat Lunak)",
                content: `
                    <p>RPL adalah gerbang menuju dunia pengembangan software. Siswa akan belajar mulai dari konsep dasar algoritma, design database, hingga implementasi aplikasi full-stack. Kami fokus pada bahasa pemrograman yang paling diminati industri saat ini seperti JavaScript (Node.js, React) dan Python.</p>
                    <h4 class="font-bold text-white mt-4 mb-2">Materi Utama:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Algoritma & Logika Pemrograman</li>
                        <li>Pemrograman Dasar</li>
                        <li>Pemrograman Web Dasar</li>
                        <li>Basis Data (Database)</li>
                        <li>Pengembangan Web Lanjutan</li>
                    </ul>
                    <p class="text-sm italic mt-4 text-gray-400">Prospek Karir: Junior Web Developer, Mobile App Programmer, Software Tester.</p>
                `
            },
            mm: {
                title: "Multimedia (MM)",
                content: `
                    <p>Jurusan Multimedia mempersiapkan siswa menjadi content creator dan desainer visual profesional. Kurikulum mencakup teknik produksi video, animasi 2D/3D, fotografi, dan desain grafis yang sesuai untuk kebutuhan branding digital dan media promosi modern. Kami menggunakan software standar industri (Adobe Suite).</p>
                    <h4 class="font-bold text-white mt-4 mb-2">Materi Utama:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Dasar Desain Grafis</li>
                        <li>Fotografi dan Editing Foto</li>
                        <li>Desain Video dan Animasi</li>
                        <li>Audio dan Musik Digital</li>
                        <li>Etika dan Hak Cipta</li>
                    </ul>
                    <p class="text-sm italic mt-4 text-gray-400">Prospek Karir: Graphic Designer, Video Editor, Animator, Social Media Specialist.</p>
                `
            },
            akuntansi: {
                title: "Akuntansi Keuangan dan Lembaga",
                content: `
                    <p>Jurusan ini mendidik siswa untuk menjadi tenaga ahli di bidang pencatatan, pengklasifikasian, dan pelaporan transaksi keuangan perusahaan. Selain teori, siswa akan menguasai penggunaan software akuntansi (seperti Zahir atau MYOB) dan praktek perpajakan dasar yang relevan dengan regulasi di Indonesia.</p>
                    <h4 class="font-bold text-white mt-4 mb-2">Materi Utama:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Pengantar Akuntansi</li>
                        <li>Persamaan Dasar Akuntansi</li>
                        <li>Akun dan Kelompok Akun</li>
                        <li>Jurnal Umum</li>
                        <li>Buku Besar dan Neraca Saldo</li>
                    </ul>
                    <p class="text-sm italic mt-4 text-gray-400">Prospek Karir: Staf Akuntansi, Petugas Pajak, Auditor Junior, Kasir Profesional.</p>
                `
            },
            pemasaran: {
                title: "Pemasaran dan Bisnis Daring",
                content: `
                    <p>Jurusan Pemasaran fokus pada strategi penjualan dan promosi di era digital. Siswa diajarkan bagaimana menganalisis pasar, mengelola media sosial, membuat iklan digital yang efektif (Google Ads, Meta Ads), serta membangun hubungan pelanggan (CRM) untuk meningkatkan pendapatan bisnis.</p>
                    <h4 class="font-bold text-white mt-4 mb-2">Materi Utama:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Pengertian dan Konsep Dasar Pemasaran</li>
                        <li>Bauran Pemasaran (Marketing Mix – 4P)</li>
                        <li>Segmentasi, Targeting, dan Positioning (STP)</li>
                        <li>Perilaku Konsumen</li>
                        <li>Strategi Pemasaran Modern (Digital Marketing)</li>
                    </ul>
                    <p class="text-sm italic mt-4 text-gray-400">Prospek Karir: Digital Marketing Specialist, Sales Executive, E-commerce Admin, Content Creator.</p>
                `
            }
        };


        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        /**
         * Fungsi Navigasi Utama: Menggulir ke bagian tertentu.
         */
        function scrollToSection(sectionId) {
            mobileMenu.classList.add('hidden'); // Tutup menu mobile
            
            const target = document.getElementById(sectionId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start' // Gulir ke bagian atas elemen
                });
            }
        }
        
        /**
         * Menampilkan Modal dengan detail Jurusan yang dipilih.
         */
        function openCourseModal(event, courseKey) {
            event.preventDefault(); // Mencegah aksi default link (#)
            const details = courseDetails[courseKey];
            
            if (details) {
                modalTitle.textContent = details.title;
                modalBody.innerHTML = details.content;
                
                // Pastikan tombol 'Daftar Sekarang' terlihat
                courseModal.querySelector('button.w-full').style.display = 'block';

                courseModal.classList.remove('hidden');
                // Tambahkan kelas animasi setelah ditampilkan
                setTimeout(() => modalContentBox.classList.add('is-open'), 10);
            }
        }

        /**
         * Menyembunyikan Modal.
         */
        function closeCourseModal(event, isAlert = false, originalTitle = '', originalBody = '', originalButtonDisplay = 'block') {
             // Jika fungsi dipanggil tanpa event (misalnya dari tombol tutup), atau target adalah overlay
            if (!event || event.target === courseModal || event.target.closest('button')) {
                modalContentBox.classList.remove('is-open');
                setTimeout(() => {
                    courseModal.classList.add('hidden');
                    
                    // Jika modal digunakan untuk alert, kembalikan konten asli setelah ditutup
                    if (isAlert) {
                        modalTitle.textContent = originalTitle;
                        modalBody.innerHTML = originalBody;
                        courseModal.querySelector('button.w-full').style.display = originalButtonDisplay;
                        // Reset onclick ke fungsi default
                        courseModal.setAttribute('onclick', 'closeCourseModal(event)'); 
                    }
                }, 300); // Tunggu animasi selesai
            }
        }
        
        /**
         * Logika Navigasi Aktif Menggunakan Intersection Observer
         */
        function setActiveLink(sectionId) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.dataset.section === sectionId) {
                    link.classList.add('active');
                }
            });
        }

        const navObserverOptions = {
            // RootMargin: Margin di sekitar root. Menggunakan nilai negatif 
            // agar section hanya dianggap terlihat ketika melewati bagian atas viewport
            rootMargin: '-50% 0px -50% 0px', 
            threshold: 0 
        };

        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const sectionId = entry.target.id;
                    // Hanya set active jika section berada di tengah (sesuai rootMargin)
                    setActiveLink(sectionId);
                }
            });
        }, navObserverOptions);
        
        /**
         * Logika Animasi Scroll-in Teks/Card
         */
        const scrollAnimationObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Terapkan kelas 'show' saat elemen masuk viewport
                    entry.target.classList.add('show');
                    // Berhenti mengamati setelah animasi dipicu
                    observer.unobserve(entry.target); 
                }
            });
        }, {
            // Animasi dipicu saat elemen 10% terlihat
            threshold: 0.1 
        });


        document.addEventListener('DOMContentLoaded', () => {
            // Gulir ke bagian paling atas saat dimuat
            scrollToSection('home-page');

            // 1. Terapkan observer untuk navigasi aktif
            sections.forEach(section => {
                sectionObserver.observe(section);
            });
            
            // Set link Beranda aktif di awal
            setActiveLink('home-page');

            // 2. Terapkan observer untuk Animasi Scroll-in
            const animatableElements = document.querySelectorAll('.scroll-animate');
            animatableElements.forEach(el => scrollAnimationObserver.observe(el));
            
        });

        // chat bot
       // --- Setup Variabel Global ---
        const chatWindow = document.getElementById('elcChatWindow');
        const openChatBtn = document.getElementById('elcOpenChatBtn');
        const closeChatBtn = document.getElementById('elcCloseChatBtn');
        const chatHeader = document.getElementById('elcChatHeader');
        const resizeHandle = document.getElementById('elcResizeHandle');
        const chatArea = document.getElementById('elcChatArea');

        const MIN_WIDTH = 320;
        const MIN_HEIGHT = 400;
        
        let isDragging = false;
        let isResizing = false;
        let offset = { x: 0, y: 0 };
        let startX, startY, startW, startH;
        
        // FLAG BARU UNTUK RATE LIMITING (Bot Thinking)
        let isBotThinking = false; 

        const RECOMMENDATIONS = [
            { q: "Di dalam elearning ini ada jurusan apa saja", topic: "jurusan elearning" },
            { q: "kok akun verifikasinya gak muncul ?", topic: "pesan email" },
            { q: "Bagaimana cara siswa login ke e-Learning?", topic: "siswa login" },
            { q: "Fitur apa saja yang bisa digunakan siswa?", topic: "fitur siswa" },
            { q: "Ya, guru dapat mengupload materi, membuat tugas,", topic: "guru tugas" },
            { q: "Apakah e-Learning bisa dibuka lewat HP?", topic: "lewat hp" },
            { q: "Apakah data siswa aman?", topic: "data siswa" },
            { q: "Apakah tersedia forum diskusi dalam e-Learning?", topic: "forum diskusi" },
            { q: "Bagaimana cara melihat pengumuman terbaru?", topic: "pengumuman" },
            { q: "Apakah siswa bisa mengubah foto profil?", topic: "foto profil" },
            { q: "Apakah nilai ujian langsung muncul setelah selesai?", topic: "nilai ujian" },
            { q: "Apakah e-Learning mendukung pengiriman tugas berupa video atau gambar?", topic: "video gambar" },
            { q: "Bagaimana cara mengetahui tugas yang akan segera jatuh tempo?", topic: "jatuh tempo" },
        ];
        
        // --- FUNGSI SANITASI UTAMA (Mencegah XSS/HTML Injection) ---
        function escapeHTML(str) {
            if (!str || typeof str !== 'string') return '';
            // Mengganti karakter HTML yang berbahaya dengan entitas HTML-nya
            return str.replace(/[&<>"']/g, function(match) {
                switch (match) {
                    case '&': return '&amp;';
                    case '<': return '&lt;';
                    case '>': return '&gt;';
                    case '"': return '&quot;';
                    case "'": return '&#39;';
                    default: return match;
                }
            });
        }


        // --- Fungsi untuk membuat blok rekomendasi HTML ---
        function createRecommendationBlockHTML() {
            let buttonsHtml = '';
            // Ambil 6-8 rekomendasi secara acak untuk simulasi dinamika
            const selectedRecs = RECOMMENDATIONS.sort(() => 0.5 - Math.random()).slice(0, 7);

            selectedRecs.forEach(rec => {
                // Pastikan teks pertanyaan disanitasi sebelum dimasukkan ke data-attribute
                const safeQuestion = escapeHTML(rec.q); 
                buttonsHtml += `
                    <button class="elc-rec-btn text-left px-3 py-2 rounded-lg transition" data-question="${safeQuestion}">
                        ${safeQuestion}
                    </button>
                `;
            });

            return `
                <div class="elc-message-system p-3 shadow-md" id="recommendations-${Date.now()}">
                    <p class="font-bold mb-2">💡 Mau belajar apa lagi? Klik salah satu di bawah ini:</p>
                    <div class="flex flex-col space-y-2 text-sm mt-3">
                        ${buttonsHtml}
                    </div>
                </div>
            `;
        }

        // --- Fungsi Helper Chatbot ---
        function addMessage(rawText, sender) {
            // Sanitasi teks input sebelum ditampilkan
            const text = escapeHTML(rawText);

            const messageDiv = document.createElement('div');
            messageDiv.classList.add('p-3', 'shadow-md', 'w-fit');
            
            if (sender === 'user') {
                messageDiv.classList.add('elc-message-user');
                // Menggunakan textContent untuk memastikan input ditampilkan sebagai teks murni
                messageDiv.textContent = text; 
            } else { // system (bot)
                messageDiv.classList.add('elc-message-system');
                
                // Cari respon berdasarkan topik
                const topic = RECOMMENDATIONS.find(r => rawText.includes(r.q))?.topic || 'default';
                
                let responseText = '';
                
                switch (topic) {
                    case "jurusan elearning":
                        responseText = 'Di e-Learning ini tersedia beberapa jurusan, yaitu Teknik Komputer dan Jaringan (TKJ), Rekayasa Perangkat Lunak (RPL), Multimedia (MM), Akuntansi, dan Pemasaran.';
                        break;
                    case "pesan email":
                        responseText = 'Silakan periksa spam/kotak masuk email Anda untuk mendapatkan link verifikasi.';
                        break;
                    case "siswa login":
                        responseText = 'Untuk masuk ke e-Learning, silakan klik tombol Login. Jika Anda belum memiliki akun, pilih menu Daftar Baru yang ada di bawah tombol login pada halaman tersebut.';
                        break;
                    case "fitur siswa":
                        responseText = '“Siswa dapat menggunakan beberapa fitur, seperti berdiskusi dengan teman satu jurusan, mendapatkan title khusus jika semua materi telah diselesaikan, serta melihat tanda merah pada tugas yang belum dikerjakan.';
                        break;
                    case "guru tugas":
                        responseText = 'Ya, guru dapat mengupload materi serta membuat tugas melalui halaman khusus tugas dan upload yang telah disediakan.';
                        break;
                    case "lewat hp":
                        responseText = 'Bisa, aplikasi sudah mendukung tampilan mobile sehingga dapat digunakan lewat smartphone.';
                        break;
                    case "data siswa":
                        responseText = 'Ya, e-Learning menggunakan sistem keamanan untuk menjaga kerahasiaan dan keselamatan data pengguna.';
                        break;
                    case "forum diskusi":
                        responseText = 'Ya, e-Learning menyediakan forum diskusi, namun hanya siswa dari jurusan yang sama yang dapat saling berdiskusi.';
                        break;
                    case "pengumuman":
                        responseText = 'Pengumuman terbaru dapat dilihat melalui bagian sidebar. Akan muncul tanda merah jika terdapat pengumuman baru.';
                        break;
                    case "foto profil":
                        responseText = 'Ya, siswa dapat mengubah foto profil. Cukup buka bagian sidebar, klik menu Pengaturan, lalu Anda bisa mengganti foto profil serta nama.';
                        break;
                    case "nilai ujian":
                        responseText = 'Tergantung jenis ujiannya. Jika ujian berasal dari materi, nilai akan langsung muncul setelah selesai. Namun jika ujian dibuat oleh guru, Anda perlu menunggu koreksi dari guru terlebih dahulu.';
                        break;
                    case "video gambar":
                        responseText = 'Saat ini e-Learning hanya mendukung pengumpulan tugas dalam bentuk gambar dan file dokumen. Pengiriman video belum tersedia.';
                        break;
                    case "jatuh tempo":
                        responseText = 'Anda dapat melihat tugas yang akan segera jatuh tempo melalui pemberitahuan di halaman dashboard. Sistem akan menampilkan notifikasi jika tugas memiliki tenggat kurang dari 3 hari.';
                        break;
                    default:
                        responseText = 'Mohon maaf, ini adalah asisten simulasi. Untuk pertanyaan tersebut, saya akan mencari jawabannya di internet dan memberikan ringkasan yang mudah dipahami.';
                }
                
                // Bot response menggunakan innerHTML HANYA karena berisi tag <p> dan <span> yang dikontrol penuh (hardcoded). 
                messageDiv.innerHTML = `<p class="font-bold mb-1">Respons Bot:</p><p>${responseText}</p><p class="mt-2 text-xs opacity-80">Ada lagi yang ingin ditanyakan?</p>`;
            }

            chatArea.appendChild(messageDiv);
            
            return messageDiv; // Mengembalikan elemen yang baru dibuat
        }

        // --- Event Delegation untuk Tombol Rekomendasi ---
        chatArea.addEventListener('click', (e) => {
            // Periksa jika bot sedang memproses, abaikan klik
            if (isBotThinking) return;

            if (e.target.classList.contains('elc-rec-btn')) { 
                const question = e.target.getAttribute('data-question');
                handleUserInput(question);
                
                // Menonaktifkan sementara semua tombol rekomendasi yang terlihat
                document.querySelectorAll('.elc-rec-btn').forEach(btn => {
                    btn.classList.add('elc-disabled');
                });
            }
        });

        // --- Fungsi Utama Penanganan Input User ---
        function handleUserInput(input) {
            const trimmedInput = input.trim();
            if (!trimmedInput) return;

            // 1. CEK RATE LIMIT: Jika bot sedang berpikir, keluar
            if (isBotThinking) return; 
            
            // 2. SET RATE LIMIT: Tandai bot sedang berpikir
            isBotThinking = true; 

            // 3. Tambahkan pesan user
            const userMessageDiv = addMessage(trimmedInput, 'user');

            // Gulirkan area chat ke pesan user yang baru
             chatArea.scrollTo({
                top: userMessageDiv.offsetTop,
                behavior: 'smooth'
            });


            // 4. Tambahkan pesan bot setelah jeda
            setTimeout(() => {
                // Tambahkan pesan bot dan simpan referensinya
                const botMessageDiv = addMessage(trimmedInput, 'system'); 
                
                // Gulirkan #elcChatArea ke elemen pesan bot yang baru dibuat
                chatArea.scrollTo({
                    top: botMessageDiv.offsetTop, 
                    behavior: 'smooth'
                });

                // 5. Tambahkan blok rekomendasi baru
                chatArea.insertAdjacentHTML('beforeend', createRecommendationBlockHTML());
                
                // 6. RESET RATE LIMIT: Tandai bot selesai berpikir
                isBotThinking = false;
                
                // Mengaktifkan kembali semua tombol rekomendasi setelah selesai
                document.querySelectorAll('.elc-rec-btn').forEach(btn => {
                    btn.classList.remove('elc-disabled');
                });

            }, 800);
        }


        // --- Event Listener Tombol Chat ---

        openChatBtn.addEventListener('click', () => {
            chatWindow.classList.remove('hidden');
            
            // Menambahkan rekomendasi awal jika belum ada
            if (!chatArea.querySelector('.elc-rec-btn')) {
                chatArea.insertAdjacentHTML('beforeend', createRecommendationBlockHTML());
            }

            // --- LOGIKA POSISI ABSOLUT PADA DOKUMEN ---
            const btnRect = openChatBtn.getBoundingClientRect();
            const scrollY = window.scrollY || window.pageYOffset;
            const scrollX = window.scrollX || window.pageXOffset;

            const w = chatWindow.offsetWidth;
            const h = chatWindow.offsetHeight;
            const vw = window.innerWidth;
            const vh = window.innerHeight;

            // Target position: Hitung posisi relatif ke DOKUMEN (tambah scrollY/scrollX)
            let targetLeft = btnRect.left + scrollX;
            let targetTop = btnRect.top + scrollY - h - 20; // 20px di atas tombol

            // 1. Batasan Kiri/Kanan
            if (targetLeft + w > vw - 10 + scrollX) {
                targetLeft = vw - w - 10 + scrollX;
            }
            if (targetLeft < 10 + scrollX) {
                targetLeft = 10 + scrollX;
            }

            // 2. Batasan Atas/Bawah
            if (targetTop < scrollY + 10) { 
                targetTop = btnRect.bottom + scrollY + 10;
            }
            if (targetTop + h > vh - 10 + scrollY) {
                 targetTop = vh - h - 10 + scrollY;
            }

            chatWindow.style.left = `${targetLeft}px`;
            chatWindow.style.top = `${targetTop}px`;
        });

        closeChatBtn.addEventListener('click', () => {
            chatWindow.classList.add('hidden');
        });


        // --- Logika Drag and Drop Jendela (Memindahkan) ---

        chatHeader.addEventListener('mousedown', startDrag);
        chatHeader.addEventListener('touchstart', startDrag, { passive: false });

        function startDrag(e) {
            if (e.target.tagName === 'BUTTON') return; 
            isDragging = true;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;

            offset.x = clientX - chatWindow.offsetLeft;
            offset.y = clientY - chatWindow.offsetTop;

            chatWindow.style.cursor = 'grabbing';
            e.preventDefault(); 
        }

        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag, { passive: false });

        function drag(e) {
            if (!isDragging) return;

            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            
            // Menghitung posisi baru relatif terhadap dokumen (viewport + scroll)
            const scrollX = window.scrollX || window.pageXOffset;
            const scrollY = window.scrollY || window.pageYOffset;

            let newX = clientX - offset.x;
            let newY = clientY - offset.y;

            // Batasan agar jendela tidak keluar dari viewport (disesuaikan dengan scroll)
            newX = Math.max(scrollX, Math.min(newX, scrollX + window.innerWidth - chatWindow.offsetWidth));
            newY = Math.max(scrollY, Math.min(newY, scrollY + window.innerHeight - chatWindow.offsetHeight));

            chatWindow.style.left = `${newX}px`;
            chatWindow.style.top = `${newY}px`;
            e.preventDefault(); 
        }

        document.addEventListener('mouseup', stopDrag);
        document.addEventListener('touchend', stopDrag);

        function stopDrag() {
            isDragging = false;
            chatWindow.style.cursor = 'default';
        }


        // --- Logika Resizing Jendela ---

        resizeHandle.addEventListener('mousedown', startResize);
        resizeHandle.addEventListener('touchstart', startResize, { passive: false });

        function startResize(e) {
            isResizing = true;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            
            startX = clientX;
            startY = clientY;
            
            startW = chatWindow.offsetWidth;
            startH = chatWindow.offsetHeight;
            
            e.preventDefault();
        }

        document.addEventListener('mousemove', resize);
        document.addEventListener('touchmove', resize, { passive: false });

        function resize(e) {
            if (!isResizing) return;

            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;

            const deltaX = clientX - startX;
            const deltaY = clientY - startY;

            let newW = startW + deltaX;
            let newH = startH + deltaY;

            // Terapkan batasan minimal
            newW = Math.max(newW, MIN_WIDTH);
            newH = Math.max(newH, MIN_HEIGHT);

            // Terapkan batasan maksimal (berdasarkan ukuran viewport yang terlihat)
            const MAX_VW = window.innerWidth * 0.9;
            const MAX_VH = window.innerHeight * 0.9;
            newW = Math.min(newW, MAX_VW);
            newH = Math.min(newH, MAX_VH);

            chatWindow.style.width = `${newW}px`;
            chatWindow.style.height = `${newH}px`;
            e.preventDefault();
        }

        document.addEventListener('mouseup', stopResize);
        document.addEventListener('touchend', stopResize);

        function stopResize() {
            isResizing = false;
        }

        // Penyesuaian posisi saat window resize
        window.addEventListener('resize', () => {
             // Pastikan jendela tetap dalam batas saat viewport berubah
            if (!chatWindow.classList.contains('hidden')) {
                const w = chatWindow.offsetWidth;
                const h = chatWindow.offsetHeight;
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const scrollX = window.scrollX || window.pageXOffset;
                const scrollY = window.scrollY || window.pageYOffset;

                let currentX = chatWindow.offsetLeft;
                let currentY = chatWindow.offsetTop;

                // Cek batas kanan dan bawah (disesuaikan dengan scroll)
                if (currentX + w > scrollX + vw) {
                    chatWindow.style.left = `${Math.max(scrollX, scrollX + vw - w)}px`;
                }
                if (currentY + h > scrollY + vh) {
                    chatWindow.style.top = `${Math.max(scrollY, scrollY + vh - h)}px`;
                }
                // Cek batas kiri dan atas
                if (currentX < scrollX) {
                    chatWindow.style.left = `${scrollX}px`;
                }
                 if (currentY < scrollY) {
                    chatWindow.style.top = `${scrollY}px`;
                }
            }
        });
