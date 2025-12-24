<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segera Hadir - SMK Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tambahkan Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'smk-dark': '#020617',
                        'smk-blue': '#3b82f6',
                        'smk-emerald': '#10b981',
                        'smk-accent': '#facc15',
                    },
                    animation: {
                        'slow-spin': 'spin 20s linear infinite',
                        'float': 'float 5s ease-in-out infinite',
                        'pulse-gentle': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
            color: #f8fafc;
        }
        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .mesh-bg {
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.12) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.12) 0, transparent 50%);
        }
    </style>
</head>
<body class="antialiased mesh-bg min-h-screen">
    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none opacity-30">
        <div class="absolute -top-24 -left-24 w-96 h-96 border border-blue-500/10 rounded-full animate-slow-spin"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[600px] h-[600px] border border-emerald-500/5 rounded-full animate-slow-spin" style="animation-direction: reverse;"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col px-6 py-8 md:px-16 md:py-12">
        
        <header class="flex justify-between items-center mb-12">
            <div class="flex items-center gap-3">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-smk-blue to-smk-emerald rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                    <div class="relative w-12 h-12 bg-smk-dark border border-white/10 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-smk-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="block font-extrabold text-xl tracking-tight leading-none uppercase">SMK Learn</span>
                </div>
            </div>
            <button onclick="history.back()" class="px-5 py-2 rounded-full border border-white/10 text-[10px] font-bold text-slate-400 hover:text-white hover:bg-white/5 transition-all flex items-center gap-2 tracking-widest uppercase">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </button>
        </header>

        <main class="flex-grow flex flex-col items-center justify-center text-center py-12 px-6">
            
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 dark:bg-slate-800/50 dark:border-slate-700">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-blue-500"></span>
                    </span>
                    <span class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                        Finalisasi Pengembangan
                    </span>
                </div>
            </div>

            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight leading-tight text-slate-900 dark:text-white">
                Segera <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Hadir</span>
            </h1>

            <div class="w-12 h-[2px] bg-blue-500/20 mb-6 mx-auto"></div>

            <p class="max-w-md text-slate-500 dark:text-slate-400 text-sm md:text-base leading-relaxed mb-8 font-normal">
                Mempersiapkan <span class="text-slate-900 dark:text-slate-200 font-semibold">generasi unggul</span> melalui modul interaktif dan praktik industri dalam satu genggaman.
            </p>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 w-full max-w-[100px]">
                <p class="text-[10px] text-slate-400 uppercase tracking-[0.3em]">v1.0.0</p>
            </div>

        </main>

    </div>
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>
</body>
</html>
