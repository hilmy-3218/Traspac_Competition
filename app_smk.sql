-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 06:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_smk`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_soal`
--

CREATE TABLE `bank_soal` (
  `id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `jawaban` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_soal`
--

INSERT INTO `bank_soal` (`id`, `materi_id`, `jurusan`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`) VALUES
(1, 1, 'TKJ', 'Apa pengertian komputer secara umum?', 'Perangkat elektronik untuk mengolah data menjadi informasi', 'Perangkat komunikasi saja', 'Mesin cetak otomatis', 'Alat mekanik untuk menggambar', 0),
(2, 1, 'TKJ', 'Fungsi utama komputer yang benar adalah?', 'Mengolah, menyimpan, memindahkan, dan mengendalikan data', 'Menangkap sinyal radio', 'Menerima sinyal televisi', 'Mengatur aliran listrik', 0),
(3, 1, 'TKJ', 'Komponen utama komputer yang disebut sebagai \'otak komputer\' adalah?', 'VGA', 'RAM', 'CPU', 'PSU', 2),
(4, 1, 'TKJ', 'Perangkat yang berfungsi menampilkan informasi hasil pemrosesan komputer adalah?', 'Keyboard', 'Monitor', 'Scanner', 'Mouse', 1),
(5, 1, 'TKJ', 'Fungsi utama RAM adalah?', 'Menghasilkan tampilan visual', 'Menjalankan instruksi input', 'Mengubah arus AC ke DC', 'Menyimpan data sementara saat proses berlangsung', 3),
(6, 1, 'TKJ', 'Komponen komputer yang menghubungkan seluruh perangkat adalah?', 'Printer', 'Keyboard', 'Motherboard', 'Monitor', 2),
(7, 1, 'TKJ', 'Komponen komputer yang mengubah arus AC menjadi DC disebut?', 'RAM', 'PSU', 'SSD', 'CPU', 1),
(8, 1, 'TKJ', 'Jenis penyimpanan yang lebih cepat dan tahan guncangan adalah?', 'HDD', 'Floppy Disk', 'CD-ROM', 'SSD', 3),
(9, 1, 'TKJ', 'Perangkat input yang digunakan untuk memasukkan data berupa teks adalah?', 'Printer', 'Speaker', 'Keyboard', 'Monitor', 2),
(10, 1, 'TKJ', 'Siklus pemrosesan informasi dimulai dari tahap?', 'Storage', 'Process', 'Output', 'Input', 3),
(11, 1, 'TKJ', 'Komputer pribadi (PC) dirancang untuk?', 'Menjalankan sistem server', 'Mengelola jaringan besar', 'Melayani ratusan klien', 'Digunakan oleh satu orang dalam satu waktu', 3),
(12, 1, 'TKJ', 'Server berfungsi untuk?', 'Menyediakan layanan dan sumber daya bagi komputer lain', 'Mengetik dokumen pribadi', 'Mengedit gambar', 'Menjalankan game offline', 0),
(13, 1, 'TKJ', 'GPU berfungsi untuk?', 'Menyalurkan daya listrik', 'Mengolah tampilan grafis dan visual', 'Menyimpan data sementara', 'Mengendalikan perangkat input', 1),
(14, 1, 'TKJ', 'Brainware dalam sistem komputer adalah?', 'Jaringan internet', 'Manusia yang mengoperasikan komputer', 'Perangkat keras', 'Perangkat lunak', 1),
(15, 1, 'TKJ', 'Software adalah?', 'Sekumpulan instruksi digital yang mengatur kerja komputer', 'Jaringan antar komputer', 'Bagian fisik komputer', 'Perangkat komunikasi', 0),
(16, 1, 'TKJ', 'Contoh perangkat lunak sistem operasi adalah?', 'Monitor', 'CPU', 'Motherboard', 'Windows', 3),
(17, 1, 'TKJ', 'Output dari komputer dapat berupa?', 'Gerakan mouse', 'Arus listrik', 'Perintah dari keyboard', 'Tampilan visual di monitor', 3),
(18, 1, 'TKJ', 'Media penyimpanan yang bersifat permanen adalah?', 'Cache', 'HDD/SSD', 'RAM', 'Register', 1),
(19, 1, 'TKJ', 'Fungsi utama motherboard adalah?', 'Menghubungkan seluruh komponen komputer agar bisa berkomunikasi', 'Mengubah data menjadi sinyal listrik', 'Menjalankan instruksi program', 'Menyimpan data secara permanen', 0),
(20, 1, 'TKJ', 'Tanpa brainware, sistem komputer tidak dapat?', 'Menyimpan file otomatis', 'Beroperasi karena tidak ada yang memberi instruksi', 'Menampilkan warna di layar', 'Menghasilkan suara', 1),
(21, 2, 'TKJ', 'Apa pengertian dari jaringan komputer?', 'Sistem yang menghubungkan dua atau lebih perangkat untuk berkomunikasi', 'Perangkat keras komputer yang berdiri sendiri', 'Aplikasi untuk menghubungkan internet', 'Media penyimpanan data komputer', 0),
(22, 2, 'TKJ', 'Media transmisi yang menggunakan gelombang radio disebut...', 'Fiber Optic', 'Wireless', 'UTP', 'Bluetooth', 1),
(23, 2, 'TKJ', 'Tujuan utama jaringan komputer adalah...', 'Mempercepat booting komputer', 'Berbagi data dan sumber daya', 'Meningkatkan kualitas grafis', 'Menghemat kapasitas RAM', 1),
(24, 2, 'TKJ', 'Contoh jaringan dengan cakupan paling kecil adalah...', 'WAN', 'LAN', 'MAN', 'Internet', 1),
(25, 2, 'TKJ', 'Jaringan komputer dengan cakupan satu kota disebut...', 'LAN', 'WAN', 'MAN', 'PAN', 2),
(26, 2, 'TKJ', 'Jaringan terbesar di dunia adalah...', 'LAN', 'MAN', 'Internet', 'VPN', 2),
(27, 2, 'TKJ', 'Topologi yang menggunakan satu kabel utama (backbone) disebut...', 'Star', 'Bus', 'Ring', 'Mesh', 1),
(28, 2, 'TKJ', 'Pada topologi Star, semua perangkat terhubung ke...', 'Router', 'Switch/Hub', 'Server', 'Access Point', 1),
(29, 2, 'TKJ', 'Topologi yang perangkatnya terhubung membentuk lingkaran adalah...', 'Star', 'Mesh', 'Ring', 'Bus', 2),
(30, 2, 'TKJ', 'Topologi dengan keandalan paling tinggi (redundansi banyak jalur) adalah...', 'Ring', 'Mesh', 'Star', 'Bus', 1),
(31, 2, 'TKJ', 'Perangkat jaringan yang bekerja pada Layer 2 OSI dan menggunakan MAC address adalah...', 'Router', 'Switch', 'Hub', 'Modem', 1),
(32, 2, 'TKJ', 'Router bekerja pada layer...', 'Layer 1', 'Layer 2', 'Layer 3', 'Layer 7', 2),
(33, 2, 'TKJ', 'Perangkat yang berfungsi mengirim sinyal ke semua port tanpa seleksi (Layer 1) adalah...', 'Router', 'Switch', 'Hub', 'Access Point', 2),
(34, 2, 'TKJ', 'Access Point digunakan untuk...', 'Membuat jaringan wireless', 'Menghubungkan jaringan antar kota', 'Mengatur alamat IP', 'Menambah kapasitas RAM', 0),
(35, 2, 'TKJ', 'Kabel UTP (Unshielded Twisted Pair) menggunakan konektor...', 'SC', 'LC', 'RJ-45', 'ST', 2),
(36, 2, 'TKJ', 'Kabel jaringan tercepat dan tahan interferensi adalah...', 'UTP', 'STP', 'Fiber Optic', 'Coaxial', 2),
(37, 2, 'TKJ', 'Jenis Fiber Optic untuk jarak jauh adalah...', 'Single-Mode', 'Multi-Mode', 'UTP', 'STP', 0),
(38, 2, 'TKJ', 'Teknologi wireless jarak pendek contohnya...', 'Wi-Fi', 'Bluetooth', '5G', 'Fiber Optic', 1),
(39, 2, 'TKJ', 'Data pada topologi Ring mengalir secara...', 'Acak', 'Dua arah', 'Searah', 'Tidak beraturan', 2),
(40, 2, 'TKJ', 'Media transmisi yang paling rentan gangguan elektromagnetik (EMI/RFI) adalah...', 'Fiber Optic', 'UTP', 'Wireless', 'Bluetooth', 1),
(41, 3, 'TKJ', 'Fungsi utama dari IP Address adalah sebagai...', 'Media penyimpanan data', 'Identitas perangkat dan penentu lokasi dalam jaringan', 'Aplikasi untuk mengirim pesan instan', 'Kabel penghubung antar perangkat', 1),
(42, 3, 'TKJ', 'IPv4 memiliki panjang bit sebesar...', '64 bit', '32 bit', '128 bit', '256 bit', 1),
(43, 3, 'TKJ', 'Bagian dari IP Address yang menunjukkan perangkat tertentu di dalam jaringan disebut...', 'Network ID', 'Octet', 'Host ID', 'Broadcast ID', 2),
(44, 3, 'TKJ', 'Alamat IP yang ditetapkan secara otomatis oleh server menggunakan protokol DHCP disebut IP...', 'Statis', 'Unik', 'Global', 'Dinamis', 3),
(45, 3, 'TKJ', 'Perangkat jaringan seperti Server Web atau Router umumnya dikonfigurasi menggunakan jenis IP...', 'Dinamis', 'Wireless', 'Statis', 'Otomatis', 2),
(46, 3, 'TKJ', 'Protokol yang bertanggung jawab dalam memberikan IP Dinamis secara otomatis kepada klien adalah...', 'ICMP', 'TCP', 'DHCP', 'ARP', 2),
(47, 3, 'TKJ', 'Apa fungsi utama dari Subnet Mask?', 'Meningkatkan kecepatan koneksi', 'Mengenkripsi data yang ditransfer', 'Memisahkan Network ID dan Host ID pada IP Address', 'Mengecek keamanan jaringan', 2),
(48, 3, 'TKJ', 'Nilai desimal dari octet yang memiliki 8 bit \'1\' penuh (11111111) pada Subnet Mask adalah...', '128', '192', '255', '0', 2),
(49, 3, 'TKJ', 'Notasi CIDR /26 setara dengan Subnet Mask...', '255.255.255.0', '255.255.255.128', '255.255.255.192', '255.255.255.224', 2),
(50, 3, 'TKJ', 'Pada perhitungan Subnetting, jika prefix awal adalah /24 dan prefix target adalah /26, berapa banyak bit tambahan yang dipinjam?', '1 bit', '2 bit', '4 bit', '8 bit', 1),
(51, 3, 'TKJ', 'Jika Anda meminjam 3 bit untuk subnetting, berapa jumlah subnet yang dihasilkan (menggunakan rumus $2^n$)?', '4 subnet', '6 subnet', '8 subnet', '16 subnet', 2),
(52, 3, 'TKJ', 'Jika bit Host yang tersisa adalah 5 bit, berapa jumlah host yang bisa digunakan per subnet (menggunakan rumus $2^n - 2$)?', '14 host', '30 host', '32 host', '62 host', 1),
(53, 3, 'TKJ', 'Perintah diagnostik jaringan yang digunakan untuk menguji konektivitas dan mengukur waktu tempuh (Latency) adalah...', 'ipconfig', 'traceroute', 'ping', 'netstat', 2),
(54, 3, 'TKJ', 'Protokol yang digunakan oleh perintah `ping` untuk mengirim paket data adalah...', 'TCP', 'UDP', 'HTTP', 'ICMP', 3),
(55, 3, 'TKJ', 'Perintah `ping 192.168.1.1` umumnya digunakan untuk menguji koneksi ke perangkat apa dalam jaringan lokal?', 'DHCP Server', 'DNS Server', 'Router Lokal (Gateway)', 'Server Web Eksternal', 2),
(56, 4, 'TKJ', 'Sistem Operasi yang dirancang untuk memberikan pengalaman intuitif bagi satu pengguna tunggal dalam tugas sehari-hari disebut...', 'OS Server', 'OS Jaringan', 'OS Client', 'OS Mainframe', 2),
(57, 4, 'TKJ', 'Fokus desain utama dari Sistem Operasi Client adalah...', 'Stabilitas dan Keandalan 24/7', 'Antarmuka Grafis (GUI) yang ramah pengguna', 'Manajemen ribuan koneksi server', 'Mengurangi overhead melalui CLI', 1),
(58, 4, 'TKJ', 'Contoh umum dari Sistem Operasi Client adalah...', 'Windows Server', 'Red Hat Enterprise Linux', 'macOS', 'Debian Server', 2),
(59, 4, 'TKJ', 'Sistem Operasi yang dirancang untuk menyediakan layanan dan sumber daya jaringan kepada banyak client secara simultan adalah...', 'OS Desktop', 'OS Client', 'OS Pribadi', 'OS Server', 3),
(60, 4, 'TKJ', 'Fokus utama dalam desain Sistem Operasi Server adalah...', 'Kecepatan respons antarmuka grafis', 'Stabilitas, Keandalan (Uptime), dan Keamanan', 'Dukungan penuh untuk aplikasi multimedia', 'Koneksi jaringan tunggal berkecepatan tinggi', 1),
(61, 4, 'TKJ', 'Mengapa OS Server seringkali hanya menggunakan CLI (Command Line Interface)?', 'Agar terlihat lebih modern', 'Untuk mengurangi overhead dan membebaskan sumber daya', 'Karena tidak dapat menampilkan grafis', 'Membuatnya lebih mudah diakses oleh pengguna biasa', 1),
(62, 4, 'TKJ', 'Sistem Operasi mana yang dioptimalkan untuk menangani volume trafik dan permintaan jaringan yang tinggi dari ribuan klien?', 'Windows 11', 'Android', 'OS Server', 'Linux Desktop', 2),
(63, 4, 'TKJ', 'Fitur yang sangat dibatasi pada OS Client dibandingkan OS Server adalah...', 'Fitur pengeditan dokumen', 'Akses ke internet', 'Jumlah koneksi inbound (masuk)', 'Penggunaan CPU', 2),
(64, 4, 'TKJ', 'Salah satu contoh layanan penting yang disediakan oleh Sistem Operasi Server adalah...', 'Menjalankan game beresolusi tinggi', 'Layanan Web Server dan Database', 'Menginstal aplikasi kantor tunggal', 'Aplikasi pemutar musik offline', 1),
(65, 4, 'TKJ', 'Sistem Operasi Client dioptimalkan untuk menjalankan...', 'Layanan jaringan 24/7', 'Aplikasi pengguna akhir (end-user applications)', 'Proses otentikasi ribuan pengguna', 'Manajemen virtualisasi skala besar', 1),
(66, 4, 'TKJ', 'Yang merupakan karakteristik kinerja OS Server adalah...', 'Kinerja dioptimalkan untuk kecepatan respons desktop', 'Memiliki kemampuan manajemen memori dan multitasking yang unggul', 'Memiliki batas koneksi inbound yang rendah', 'Membutuhkan perangkat keras minimal', 1),
(67, 4, 'TKJ', 'Ketika sebuah komputer pribadi menjalankan aplikasi browser web dan word processor, ia menggunakan...', 'OS Server', 'OS Jaringan', 'OS Client', 'OS Database', 2),
(68, 4, 'TKJ', 'Apa yang dimaksud dengan \'Uptime\' pada konteks OS Server?', 'Waktu yang dibutuhkan untuk booting', 'Waktu sistem beroperasi tanpa gangguan', 'Waktu yang dihabiskan untuk instalasi', 'Waktu respons antarmuka grafis', 1),
(69, 4, 'TKJ', 'Di antara pilihan berikut, manakah yang termasuk contoh Linux Server?', 'Ubuntu Desktop', 'Debian Server', 'Windows 11', 'macOS', 1),
(70, 4, 'TKJ', 'Inti perbedaan antara OS Client dan OS Server adalah...', 'Ukuran layar yang digunakan', 'Warna antarmuka pengguna', 'Fokus pada interaksi pengguna tunggal vs. pelayanan jaringan massal', 'Kecepatan koneksi Wi-Fi', 2),
(71, 5, 'TKJ', 'Mengapa dilarang keras membawa makanan dan minuman ke dalam area laboratorium TKJ?', 'Mengganggu konsentrasi belajar', 'Dapat merusak komponen elektronik dan keyboard', 'Menimbulkan bau tidak sedap', 'Membuat ruangan menjadi ramai', 1),
(72, 5, 'TKJ', 'Tindakan yang salah ketika mencabut kabel (power atau jaringan) adalah...', 'Menarik kabel hanya pada bagian konektornya', 'Melakukan prosedur Shutdown sebelum mencabut power', 'Mencabut kabel dengan menarik bagian kabelnya (bukan konektor)', 'Memastikan kabel terpasang dengan benar', 2),
(73, 5, 'TKJ', 'Apa yang harus dilakukan segera jika Anda menemukan perangkat yang rusak atau mengeluarkan asap?', 'Mencoba memperbaikinya sendiri', 'Segera laporkan kepada guru atau teknisi', 'Merekamnya dengan ponsel', 'Membiarkannya saja', 1),
(74, 5, 'TKJ', 'Tujuan dari melakukan prosedur Shutdown yang benar sebelum mematikan aliran listrik adalah...', 'Menghemat waktu', 'Mencegah kerusakan sistem operasi dan data', 'Mempercepat proses booting berikutnya', 'Mengaktifkan mode sleep', 1),
(75, 5, 'TKJ', 'Perangkat lunak yang wajib digunakan untuk memeriksa USB flash drive sebelum digunakan di komputer lab adalah...', 'Word Processor', 'Antivirus', 'Web Browser', 'Video Player', 1),
(76, 5, 'TKJ', 'Apa fungsi utama dari perintah **Log Out** saat meninggalkan komputer lab, meskipun hanya sebentar?', 'Menghemat daya listrik', 'Mempercepat koneksi internet', 'Melindungi berkas dan sesi dari akses pengguna lain', 'Mereset pengaturan jaringan', 2),
(77, 5, 'TKJ', 'Alat ukur elektronik serbaguna yang digunakan untuk mengukur Tegangan, Arus, dan Resistansi adalah...', 'LAN Tester', 'Fusion Splicer', 'Crimping Tool', 'Multimeter (Multitester)', 3),
(78, 5, 'TKJ', 'Saat mengukur Tegangan DC menggunakan Multimeter, probe Merah harus dihubungkan ke terminal...', 'Ground', 'Negatif (-)', 'Positif (+)', 'Netral', 2),
(79, 5, 'TKJ', 'Mengapa saat mengukur Resistansi (Ohm), komponen harus dipastikan tidak terhubung dengan sumber tegangan?', 'Agar pengukuran lebih cepat', 'Untuk menghindari korsleting', 'Karena multimeter dapat rusak', 'Resistansi hanya dapat diukur pada AC', 2),
(80, 5, 'TKJ', 'Fungsi utama dari LAN Tester adalah...', 'Menyambung kabel Fiber Optic', 'Mengukur tegangan listrik', 'Memeriksa konektivitas dan susunan kabel UTP/STP', 'Memotong ujung serat optik', 2),
(81, 5, 'TKJ', 'Pada LAN Tester, apa yang ditunjukkan jika lampu LED pada nomor pin tertentu tidak menyala?', 'Kabel terlalu panjang', 'Kabel mengalami putus (open) atau koneksi tidak sempurna', 'Kabel terlalu pendek', 'Kabel terpasang dengan standar Crossover', 1),
(82, 5, 'TKJ', 'Alat yang digunakan untuk menjepit konektor RJ-45 ke ujung kabel UTP adalah...', 'LAN Tester', 'Fusion Splicer', 'Crimping Tool', 'Cleaver', 2),
(83, 5, 'TKJ', 'Pada proses Crimping, setelah kawat disusun sesuai standar, apa langkah selanjutnya sebelum kawat dimasukkan ke konektor RJ-45?', 'Mengupas kulit kabel luar', 'Melilit kawat menjadi satu', 'Meluruskan dan meratakan ujung kawat dengan pemotong', 'Menguji menggunakan LAN Tester', 2),
(84, 5, 'TKJ', 'Alat presisi yang digunakan untuk menciptakan permukaan ujung serat optik yang rata dan tegak lurus sebelum disambung adalah...', 'Stripper', 'Fusion Splicer', 'LAN Tester', 'Cleaver (Pemotong Serat Optik)', 3),
(85, 5, 'TKJ', 'Tujuan dari Fusion Splicer adalah menyambung dua ujung serat optik dengan cara...', 'Diikat menggunakan perekat', 'Dileburkan menggunakan busur listrik (fusi)', 'Dijepit menggunakan konektor mekanis', 'Dihubungkan menggunakan konektor RJ-45', 1),
(86, 5, 'TKJ', 'Proses Core Alignment yang dilakukan oleh Fusion Splicer bertujuan untuk...', 'Menghilangkan lapisan pelindung', 'Mengecek tegangan listrik', 'Menyelaraskan inti (core) kedua serat secara presisi', 'Membaca hasil splice loss', 2),
(87, 5, 'TKJ', 'Apa bahaya dari menekuk kabel, terutama kabel serat optik, dengan sudut yang terlalu tajam?', 'Menimbulkan suara berisik', 'Menyebabkan kerugian sinyal (signal loss) parah', 'Mempercepat transfer data', 'Memperpanjang usia kabel', 1),
(88, 5, 'TKJ', 'Mengapa disarankan menggunakan Velcro/Strap Kabel daripada cable tie plastik saat merapikan kabel?', 'Velcro lebih murah', 'Velcro dapat menekan kabel lebih keras', 'Velcro lebih mudah dibuka tutup untuk pemeliharaan', 'Velcro lebih tahan air', 2),
(89, 5, 'TKJ', 'Tindakan yang perlu dilakukan untuk mencegah Interferensi Elektromagnetik (EMI) yang dapat merusak sinyal data adalah...', 'Menggunakan kabel yang sangat panjang', 'Memisahkan jalur kabel data dari kabel listrik (power)', 'Mengikat kabel seerat mungkin', 'Menggunakan Crimping Tool yang mahal', 1),
(90, 5, 'TKJ', 'Memastikan semua perangkat jaringan terhubung ke sistem grounding yang baik bertujuan untuk...', 'Memperindah tampilan', 'Melindungi peralatan dari lonjakan listrik', 'Meningkatkan kecepatan jaringan', 'Mempermudah pengujian LAN Tester', 1),
(111, 1, 'RPL', 'Apa pengertian algoritma menurut materi?', 'Perintah acak pada komputer', 'Langkah-langkah terurut untuk menyelesaikan masalah', 'Format penyimpanan data', 'Bahasa tingkat tinggi', 1),
(112, 1, 'RPL', 'Contoh algoritma membuat kopi yang benar adalah?', 'Tuangkan air panas lalu masukkan gula dulu', 'Panaskan air → masukkan kopi → tambahkan gula → tuang air panas → aduk', 'Masukkan kopi terakhir setelah diaduk', 'Tambahkan garam sebelum kopi', 1),
(113, 1, 'RPL', 'Flowchart berfungsi untuk?', 'Menghapus kode error otomatis', 'Menggambar tampilan UI', 'Menampilkan alur proses secara visual', 'Mempercepat eksekusi program', 2),
(114, 1, 'RPL', 'Salah satu alasan flowchart penting adalah?', 'Membuat program berjalan lebih lambat', 'Menghilangkan kebutuhan algoritma', 'Mempermudah memahami alur logika program', 'Mengubah kode menjadi gambar 3D', 2),
(115, 1, 'RPL', 'Percabangan digunakan untuk?', 'Mengulang perintah', 'Mengambil keputusan berdasarkan kondisi', 'Menyimpan data dalam jumlah banyak', 'Menghapus variabel', 1),
(116, 1, 'RPL', 'Berikut merupakan operator perbandingan:', '-', '+', '>', '*', 2),
(117, 1, 'RPL', 'Percabangan if/else digunakan ketika?', 'Tidak ada kondisi yang diperiksa', 'Hanya ada satu kemungkinan hasil', 'Ada dua kemungkinan hasil', 'Program hanya dijalankan sekali', 2),
(118, 1, 'RPL', 'Jika kode nilai >= 75 menghasilkan \"Lulus\", artinya?', 'Program sedang error', 'Kondisi terpenuhi', 'Array penuh', 'Looping berhenti', 1),
(119, 1, 'RPL', 'Perulangan digunakan untuk?', 'Mengulang proses berkali-kali tanpa tulis kode berulang', 'Menghapus isi variabel', 'Membuat cabang keputusan', 'Mengubah tipe data', 0),
(120, 1, 'RPL', 'Perulangan for cocok digunakan ketika?', 'Jumlah perulangan tidak diketahui', 'Digunakan untuk percabangan', 'Jumlah perulangan sudah ditentukan', 'Digunakan untuk menyimpan data', 2),
(121, 1, 'RPL', 'Apa yang terjadi jika while tidak memiliki increment/decrement?', 'Perulangan langsung berhenti', 'Perulangan hanya berjalan 1 kali', 'Terjadi infinite loop', 'Variabel otomatis dihapus', 2),
(122, 1, 'RPL', 'Apa itu array?', 'Variabel yang menyimpan banyak nilai', 'Fungsi khusus pada JavaScript', 'Perintah untuk membuat loop', 'Bagian dari flowchart', 0),
(123, 1, 'RPL', 'Index array selalu dimulai dari?', '1', '2', '0', '3', 2),
(124, 1, 'RPL', 'Fungsi .push() digunakan untuk?', 'Menambah data di belakang array', 'Menghapus data pertama', 'Menambah data di depan', 'Mengubah index array', 0),
(125, 1, 'RPL', 'Mengakses array buah[0] berarti?', 'Mengambil item pertama', 'Menghapus elemen tersebut', 'Mengubah seluruh array', 'Menambah elemen baru', 0),
(126, 1, 'RPL', 'Apa itu function dalam pemrograman?', 'Tempat menyimpan file gambar', 'Blok kode untuk tugas tertentu yang bisa dipanggil ulang', 'Perintah untuk membuat tabel', 'Fitur untuk menambah array', 1),
(127, 1, 'RPL', 'Mengapa fungsi penting?', 'Membuat kode lebih rapi dan tidak berulang (DRY)', 'Menambah error', 'Menghilangkan logika program', 'Memperbesar ukuran aplikasi', 0),
(128, 1, 'RPL', 'Apa itu function dengan parameter?', 'Fungsi yang hanya bisa dijalankan sekali', 'Fungsi yang menerima input untuk diolah', 'Fungsi yang tidak punya output', 'Fungsi untuk membuat variabel baru', 1),
(129, 1, 'RPL', 'Logika pemrograman adalah?', 'Cara berpikir jelas, runtut, tidak ambigu', 'Bahasa pemrograman baru', 'Perintah untuk membuat UI', 'Cara memformat database', 0),
(130, 1, 'RPL', 'Langkah pertama dalam problem solving adalah?', 'Menulis kode langsung', 'Memahami masalah: input, proses, output', 'Membuat database dulu', 'Menggambar UI aplikasi', 1),
(131, 2, 'RPL', 'Dalam pemrograman, wadah untuk menyimpan data yang nilainya dapat berubah selama program berjalan disebut?', 'Konstanta', 'Tipe Data', 'Variabel', 'Operator', 2),
(132, 2, 'RPL', 'Tipe data yang paling tepat untuk menyimpan nilai Indeks Prestasi Kumulatif (IPK) siswa (misalnya: 3.85) adalah?', 'Integer', 'String', 'Boolean', 'Float/Double', 3),
(133, 2, 'RPL', 'Dalam bahasa pemrograman, penamaan variabel yang TIDAK diperbolehkan (melanggar aturan umum) adalah?', 'nama_lengkap', 'nilaiAkhir', '1_data', '_saldo', 2),
(134, 2, 'RPL', 'Apa hasil dari operasi aritmatika 15 % 4 (modulus) dalam pemrograman?', '3', '3.75', '4', '0', 0),
(135, 2, 'RPL', 'Operator penugasan gabungan a += 5; memiliki arti yang sama dengan?', 'a = a - 5;', 'a = a * 5;', 'a = a + 5;', 'a = a / 5;', 2),
(136, 2, 'RPL', 'Dalam operator perbandingan, manakah yang berfungsi untuk memeriksa apakah Dua Nilai Sama dengan Tepat?', '!=', '>=', '==', '=', 2),
(137, 2, 'RPL', 'Jika kondisiA = true dan kondisiB = false, maka hasil dari operasi logika kondisiA && kondisiB adalah?', 'true', 'false', '0', '1', 1),
(138, 2, 'RPL', 'Apa fungsi utama dari operator ++ (increment) dalam perulangan?', 'Menambahkan nilai variabel sebanyak 2', 'Menurunkan nilai variabel sebanyak 1', 'Menggabungkan dua variabel string', 'Menaikkan nilai variabel sebanyak 1', 3),
(139, 2, 'RPL', 'Proses di mana program mengambil data dari pengguna, seperti nama atau input angka, disebut?', 'Output', 'Variabel', 'Input', 'Konkatenasi', 2),
(140, 2, 'RPL', 'Fungsi seperti `print()` di Python atau `System.out.println()` di Java digunakan untuk proses?', 'Pemrosesan', 'Input', 'Kompilasi', 'Output', 3),
(141, 2, 'RPL', '11. Konsep yang menjelaskan bahwa nama, Nama, dan NAMA dianggap sebagai variabel yang berbeda adalah?', 'Dynamic Typing', 'Case-Sensitive', 'Type Casting', 'Garbage Collection', 1),
(142, 2, 'RPL', '12. Tipe data Boolean digunakan khusus untuk menyimpan nilai?', 'Angka bulat dan desimal', 'Teks atau kalimat', 'True (benar) atau False (salah)', 'Satu karakter saja', 2),
(143, 2, 'RPL', '13. Struktur data sederhana yang digunakan untuk menyimpan kumpulan nilai sejenis dalam satu nama variabel adalah?', 'Object', 'Array', 'Boolean', 'Variabel Tunggal', 1),
(144, 2, 'RPL', 'Dalam banyak bahasa pemrograman, operator + pada tipe data string berfungsi sebagai?', 'Penjumlahan', 'Perbandingan', 'Pembagian', 'Konkatenasi (penggabungan teks)', 3),
(145, 2, 'RPL', 'Jenis kesalahan yang terjadi karena salah ketik (misal: lupa titik koma atau salah kurung) dan menyebabkan program gagal berjalan adalah?', 'Logical Error', 'Runtime Error', 'Syntax Error', 'Semantic Error', 2),
(146, 2, 'RPL', 'Logical Error adalah jenis kesalahan yang paling sulit dideteksi karena?', 'Program tidak berjalan sama sekali', 'Program berjalan, tetapi memberikan hasil yang salah', 'Program crash mendadak saat dijalankan', 'Komputer tidak memiliki cukup memori', 1),
(147, 2, 'RPL', 'Dalam Error Handling, teknik apa yang digunakan untuk menjaga program tetap berjalan meskipun terjadi pembagian dengan nol?', 'Debugging', 'Refactoring', 'Exception/Runtime Handling', 'Syntax Correction', 2),
(148, 2, 'RPL', 'Struktur data yang menyimpan informasi dalam pasangan Key-Value (seperti nama: \"Hilmiy\", umur: 18) adalah?', 'Array', 'List', 'Object/Dictionary', 'Tuple', 2),
(149, 2, 'RPL', 'Apa yang terjadi jika suatu perulangan (seperti `while` loop) tidak memiliki increment/decrement yang tepat?', 'Terjadi Logical Error', 'Terjadi Syntax Error', 'Terjadi *Infinite Loop* (program tidak berhenti)', 'Program langsung selesai berjalan', 2),
(150, 2, 'RPL', 'Bagian dari program yang bertugas menampilkan hasil (Output) perhitungan ke layar pengguna adalah?', 'Variabel', 'Logika Bisnis', 'Antarmuka Pengguna (User Interface)', 'Algoritma', 2),
(151, 3, 'RPL', 'Proses pembuatan sebuah website agar bisa tampil di browser dan dapat digunakan oleh pengguna disebut?', 'Pemrograman Desktop', 'Pemrograman Web', 'Pemrograman Jaringan', 'Pemrograman Server', 1),
(152, 3, 'RPL', 'Bagian dari website yang bertugas mengatur logika, penyimpanan data ke database, serta keamanan (Server-side) disebut?', 'Frontend', 'Interface', 'Client-side', 'Backend', 3),
(153, 3, 'RPL', 'Bahasa pemrograman yang digunakan untuk membuat struktur dasar (rangka) sebuah halaman website adalah?', 'CSS', 'JavaScript', 'HTML', 'PHP', 2),
(154, 3, 'RPL', 'Elemen HTML manakah yang digunakan untuk menampilkan sebuah gambar pada halaman web?', '<p>', '<img>', '<href>', '<h1>', 1),
(155, 3, 'RPL', 'Dalam struktur dasar HTML, konten yang terlihat langsung oleh pengguna harus diletakkan di dalam tag?', '<head>', '<title>', '<body>', '<script>', 2),
(156, 3, 'RPL', 'Bahasa yang digunakan untuk mengatur tampilan, warna, layout, dan desain website agar terlihat menarik adalah?', 'HTML', 'JavaScript', 'SQL', 'CSS', 3),
(157, 3, 'RPL', 'Format dasar penulisan CSS adalah?', 'tag(property: value;)', 'selector { property: value; }', 'function.value = property', 'property: value;', 1),
(158, 3, 'RPL', 'Konsep di CSS bahwa setiap elemen dianggap sebagai kotak yang memiliki margin, border, dan padding disebut?', 'Grid System', 'Flexbox', 'Box Model', 'Responsive Design', 2),
(159, 3, 'RPL', 'Bahasa pemrograman yang bertanggung jawab untuk membuat website menjadi interaktif, dinamis, dan merespons klik tombol adalah?', 'HTML', 'CSS', 'JavaScript', 'Node.js', 2),
(160, 3, 'RPL', 'Fungsi utama dari JavaScript di sisi frontend adalah?', 'Menghubungkan ke database MySQL', 'Memvalidasi form input dan membuat animasi', 'Mengatur warna dan jenis font', 'Membuat struktur dasar dokumen web', 1),
(161, 3, 'RPL', 'Untuk menghubungkan file JavaScript eksternal ke dalam HTML, tag yang digunakan adalah?', '<link rel=\"stylesheet\">', '<script src=\"file.js\">', '<js>', '<external-script>', 1),
(162, 3, 'RPL', 'Konsep yang membuat website tampil baik dan menyesuaikan diri di berbagai ukuran layar (HP, tablet, laptop) disebut?', 'Static Layout', 'Responsive Web Design', 'Fixed Design', 'Legacy Design', 1),
(163, 3, 'RPL', 'Manakah di antara bahasa berikut yang umumnya digunakan di sisi Backend untuk mengelola logika dan database?', 'HTML', 'CSS', 'JavaScript (Client-side)', 'PHP/Node.js', 3),
(164, 3, 'RPL', 'Apa yang dihasilkan oleh kombinasi HTML, CSS, dan JavaScript?', 'Database yang kompleks', 'Website yang fungsional', 'Algoritma server', 'Aplikasi Desktop', 1),
(165, 3, 'RPL', 'Dalam konteks CSS, istilah Selector berfungsi untuk?', 'Menyimpan nilai variabel', 'Memilih elemen HTML yang ingin didesain', 'Menjalankan fungsi JavaScript', 'Menghitung ukuran layar', 1),
(166, 3, 'RPL', 'Tag HTML `<a href=\"...\">` berfungsi untuk?', 'Membuat paragraf', 'Membuat daftar tak berurutan', 'Membuat link/tautan', 'Membuat judul utama', 2),
(167, 3, 'RPL', 'Alat CSS modern yang paling cocok digunakan untuk membuat layout kompleks dua dimensi (baris dan kolom, contoh: dashboard) adalah?', 'Flexbox', 'Box Model', 'Grid', 'Float', 2),
(168, 3, 'RPL', 'Dalam Pemrograman Web, Frontend juga sering disebut sebagai?', 'Server-side', 'Database-side', 'Client-side', 'Logic-side', 2),
(169, 3, 'RPL', 'Apa yang diatur oleh tag HTML Semantik seperti `<header>`, `<footer>`, dan `<nav>`?', 'Tampilan warna dan font', 'Pembagian halaman yang jelas dan terstruktur', 'Logika interaksi pengguna', 'Koneksi ke database', 1),
(170, 3, 'RPL', 'Sistem manajemen database yang umum digunakan bersamaan dengan Pemrograman Web adalah?', 'Microsoft Word', 'MySQL', 'Adobe Photoshop', 'Operating System', 1),
(171, 4, 'RPL', 'Tempat menyimpan data secara terstruktur yang memungkinkan data dikelola, dicari, dan diperbarui dengan mudah disebut?', 'Pemrograman Server', 'Database', 'File System', 'Server Cache', 1),
(172, 4, 'RPL', 'Komponen utama database yang berfungsi sebagai kolom unik untuk membedakan setiap record dalam sebuah tabel adalah?', 'Foreign Key', 'Attribute', 'Primary Key', 'Relationship', 2),
(173, 4, 'RPL', 'Jenis database yang menyimpan data dalam tabel dan sangat mendukung adanya hubungan antar data (relasi) adalah?', 'NoSQL', 'Flat File Database', 'Relasional (RDBMS)', 'Key-Value Database', 2),
(174, 4, 'RPL', 'Diagram yang digunakan untuk memodelkan hubungan antar entitas (data) dalam sebuah sistem sebelum membuat tabel disebut?', 'Flowchart', 'UML Diagram', 'ERD (Entity Relationship Diagram)', 'DFD (Data Flow Diagram)', 2),
(175, 4, 'RPL', 'Manakah jenis kardinalitas yang paling umum, di mana satu record di tabel A dapat berhubungan dengan banyak record di tabel B?', 'Many-to-Many (M:N)', 'One-to-One (1:1)', 'Many-to-One (N:1)', 'One-to-Many (1:N)', 3),
(176, 4, 'RPL', 'Apa kepanjangan dari SQL?', 'Simple Query Language', 'Structured Query Logic', 'Standard Query Line', 'Structured Query Language', 3),
(177, 4, 'RPL', 'Perintah SQL yang digunakan untuk menambah record (data) baru ke dalam tabel adalah?', 'UPDATE', 'SELECT', 'INSERT INTO', 'CREATE TABLE', 2),
(178, 4, 'RPL', 'Perintah SQL yang digunakan untuk mengambil atau menampilkan data dari tabel adalah?', 'READ', 'SHOW', 'SELECT', 'FETCH', 2),
(179, 4, 'RPL', 'Klausa yang wajib digunakan pada perintah UPDATE dan DELETE agar perubahan/penghapusan data tidak berlaku pada semua record adalah?', 'ORDER BY', 'GROUP BY', 'JOIN', 'WHERE', 3),
(180, 4, 'RPL', 'Tipe hubungan relasi yang terjadi antara tabel Kelas dan tabel Siswa (Satu Kelas memiliki Banyak Siswa) adalah?', '1:1', '1:N', 'N:N', '0:1', 1),
(181, 4, 'RPL', 'Kolom di tabel kedua (Banyak) yang merujuk pada Primary Key (PK) di tabel pertama (Satu) untuk membuat relasi One-to-Many disebut?', 'Unique Key', 'Composite Key', 'Foreign Key (FK)', 'Candidate Key', 2),
(182, 4, 'RPL', 'Objek nyata yang datanya ingin disimpan dalam database (misalnya: Mahasiswa, Produk, Transaksi) digambarkan sebagai apa dalam ERD?', 'Attribute', 'Relationship', 'Primary Key', 'Entity', 3),
(183, 4, 'RPL', 'Perintah SQL manakah yang termasuk kategori DML (Data Manipulation Language)?', 'CREATE DATABASE', 'GRANT', 'SELECT', 'DROP TABLE', 2),
(184, 4, 'RPL', 'Sistem Manajemen Basis Data Relasional yang paling populer, open source, dan sering digunakan bersama PHP adalah?', 'MongoDB', 'PostgreSQL', 'Oracle', 'MySQL/MariaDB', 3),
(185, 4, 'RPL', 'Apa fungsi utama dari Primary Key (PK) dalam tabel relasional?', 'Memastikan data bisa bernilai NULL', 'Mengizinkan data duplikat', 'Mengurutkan data berdasarkan abjad', 'Mengidentifikasi setiap baris data secara unik', 3),
(186, 4, 'RPL', 'Database Non-relasional (NoSQL) seperti MongoDB lebih cocok digunakan untuk jenis data yang memiliki struktur?', 'Kaku dan teratur', 'Sangat terstruktur dan berelasi', 'Fleksibel dan sering berubah', 'Hanya berupa teks saja', 2),
(187, 4, 'RPL', 'Jika Anda ingin mengubah nama seorang siswa di tabel `siswa`, perintah SQL yang harus digunakan adalah?', 'SELECT * FROM siswa;', 'INSERT INTO siswa ...', 'UPDATE siswa SET ... WHERE ...', 'DELETE FROM siswa ...', 2),
(188, 4, 'RPL', 'Komponen database yang diibaratkan sebagai satu folder atau satu data lengkap dalam lemari arsip digital adalah?', 'Kolom/Field', 'Tabel', 'Baris/Record', 'Database Engine', 2),
(189, 4, 'RPL', 'Apa manfaat utama dari penggunaan ERD sebelum memulai implementasi database?', 'Menguji kecepatan server', 'Mengurangi kesalahan logika pada kode aplikasi', 'Merancang struktur database agar terintegrasi dengan baik', 'Memastikan tampilan antarmuka pengguna menarik', 2),
(190, 4, 'RPL', 'Sistem manajemen basis data MariaDB dikembangkan sebagai fork (versi lanjutan) dari?', 'PostgreSQL', 'Microsoft SQL Server', 'MySQL', 'SQLite', 2),
(191, 5, 'RPL', 'Bagian dari website yang mengatur semua logika bisnis, penyimpanan data, dan interaksi dengan database disebut?', 'Frontend', 'Client-side', 'Backend', 'User Interface', 2),
(192, 5, 'RPL', 'Menggunakan PHP murni tanpa bantuan kerangka kerja (framework) sering disebut sebagai?', 'PHP Framework', 'PHP OOP', 'PHP CLI', 'PHP Native', 3),
(193, 5, 'RPL', 'Salah satu keuntungan utama menggunakan PHP Framework seperti Laravel atau CodeIgniter dibandingkan PHP Native adalah?', 'Membuat kode lebih panjang', 'Meningkatkan keamanan bawaan (misalnya proteksi SQL Injection)', 'Memerlukan spesifikasi server yang lebih rendah', 'Menghilangkan kebutuhan akan database', 1),
(194, 5, 'RPL', 'Singkatan CRUD dalam pengelolaan data database adalah?', 'Connect, Run, Upload, Download', 'Client, Resource, Update, Delete', 'Create, Read, Update, Delete', 'Code, Rule, Update, Develop', 2),
(195, 5, 'RPL', 'Perintah SQL manakah yang harus dilakukan dalam proses Read (R) pada siklus CRUD?', 'INSERT INTO', 'UPDATE', 'SELECT', 'DELETE FROM', 2),
(196, 5, 'RPL', 'Mekanisme PHP yang digunakan untuk menyimpan data sementara di sisi server tentang status pengguna yang sedang aktif (misalnya status login) disebut?', 'Cookie', 'Cache', 'Local Storage', 'Session', 3),
(197, 5, 'RPL', 'Untuk memulai atau melanjutkan mekanisme penyimpanan data sementara pengguna di server pada PHP Native, fungsi apa yang wajib dipanggil di awal skrip?', 'start_server()', '$_POST[]', 'session_start()', 'cookie_set()', 2),
(198, 5, 'RPL', 'Framework PHP modern yang berbasis MVC, kaya fitur, dan memiliki Eloquent ORM sebagai fitur unggulannya adalah?', 'CodeIgniter', 'Express.js', 'Laravel', 'Spring', 2),
(199, 5, 'RPL', 'Apa yang menjadi keunggulan utama dari framework CodeIgniter yang membuatnya cocok untuk pemula dan proyek sederhana?', 'Fitur yang paling kompleks', 'Ringan dan mudah dipelajari', 'Hanya mendukung database NoSQL', 'Hanya bisa berjalan di server Linux', 1),
(200, 5, 'RPL', 'REST API adalah cara aplikasi saling berkomunikasi melalui internet. Data yang umum digunakan dalam komunikasi ini adalah?', 'HTML Tag', 'XML atau JSON', 'CSS Styles', 'PDF File', 1),
(201, 5, 'RPL', 'Dalam REST API, HTTP Method yang digunakan untuk mengambil data dari resource (Read) adalah?', 'POST', 'PUT', 'GET', 'PATCH', 2),
(202, 5, 'RPL', 'Dalam REST API, HTTP Method yang digunakan untuk menambah data baru ke resource (Create) adalah?', 'GET', 'POST', 'DELETE', 'UPDATE', 1),
(203, 5, 'RPL', 'Proses memastikan identitas pengguna (melalui login) sebelum diberikan akses ke sistem disebut?', 'Routing', 'Validasi', 'Autentikasi', 'Authorization', 2),
(204, 5, 'RPL', 'Pada contoh kode koneksi PHP Native, fungsi manakah yang digunakan untuk membuat koneksi ke database MySQL?', 'connect_db()', 'mysqli_query()', 'mysqli_connect()', 'die()', 2),
(205, 5, 'RPL', 'Jika seorang user belum login, variabel PHP manakah yang digunakan untuk mengecek keberadaan status login user?', '$_GET[]', '$_POST[]', '$_SESSION[]', '$_COOKIE[]', 2),
(206, 5, 'RPL', 'Saat terjadi koneksi gagal ke database, fungsi PHP manakah yang akan menampilkan pesan kesalahan dan menghentikan eksekusi skrip?', 'header()', 'exit()', 'echo', 'die()', 3),
(207, 5, 'RPL', 'Dalam konteks CRUD, ketika pengguna mengirimkan form input data baru, metode HTTP yang umum digunakan untuk mengirim data ke server adalah?', 'GET', 'HEAD', 'POST', 'PUT', 2),
(208, 5, 'RPL', 'Jika Anda ingin menghapus sesi login seorang pengguna (logout) di PHP, fungsi yang paling tepat untuk menghapus semua data sesi adalah?', 'session_destroy()', 'unset($_SESSION)', 'session_unset()', 'session_stop()', 0),
(209, 5, 'RPL', 'Apa tujuan utama penggunaan Blade di Laravel atau Template Engine sejenisnya?', 'Mempercepat koneksi ke database', 'Memisahkan tampilan (HTML) dari logika (PHP)', 'Menggantikan JavaScript sepenuhnya', 'Mengatur keamanan jaringan', 1),
(210, 5, 'RPL', 'Apa yang diatur oleh Routing dalam Framework PHP?', 'Koneksi ke database', 'Penentuan fungsi atau controller mana yang akan memproses URL tertentu', 'Pengaturan warna dan layout website', 'Validasi input form pengguna', 1),
(211, 1, 'Multimedia', 'Seni dan praktik mengomunikasikan ide atau informasi secara visual melalui kombinasi teks, gambar, dan elemen visual lainnya disebut?', 'Fotografi Digital', 'Ilustrasi', 'Desain Grafis', 'Animasi', 2),
(212, 1, 'Multimedia', 'Prinsip desain yang berfokus pada distribusi visual elemen agar terlihat stabil dan tidak berat sebelah, baik secara simetris maupun asimetris, adalah?', 'Kontras', 'Proporsi', 'Keseimbangan (Balance)', 'Ritme', 2),
(213, 1, 'Multimedia', 'Menciptakan perbedaan yang menonjol antar elemen, seperti warna terang vs gelap atau teks tebal vs tipis, untuk menarik perhatian disebut prinsip?', 'Kesatuan', 'Keseimbangan', 'Kontras (Contrast)', 'Proporsi', 2),
(214, 1, 'Multimedia', 'Pengulangan elemen visual (pola, garis, atau warna) untuk menciptakan aliran yang menyenangkan mata dan memberikan rasa konsistensi disebut prinsip?', 'Proporsi', 'Ritme (Rhythm)', 'Kesatuan', 'Fokus', 1),
(215, 1, 'Multimedia', 'Memastikan semua elemen desain terlihat sebagai satu kesatuan yang harmonis dan profesional (konsisten warna dan gaya) disebut prinsip?', 'Proporsi', 'Kontras', 'Kesatuan (Unity)', 'Keseimbangan', 2),
(216, 1, 'Multimedia', 'Warna yang tidak bisa dibuat dari pencampuran warna lain, yaitu Merah, Biru, dan Kuning, dikenal sebagai?', 'Warna Sekunder', 'Warna Tersier', 'Warna Komplementer', 'Warna Primer', 3),
(217, 1, 'Multimedia', 'Warna yang letaknya berlawanan pada roda warna dan menciptakan kontras yang sangat kuat (misalnya Merah $leftrightarrow$ Hijau) disebut?', 'Warna Analog', 'Warna Primer', 'Warna Komplementer', 'Warna Monokromatik', 2),
(218, 1, 'Multimedia', 'Kombinasi tiga warna yang berdekatan di roda warna (misalnya Biru, Biru-Hijau, Hijau) untuk memberikan kesan harmonis dan lembut disebut?', 'Warna Komplementer', 'Warna Triadik', 'Warna Analog', 'Warna Sekunder', 2),
(219, 1, 'Multimedia', 'Seni dan teknik mengatur teks agar mudah dibaca, menarik, dan sesuai dengan pesan yang ingin disampaikan disebut?', 'Kaligrafi', 'Layouting', 'Tipografi', 'Branding', 2),
(220, 1, 'Multimedia', 'Jenis font yang memiliki garis kecil di ujung huruf (seperti Times New Roman) dan memberikan kesan klasik dan formal adalah?', 'Sans Serif', 'Serif', 'Script', 'Display', 1),
(221, 1, 'Multimedia', 'Jenis font yang tanpa garis kecil di ujung huruf (seperti Arial) dan memberikan kesan modern dan bersih adalah?', 'Serif', 'Sans Serif', 'Script', 'Handwriting', 1),
(222, 1, 'Multimedia', 'Jarak antar baris teks dalam pengaturan tipografi disebut?', 'Kerning', 'Tracking', 'Leading (Line Height)', 'Font Size', 2),
(223, 1, 'Multimedia', 'Jarak antar huruf dalam satu kata pada pengaturan tipografi disebut?', 'Tracking', 'Leading', 'Kerning', 'Line Height', 2),
(224, 1, 'Multimedia', 'Software desain yang fungsi utamanya adalah mengedit dan memanipulasi gambar berbasis raster (pixel), cocok untuk retouching foto, adalah?', 'Adobe Illustrator', 'CorelDRAW', 'Adobe InDesign', 'Adobe Photoshop', 3),
(225, 1, 'Multimedia', 'Software desain yang paling tepat digunakan untuk membuat Logo dan Ilustrasi Vektor karena dapat diubah ukurannya tanpa kehilangan kualitas adalah?', 'Adobe Photoshop', 'Adobe Illustrator / CorelDRAW', 'Adobe Premier', 'Blender', 1),
(226, 1, 'Multimedia', 'Prinsip desain yang mengatur perbandingan ukuran antar elemen untuk menciptakan hierarki visual, membantu pembaca tahu mana yang penting, adalah?', 'Keseimbangan', 'Kesatuan', 'Proporsi (Proportion)', 'Kontras', 2),
(227, 1, 'Multimedia', 'Warna yang merupakan hasil pencampuran dua warna primer (contoh: Oranye, Hijau, Ungu) disebut?', 'Warna Analog', 'Warna Primer', 'Warna Komplementer', 'Warna Sekunder', 3),
(228, 1, 'Multimedia', 'Ketika elemen-elemen desain di sebelah kiri dan kanan memiliki bobot visual yang sama persis, jenis keseimbangan apa yang digunakan?', 'Asimetris', 'Radial', 'Simetris', 'Proporsional', 2),
(229, 1, 'Multimedia', 'Dalam proses desain poster, kontras yang efektif paling baik diterapkan antara?', 'Warna font dan ukuran font yang sama', 'Background putih dan teks kuning muda', 'Warna latar belakang dan warna teks utama', 'Dua warna analog yang berdekatan', 2),
(230, 1, 'Multimedia', 'Sistem pengeditan gambar berbasis pixel yang membuat kualitas gambar pecah ketika diperbesar adalah ciri khas dari software?', 'Vector Graphics', 'Drawing App', 'Raster Graphics', 'CAD Software', 2),
(231, 2, 'Multimedia', 'Teknik komposisi yang menempatkan objek penting di garis atau titik pertemuan dari pembagian frame 3x3 disebut?', 'Leading Lines', 'Framing', 'Rule of Thirds', 'Golden Ratio', 2),
(232, 2, 'Multimedia', 'Penggunaan garis alami (misalnya jalan, sungai, pagar) dalam foto yang bertujuan untuk mengarahkan mata penonton ke fokus utama disebut?', 'Framing', 'High Angle', 'Leading Lines', 'Backlight', 2),
(233, 2, 'Multimedia', 'Sudut pengambilan gambar dari atas objek yang membuat objek terlihat lebih kecil atau lemah disebut?', 'Low Angle', 'Eye Level', 'High Angle', 'Worm Eye View', 2),
(234, 2, 'Multimedia', 'Pencahayaan yang datang dari belakang objek, sering digunakan untuk menghasilkan siluet yang dramatis, disebut?', 'Natural Light', 'Artificial Light', 'Front Light', 'Backlight', 3),
(235, 2, 'Multimedia', 'Format file gambar berbasis pixel yang memiliki ukuran file kecil, cocok untuk foto realistis, namun tidak mendukung transparansi dan bersifat lossy adalah?', 'PNG', 'GIF', 'JPG/JPEG', 'SVG', 2),
(236, 2, 'Multimedia', 'Format file gambar berbasis pixel yang paling cocok digunakan untuk grafis web karena mendukung transparansi dan kualitas baik adalah?', 'JPG/JPEG', 'GIF', 'SVG', 'PNG', 3),
(237, 2, 'Multimedia', 'Format file gambar yang berbasis vektor sehingga bisa diperbesar tanpa kehilangan kualitas, cocok untuk logo dan ikon, adalah?', 'PNG', 'JPG', 'GIF', 'SVG', 3),
(238, 2, 'Multimedia', 'Teknik editing foto yang berfungsi untuk memperbaiki noda, jerawat, atau objek yang mengganggu pada detail foto disebut?', 'Masking', 'Cropping', 'Retouching', 'Color Grading', 2),
(239, 2, 'Multimedia', 'Proses memotong atau menyesuaikan ukuran foto untuk fokus pada objek utama dan memperbaiki komposisi disebut?', 'Masking', 'Retouching', 'Cropping', 'Color Correction', 2),
(240, 2, 'Multimedia', 'Dalam editing foto, proses penyesuaian warna, kontras, dan pencahayaan agar foto terlihat natural atau sesuai tema desain disebut?', 'Retouching', 'Color Correction', 'Masking', 'Framing', 1),
(241, 2, 'Multimedia', 'Tools seperti Clone Stamp Tool dan Healing Brush di Adobe Photoshop paling sering digunakan untuk teknik?', 'Color Correction', 'Masking', 'Retouching', 'Cropping', 2),
(242, 2, 'Multimedia', 'Teknik editing yang berfungsi untuk memilih atau menyembunyikan bagian tertentu dari foto agar bisa diedit secara terpisah dan bersifat non-destructive adalah?', 'Cropping', 'Masking', 'Retouching', 'Exposure', 1),
(243, 2, 'Multimedia', 'Dalam fotografi, sudut Eye Level (setara mata) umumnya menghasilkan kesan yang?', 'Kuat dan dominan', 'Melemahkan objek', 'Natural dan realistis', 'Dramatis dan misterius', 2),
(244, 2, 'Multimedia', 'Fotografi pada saat Golden Hour memanfaatkan jenis pencahayaan?', 'Artificial Light', 'Studio Flash', 'Natural Light', 'Fluorescent Light', 2),
(245, 2, 'Multimedia', 'Kekurangan utama dari format file GIF dibandingkan PNG adalah?', 'Tidak mendukung animasi', 'Tidak mendukung transparansi', 'Warna yang terbatas (hanya 256 warna)', 'Tidak berbasis pixel', 2),
(246, 2, 'Multimedia', 'Teknik komposisi Framing bertujuan untuk?', 'Membuat warna lebih cerah', 'Menggunakan elemen di sekitar objek untuk membingkai fokus utama', 'Memotong bagian tepi foto', 'Meningkatkan saturasi warna', 1),
(247, 2, 'Multimedia', 'Dalam koreksi warna, fungsi Levels atau Curves digunakan untuk mengatur?', 'Ukuran resolusi gambar', 'Teks dan font pada foto', 'Kontras dan kecerahan (tone) warna', 'Mendeteksi objek bergerak', 2),
(248, 2, 'Multimedia', 'Jika Anda ingin membuat objek terlihat kuat, dominan, dan besar, sudut pengambilan gambar yang paling tepat adalah?', 'Eye Level', 'Bird Eye View', 'High Angle', 'Low Angle', 3),
(249, 2, 'Multimedia', 'Foto yang memiliki masalah pada gelap/terang, di mana detail area bayangan atau highlight hilang, perlu dilakukan perbaikan menggunakan teknik?', 'Retouching', 'Cropping', 'Color Correction', 'Masking', 2),
(250, 2, 'Multimedia', 'Meskipun ukuran file-nya kecil, kualitas format JPG/JPEG cenderung menurun setiap kali file disimpan ulang. Sifat ini dikenal sebagai?', 'Lossless', 'Vector-based', 'Lossy', 'Immutable', 2),
(251, 3, 'Multimedia', 'Jumlah pixel dalam video yang memengaruhi kualitas gambar dan ketajaman disebut?', 'Frame Rate', 'Aspek Ratio', 'Resolusi Video', 'Bitrate', 2),
(252, 3, 'Multimedia', 'Resolusi video yang umumnya dikenal sebagai Full HD dengan ukuran pixel 1920 x 1080 px adalah?', '720p', '4K', '1080p', 'SD', 2),
(253, 3, 'Multimedia', 'Istilah yang menunjukkan jumlah frame atau gambar per detik. Nilai yang lebih tinggi membuat gerakan terlihat lebih halus adalah?', 'Bitrate', 'Shutter Speed', 'Frame Rate (FPS)', 'Aspect Ratio', 2),
(254, 3, 'Multimedia', 'Frame rate standar yang umumnya digunakan dalam video web, YouTube, atau TV, dengan gerakan yang cukup halus, adalah?', '12 fps', '60 fps', '24 fps', '30 fps', 3),
(255, 3, 'Multimedia', 'Format file video yang paling populer, memiliki kompatibilitas luas, dan ukuran file relatif kecil adalah?', 'MOV', 'AVI', 'MP4', 'WMV', 2),
(256, 3, 'Multimedia', 'Proses dalam editing video yang bertujuan untuk menghapus bagian yang tidak perlu agar video lebih ringkas dan fokus disebut?', 'Transisi', 'Color Grading', 'Cutting (Pemotongan)', 'Masking', 2),
(257, 3, 'Multimedia', 'Teknik yang digunakan untuk menghubungkan dua klip video agar perpindahan terlihat lebih halus (contoh: Fade atau Dissolve) adalah?', 'Cutting', 'Transisi', 'Keyframe', 'Render', 1),
(258, 3, 'Multimedia', 'Software editing video profesional berbasis timeline yang sangat populer, cocok untuk memotong, menyusun klip, dan menyunting audio/warna, adalah?', 'Adobe After Effects', 'Adobe Illustrator', 'Adobe Premiere Pro', 'Blender', 2),
(259, 3, 'Multimedia', 'Software yang fungsi utamanya adalah membuat animasi 2D, motion graphics, dan efek visual yang kompleks (VFX) adalah?', 'Adobe Premiere Pro', 'Adobe After Effects', 'CorelDRAW', 'Blender', 1),
(260, 3, 'Multimedia', 'Software animasi dan rendering 3D yang dikenal bersifat gratis dan open-source adalah?', 'Adobe Premiere Pro', 'Adobe After Effects', 'Maya', 'Blender', 3),
(261, 3, 'Multimedia', 'Titik penting yang menentukan posisi, ukuran, atau properti objek pada waktu tertentu, menandai awal dan akhir sebuah gerakan animasi, disebut?', 'Timeline', 'Frame Rate', 'Keyframe', 'Render Point', 2),
(262, 3, 'Multimedia', 'Garis waktu yang menampilkan urutan frame dan durasi animasi, digunakan untuk mengatur kapan objek muncul atau bergerak, disebut?', 'Keyframe', 'Timeline', 'Scrubbing', 'Sequence', 1),
(263, 3, 'Multimedia', 'Animasi yang menggabungkan grafik, teks, dan elemen visual untuk menyampaikan pesan secara dinamis (contoh: infografis bergerak) disebut?', 'Stop Motion', 'Motion Graphics', 'VFX', 'Sinematografi', 1),
(264, 3, 'Multimedia', 'Efek visual seperti slow motion, filter, atau animasi teks yang ditambahkan untuk memperkuat pesan video termasuk dalam teknik?', 'Cutting', 'Transisi', 'Efek Visual (VFX)', 'Perekaman Audio', 2),
(265, 3, 'Multimedia', 'Kecepatan frame rate standar yang menghasilkan gerakan paling halus, sering digunakan untuk game atau video olahraga, adalah?', '12 fps', '24 fps', '30 fps', '60 fps', 3),
(266, 3, 'Multimedia', 'Format file video MOV umumnya paling cocok untuk alur kerja editing di sistem operasi?', 'Windows', 'Linux', 'Mac (QuickTime)', 'Android', 2),
(267, 3, 'Multimedia', 'Apa yang menjadi fokus utama dalam proses Cutting pada timeline editing?', 'Menambahkan musik latar', 'Memperhalus pergerakan objek', 'Memastikan video ringkas dan memiliki alur cerita yang fokus', 'Mengubah resolusi video', 2),
(268, 3, 'Multimedia', 'Ketika sebuah video 4K diturunkan menjadi 1080p, yang terjadi adalah penurunan pada?', 'Durasi video', 'Kompatibilitas file', 'Jumlah pixel (Resolusi)', 'Frame Rate (FPS)', 2),
(269, 3, 'Multimedia', 'Keterbatasan utama format file AVI yang membuatnya jarang digunakan untuk streaming web adalah?', 'Tidak mendukung audio', 'Memiliki kualitas yang sangat rendah', 'Ukuran file yang cenderung besar', 'Hanya mendukung animasi 3D', 2),
(270, 3, 'Multimedia', 'Fitur Color Grading pada Adobe Premiere Pro digunakan untuk?', 'Membuat animasi Keyframe', 'Menyesuaikan warna dan mood visual keseluruhan video', 'Memotong klip video', 'Membuat Transisi', 1),
(271, 4, 'Multimedia', 'Suara yang direkam, disimpan, dan diputar melalui perangkat digital untuk menambah efek atau suasana pada media disebut?', 'Analog Signal', 'Radio Frequency', 'Audio Digital', 'Visual Effect', 2),
(272, 4, 'Multimedia', 'Format file audio yang paling populer dan memiliki kompatibilitas luas, namun bersifat lossy (kualitas menurun akibat kompresi), adalah?', 'WAV', 'AAC', 'MP3', 'FLAC', 2),
(273, 4, 'Multimedia', 'Format file audio yang bersifat lossless dan menghasilkan kualitas suara paling tinggi (mendekati asli), namun ukuran filenya sangat besar, adalah?', 'MP3', 'WAV', 'OGG', 'AAC', 1),
(274, 4, 'Multimedia', 'Proses menggabungkan berbagai track audio (musik, efek, narasi) menjadi satu kesatuan yang harmonis disebut?', 'Mastering', 'Leveling', 'Mixing (Pencampuran Audio)', 'Rendering', 2),
(275, 4, 'Multimedia', 'Tahap akhir dalam produksi audio untuk memperbaiki kualitas suara secara keseluruhan dan menyesuaikan volume akhir agar konsisten adalah?', 'Mixing', 'Equalizing', 'Mastering', 'Editing', 2),
(276, 4, 'Multimedia', 'Teknik yang dilakukan untuk memastikan Narasi (Dialog) terdengar lebih jelas daripada Musik Latar disebut?', 'Audio Effects', 'Mastering', 'Leveling (Pengaturan Volume)', 'Compressing', 2),
(277, 4, 'Multimedia', 'Menambahkan karakter atau nuansa pada suara (seperti Reverb, Echo, atau Equalizer) termasuk dalam teknik?', 'Mastering', 'Leveling', 'Audio Effects', 'Sampling', 2),
(278, 4, 'Multimedia', 'Software editing audio yang bersifat gratis dan open-source, cocok untuk pemula dalam merekam, memotong, dan efek sederhana, adalah?', 'Adobe Audition', 'Pro Tools', 'FL Studio', 'Audacity', 3);
INSERT INTO `bank_soal` (`id`, `materi_id`, `jurusan`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`) VALUES
(279, 4, 'Multimedia', 'Software editing audio yang berfungsi untuk mixing, mastering profesional, dan memiliki integrasi yang mudah dengan Adobe Premiere Pro adalah?', 'FL Studio', 'Audacity', 'Adobe Audition', 'Ableton Live', 2),
(280, 4, 'Multimedia', 'Software yang fungsi utamanya adalah Produksi Musik Digital (DAW), digunakan untuk membuat musik dari awal dengan beats dan instrumen virtual, adalah?', 'Audacity', 'Adobe Audition', 'FL Studio', 'Vegas Pro', 2),
(281, 4, 'Multimedia', 'Apa kelemahan utama format file audio MP3?', 'Tidak kompatibel dengan browser', 'Kualitas suara menurun karena kompresi (lossy)', 'Ukuran file yang sangat besar', 'Tidak mendukung stereo sound', 1),
(282, 4, 'Multimedia', 'Jika Anda membuat video yang memiliki dialog, tujuan utama pengaturan volume (leveling) adalah?', 'Membuat musik latar lebih dominan', 'Menyeimbangkan suara agar dialog tidak tertutup atau terganggu', 'Menurunkan volume efek suara hingga nol', 'Meningkatkan frekuensi bass', 1),
(283, 4, 'Multimedia', 'Equalizer (EQ) adalah efek suara yang digunakan untuk?', 'Menambah efek gema (Echo)', 'Mempercepat tempo musik', 'Mengatur keseimbangan frekuensi suara (bass, mid, treble)', 'Menghilangkan noise sepenuhnya', 2),
(284, 4, 'Multimedia', 'Format file audio yang kualitas suaranya lebih efisien daripada MP3, terutama digunakan pada produk Apple dan streaming, adalah?', 'WAV', 'FLAC', 'AAC', 'MIDI', 2),
(285, 4, 'Multimedia', 'Pencampuran Audio (Mixing) melibatkan penggabungan setidaknya berapa banyak track suara?', 'Hanya satu track', 'Minimal dua track atau lebih', 'Hanya dialog saja', 'Hanya efek suara saja', 1),
(286, 4, 'Multimedia', 'Jika Anda ingin merekam narasi (voice-over) untuk video Anda dengan perangkat lunak gratis, pilihan terbaik adalah?', 'Adobe Audition', 'FL Studio', 'Audacity', 'Pro Tools', 2),
(287, 4, 'Multimedia', 'Apa yang menjadi fokus utama dalam tahap Mastering?', 'Memotong klip audio', 'Memperbaiki kualitas audio di tengah proses editing', 'Mempersiapkan audio untuk distribusi akhir dengan volume yang konsisten', 'Menambah efek slow motion', 2),
(288, 4, 'Multimedia', 'Ketika suara latar terlalu keras dan menutupi dialog, masalah ini termasuk kegagalan dalam teknik?', 'Mastering', 'Audio Effects', 'Leveling/Mixing', 'Sampling', 2),
(289, 4, 'Multimedia', 'Penggunaan efek Reverb pada suara narasi bertujuan untuk memberikan nuansa?', 'Suara yang sangat kering dan dekat', 'Gema dan ruangan (misalnya seperti di aula)', 'Suara yang terpotong-potong', 'Suara yang terkompresi', 1),
(290, 4, 'Multimedia', 'Format Lossless seperti WAV dan FLAC tetap mempertahankan kualitas tinggi karena?', 'Hanya menyimpan suara frekuensi rendah', 'Tidak ada data suara yang dihilangkan selama proses kompresi', 'Mereka menggunakan kompresi MP3', 'Mereka hanya bisa diputar di perangkat profesional', 1),
(291, 5, 'Multimedia', 'Hak eksklusif yang dimiliki pencipta untuk mengontrol penggunaan karyanya (gambar, audio, video) disebut?', 'Royalty Fee', 'Hak Paten', 'Hak Merek', 'Hak Cipta', 3),
(292, 5, 'Multimedia', 'Aturan dasar yang harus diikuti ketika menggunakan karya digital orang lain adalah?', 'Boleh digunakan asalkan diunggah ke media sosial', 'Boleh digunakan tanpa meminta izin', 'Tidak boleh menggunakan karya tanpa izin atau lisensi yang sesuai', 'Boleh diubah sebagian dan digunakan untuk tujuan komersial', 2),
(293, 5, 'Multimedia', 'Jenis lisensi yang menyatakan bahwa Semua Hak Dilindungi, sehingga harus meminta izin tertulis untuk setiap penggunaan, adalah?', 'Creative Commons', 'Public Domain', 'All Rights Reserved', 'Royalty-Free', 2),
(294, 5, 'Multimedia', 'Karya yang sudah kadaluarsa masa hak ciptanya atau dilepas hak ciptanya oleh pencipta sehingga bebas digunakan tanpa batasan disebut?', 'Creative Commons', 'Public Domain (Bebas)', 'All Rights Reserved', 'CC BY-NC', 1),
(295, 5, 'Multimedia', 'Norma dan prinsip moral dalam pembuatan dan penggunaan karya yang bertujuan menghargai pencipta dan menghindari konflik disebut?', 'Atribusi', 'Hak Cipta', 'Etika Kreatif', 'Lisensi', 2),
(296, 5, 'Multimedia', 'Salah satu praktik Etika Kreatif yang paling penting saat menggunakan karya orang lain adalah?', 'Menjual kembali karya tersebut', 'Mengubahnya tanpa batas', 'Memberikan kredit (Atribusi) kepada pencipta', 'Mengakuinya sebagai karya sendiri', 2),
(297, 5, 'Multimedia', 'Lisensi Creative Commons (CC) yang memungkinkan penggunaan karya asalkan memberi atribusi (kredit) kepada pencipta adalah?', 'CC BY-NC', 'CC BY-SA', 'CC BY', 'CC ND', 2),
(298, 5, 'Multimedia', 'Lisensi Creative Commons (CC) yang mengizinkan penggunaan karya asalkan hanya untuk tujuan Non-Komersial dan harus disertai atribusi adalah?', 'CC SA', 'CC NC', 'CC BY-NC', 'CC ND', 2),
(299, 5, 'Multimedia', 'Lisensi Creative Commons dengan syarat Share Alike (SA) berarti?', 'Tidak boleh diubah sama sekali', 'Harus mendapatkan izin tertulis dari pencipta', 'Hasil turunan (adaptasi) harus menggunakan lisensi yang sama', 'Hanya boleh digunakan untuk tujuan pribadi', 2),
(300, 5, 'Multimedia', 'Karya yang bisa digunakan tanpa membayar royalti setiap kali digunakan (cukup dibayar di awal atau gratis) disebut?', 'Public Domain', 'Creative Commons', 'Royalty-Free Resources', 'All Rights Reserved', 2),
(301, 5, 'Multimedia', 'Apa konsekuensi utama jika seorang desainer multimedia terbukti melakukan penjiplakan (plagiat) karya orang lain?', 'Mendapat penghargaan dari komunitas', 'Mencegah konflik hukum', 'Kehilangan reputasi profesional dan potensi tuntutan hukum', 'Karyanya menjadi Public Domain', 2),
(302, 5, 'Multimedia', 'Jika Anda mengunduh musik dengan lisensi CC BY, hal yang wajib Anda lakukan agar legal adalah?', 'Menggunakannya untuk tujuan komersial', 'Memotong bagian awal dan akhir lagu', 'Mencantumkan nama pencipta (atribusi)', 'Mengubah lisensinya menjadi All Rights Reserved', 2),
(303, 5, 'Multimedia', 'Manakah yang termasuk Lisensi Creative Commons yang paling membatasi penggunaan (selain All Rights Reserved)?', 'CC BY', 'CC BY-SA', 'CC BY-NC-ND (Non-Komersial - No Derivatives)', 'Public Domain', 2),
(304, 5, 'Multimedia', 'Di manakah Anda paling mungkin menemukan karya yang menggunakan lisensi Public Domain?', 'Karya yang baru dirilis oleh studio besar', 'Karya seni yang sudah sangat tua (misalnya lukisan abad ke-19)', 'Gambar yang diambil dari Google Image Search tanpa filter', 'Konten di balik paywall (berbayar)', 1),
(305, 5, 'Multimedia', 'Apa yang harus dicek seorang desainer saat menggunakan stock photo dari situs Royalty-Free?', 'Apakah foto tersebut telah memenangkan penghargaan', 'Batasan spesifik lisensi penggunaan (misalnya, batasan penggunaan komersial atau cetak)', 'Ukuran file dalam kilobyte', 'Warna utama pada foto', 1),
(306, 5, 'Multimedia', 'Tujuan utama dari pemberian kredit (atribusi) dalam Etika Kreatif adalah?', 'Memperpanjang durasi video', 'Meningkatkan ukuran file', 'Menghormati hak pencipta dan memastikan transparansi', 'Menghilangkan semua Hak Cipta', 2),
(307, 5, 'Multimedia', 'Jika sebuah karya dilindungi penuh oleh All Rights Reserved, tindakan yang paling aman untuk menggunakannya adalah?', 'Menggunakannya secara langsung', 'Membuat versi yang mirip 90%', 'Mencari lisensi CC atau Public Domain sebagai alternatif', 'Mengirimkan surat permintaan izin tertulis kepada pemilik hak', 3),
(308, 5, 'Multimedia', 'Penyedia aset digital seperti musik, gambar, atau video yang mengenakan biaya hanya sekali di awal untuk penggunaan berulang dikenal sebagai penyedia?', 'Public Domain', 'Freemium', 'Royalty-Free', 'Subscription Based', 2),
(309, 5, 'Multimedia', 'Salah satu manfaat Etika Kreatif bagi seorang profesional multimedia adalah?', 'Memperoleh izin untuk melanggar Hak Cipta', 'Menjaga reputasi baik dan kredibilitas di industri', 'Membuat desain menjadi lebih mudah', 'Mengurangi kebutuhan software editing', 1),
(310, 5, 'Multimedia', 'Lisensi Creative Commons secara umum memberikan fleksibilitas kepada pengguna, asalkan pengguna mematuhi?', 'Aturan yang ditetapkan oleh pemerintah', 'Persyaratan yang ditetapkan oleh pencipta dalam lisensi CC tersebut', 'Standar format file (misalnya harus JPG)', 'Standar harga pasar', 1),
(311, 1, 'Akuntansi', 'Proses mencatat, mengklasifikasi, meringkas, dan melaporkan semua transaksi keuangan suatu perusahaan disebut?', 'Manajemen Keuangan', 'Audit', 'Akuntansi', 'Ekonomi', 2),
(312, 1, 'Akuntansi', 'Tahap dalam siklus akuntansi di mana setiap transaksi dimasukkan ke kelompok akun yang sesuai (Kas, Beban, Utang, dll.) adalah?', 'Mencatat (Recording)', 'Mengklasifikasi (Classifying)', 'Meringkas (Summarizing)', 'Melaporkan (Reporting)', 1),
(313, 1, 'Akuntansi', 'Fungsi akuntansi yang paling utama dalam menghasilkan Laporan Keuangan (Neraca dan Laba Rugi) adalah?', 'Alat Pengendalian', 'Alat Perencanaan', 'Alat Pelaporan (Reporting)', 'Alat Pencatatan', 2),
(314, 1, 'Akuntansi', 'Pihak eksternal yang paling berkepentingan menggunakan informasi akuntansi untuk menilai kemampuan perusahaan membayar pinjaman adalah?', 'Manajemen', 'Karyawan', 'Pemerintah', 'Bank/Kreditur', 3),
(315, 1, 'Akuntansi', 'Pihak internal yang menggunakan informasi akuntansi untuk perencanaan, pengendalian, dan pengambilan keputusan operasional adalah?', 'Investor', 'Kreditur', 'Manajemen', 'Auditor', 2),
(316, 1, 'Akuntansi', 'Bidang spesialisasi akuntansi yang berfokus pada pelaporan ke pihak eksternal dan menghasilkan Neraca serta Laporan Laba Rugi adalah?', 'Akuntansi Manajemen', 'Akuntansi Biaya', 'Akuntansi Keuangan (Financial Accounting)', 'Akuntansi Perpajakan', 2),
(317, 1, 'Akuntansi', 'Bidang akuntansi yang berfungsi menghitung biaya produksi, bahan baku, dan tenaga kerja untuk menentukan Harga Pokok Penjualan (HPP) adalah?', 'Akuntansi Keuangan', 'Akuntansi Manajemen', 'Akuntansi Biaya (Cost Accounting)', 'Akuntansi Perpajakan', 2),
(318, 1, 'Akuntansi', 'Tugas utama dari Auditing (Pemeriksaan) adalah?', 'Membuat anggaran tahunan perusahaan', 'Menghitung pajak yang harus dibayar', 'Memberikan informasi untuk keputusan internal', 'Memeriksa laporan keuangan untuk memastikan kebenaran dan kejujuran', 3),
(319, 1, 'Akuntansi', 'Jenis perusahaan yang kegiatannya hanya menjual layanan atau keahlian tanpa memiliki persediaan barang dagang adalah?', 'Perusahaan Dagang', 'Perusahaan Manufaktur', 'Perusahaan Jasa', 'Perusahaan Perseroan', 2),
(320, 1, 'Akuntansi', 'Jenis perusahaan yang memiliki tiga jenis persediaan (Bahan Baku, Dalam Proses, Barang Jadi) dan melakukan pengolahan produk adalah?', 'Perusahaan Jasa', 'Perusahaan Dagang', 'Perusahaan Manufaktur', 'Perusahaan Retail', 2),
(321, 1, 'Akuntansi', 'Bukti tertulis yang menjadi dasar pencatatan transaksi pembelian atau penjualan secara kredit (tempo) adalah?', 'Nota Kontan', 'Kwitansi', 'Faktur (Invoice)', 'Bukti Setoran Bank', 2),
(322, 1, 'Akuntansi', 'Bukti tertulis yang menjadi dasar pencatatan transaksi pembelian atau penjualan secara tunai adalah?', 'Faktur', 'Kwitansi', 'Nota Kontan', 'Bukti Kas Masuk', 2),
(323, 1, 'Akuntansi', 'Bukti transaksi yang mencatat pengeluaran uang tunai (misal: membayar gaji atau listrik) adalah?', 'Bukti Kas Masuk (BKM)', 'Bukti Setoran Bank', 'Kwitansi', 'Bukti Kas Keluar (BKK)', 3),
(324, 1, 'Akuntansi', 'Bukti bahwa seseorang telah menerima sejumlah uang (misal: pelunasan sewa) adalah?', 'Faktur', 'Kwitansi', 'Nota Kontan', 'Bukti Kas Masuk', 1),
(325, 1, 'Akuntansi', 'Informasi akuntansi yang dihasilkan oleh Akuntansi Perpajakan paling banyak digunakan oleh?', 'Investor', 'Bank/Kreditur', 'Manajemen Internal', 'Pemerintah (Otoritas Pajak)', 3),
(326, 1, 'Akuntansi', 'Tujuan utama dari akuntansi adalah untuk?', 'Membuat perencanaan penjualan', 'Memperoleh keuntungan maksimal', 'Mengetahui kondisi keuangan perusahaan secara jelas', 'Mengendalikan harga jual produk', 2),
(327, 1, 'Akuntansi', 'Langkah Reporting (Melaporkan) dalam siklus akuntansi menghasilkan laporan-laporan berikut, kecuali?', 'Laporan Laba Rugi', 'Neraca', 'Buku Jurnal Umum', 'Laporan Perubahan Modal', 2),
(328, 1, 'Akuntansi', 'Perusahaan yang proses akuntansi biayanya paling kompleks karena melibatkan perhitungan persediaan bahan baku hingga barang jadi adalah?', 'Jasa', 'Dagang', 'Manufaktur', 'Retail', 2),
(329, 1, 'Akuntansi', 'Alat pengendalian (controlling) dalam akuntansi berfungsi untuk?', 'Menentukan harga jual produk', 'Mengawasi aktivitas keuangan dan mendeteksi pemborosan', 'Membuat iklan promosi', 'Mengatur jadwal produksi', 1),
(330, 1, 'Akuntansi', 'Bidang Akuntansi Manajemen berfokus pada penyediaan informasi untuk:', 'Pelaporan pajak', 'Pengambilan keputusan operasional dan strategis internal', 'Verifikasi kejujuran laporan oleh pihak independen', 'Publikasi kepada investor', 1),
(331, 2, 'Akuntansi', 'Rumus utama yang menunjukkan bahwa setiap transaksi keuangan harus seimbang dan menjadi dasar penyusunan laporan keuangan adalah?', 'Aset = Pendapatan - Beban', 'Modal = Aset + Kewajiban', 'Aset = Kewajiban + Modal', 'Kewajiban = Aset + Modal', 2),
(332, 2, 'Akuntansi', 'Semua kekayaan yang dimiliki perusahaan dan dapat diukur nilainya disebut?', 'Kewajiban', 'Ekuitas', 'Aset (Harta)', 'Pendapatan', 2),
(333, 2, 'Akuntansi', 'Hak perusahaan untuk menerima uang dari pelanggan atas jasa atau barang yang telah diberikan secara kredit disebut?', 'Kas', 'Piutang', 'Utang Usaha', 'Perlengkapan', 1),
(334, 2, 'Akuntansi', 'Kewajiban perusahaan kepada pihak lain (utang), seperti utang kepada supplier atau utang bank, disebut?', 'Aset Lancar', 'Modal', 'Kewajiban (Utang)', 'Piutang', 2),
(335, 2, 'Akuntansi', 'Hak pemilik atas aset perusahaan yang merupakan investasi awal pemilik atau laba yang ditahan disebut?', 'Kewajiban', 'Utang', 'Modal (Ekuitas)', 'Pendapatan', 2),
(336, 2, 'Akuntansi', 'Transaksi Menerima pendapatan jasa secara tunai akan memengaruhi akun di Persamaan Dasar Akuntansi, yaitu?', 'Kas (Aset) bertambah dan Utang (Kewajiban) bertambah', 'Kas (Aset) bertambah dan Modal (Ekuitas) bertambah', 'Kas (Aset) berkurang dan Modal (Ekuitas) bertambah', 'Modal (Ekuitas) bertambah dan Utang (Kewajiban) berkurang', 1),
(337, 2, 'Akuntansi', 'Transaksi Membayar beban listrik secara tunai akan memengaruhi akun di Persamaan Dasar Akuntansi, yaitu?', 'Kas (Aset) berkurang dan Utang (Kewajiban) berkurang', 'Kas (Aset) berkurang dan Modal (Ekuitas) berkurang', 'Kas (Aset) bertambah dan Modal (Ekuitas) berkurang', 'Kas (Aset) bertambah dan Utang (Kewajiban) bertambah', 1),
(338, 2, 'Akuntansi', 'Transaksi Membeli peralatan secara tunai akan memengaruhi akun di Persamaan Dasar Akuntansi, yaitu?', 'Peralatan (Aset) bertambah dan Utang (Kewajiban) bertambah', 'Kas (Aset) berkurang dan Utang (Kewajiban) berkurang', 'Peralatan (Aset) bertambah dan Kas (Aset) berkurang', 'Modal (Ekuitas) bertambah dan Kas (Aset) berkurang', 2),
(339, 2, 'Akuntansi', 'Transaksi Pinjam uang dari bank akan memengaruhi akun di Persamaan Dasar Akuntansi, yaitu?', 'Kas (Aset) bertambah dan Utang (Kewajiban) bertambah', 'Kas (Aset) bertambah dan Modal (Ekuitas) bertambah', 'Kas (Aset) berkurang dan Utang (Kewajiban) bertambah', 'Modal (Ekuitas) bertambah dan Utang (Kewajiban) berkurang', 0),
(340, 2, 'Akuntansi', 'Komponen Persamaan Dasar Akuntansi yang nilainya akan bertambah akibat adanya Pendapatan Jasa adalah?', 'Kewajiban', 'Aset Lain', 'Modal (Ekuitas)', 'Piutang', 2),
(341, 2, 'Akuntansi', 'Komponen Persamaan Dasar Akuntansi yang nilainya akan berkurang akibat adanya Beban Gaji adalah?', 'Kewajiban', 'Utang Gaji', 'Modal (Ekuitas)', 'Piutang', 2),
(342, 2, 'Akuntansi', 'Unsur yang mencerminkan biaya yang dikeluarkan untuk menjalankan kegiatan usaha, yang bersifat mengurangi modal, adalah?', 'Pendapatan', 'Aset', 'Beban', 'Prive', 2),
(343, 2, 'Akuntansi', 'Jika Aset perusahaan sebesar Rp 50.000.000 dan Kewajiban sebesar Rp 20.000.000, maka Modal perusahaan adalah?', 'Rp 70.000.000', 'Rp 50.000.000', 'Rp 30.000.000', 'Rp 20.000.000', 2),
(344, 2, 'Akuntansi', 'Pengambilan uang tunai oleh pemilik untuk keperluan pribadi (Prive) akan memengaruhi akun:', 'Kas (Aset) dan Kewajiban (Utang) berkurang', 'Kas (Aset) bertambah dan Modal (Ekuitas) berkurang', 'Kas (Aset) berkurang dan Modal (Ekuitas) berkurang', 'Kas (Aset) bertambah dan Kewajiban (Utang) bertambah', 2),
(345, 2, 'Akuntansi', 'Pembelian Perlengkapan (misal: ATK) secara kredit akan memengaruhi akun:', 'Perlengkapan (Aset) bertambah dan Kas (Aset) berkurang', 'Perlengkapan (Aset) bertambah dan Utang Usaha (Kewajiban) bertambah', 'Kas (Aset) berkurang dan Modal (Ekuitas) berkurang', 'Perlengkapan (Aset) berkurang dan Utang Usaha (Kewajiban) berkurang', 1),
(346, 2, 'Akuntansi', 'Manakah yang termasuk kelompok Aset?', 'Utang Usaha dan Utang Bank', 'Kas, Piutang, dan Peralatan', 'Modal dan Prive', 'Pendapatan dan Beban', 1),
(347, 2, 'Akuntansi', 'Manakah yang termasuk kelompok Kewajiban?', 'Kas dan Piutang', 'Modal dan Prive', 'Utang Gaji dan Utang Usaha', 'Peralatan dan Perlengkapan', 2),
(348, 2, 'Akuntansi', 'Mengapa setiap transaksi harus mempengaruhi minimal dua elemen akuntansi?', 'Agar mudah dicatat di buku besar', 'Untuk memisahkan Pendapatan dan Beban', 'Untuk menjaga keseimbangan persamaan Aset = Kewajiban + Modal', 'Agar laba perusahaan terlihat lebih besar', 2),
(349, 2, 'Akuntansi', 'Unsur akuntansi yang bersifat mengurangi Modal selain Beban adalah?', 'Pendapatan', 'Utang Bank', 'Prive (Pengambilan Pribadi)', 'Piutang', 2),
(350, 2, 'Akuntansi', 'Transaksi Menerima pembayaran piutang dari pelanggan akan memengaruhi:', 'Kas (Aset) bertambah dan Piutang (Aset) berkurang', 'Kas (Aset) bertambah dan Modal (Ekuitas) bertambah', 'Kas (Aset) bertambah dan Kewajiban (Utang) bertambah', 'Piutang (Aset) bertambah dan Modal (Ekuitas) berkurang', 0),
(351, 3, 'Akuntansi', 'Tempat untuk mencatat semua perubahan yang terjadi akibat transaksi keuangan dan mengelompokkan transaksi sesuai jenisnya disebut?', 'Laporan Keuangan', 'Jurnal', 'Akun', 'Neraca Saldo', 2),
(352, 3, 'Akuntansi', 'Lima kelompok besar akun yang menjadi dasar penyusunan laporan keuangan adalah?', 'Kas, Piutang, Utang, Modal, Prive', 'Aset, Utang, Jurnal, Laba Rugi, Neraca', 'Aset, Kewajiban, Modal, Pendapatan, Beban', 'Pendapatan, Beban, Debet, Kredit, Saldo', 2),
(353, 3, 'Akuntansi', 'Saldo Normal (posisi bertambah) untuk kelompok akun Aset dan Beban berada di sisi?', 'Kredit', 'Debet', 'Sesuai transaksi', 'Hanya di Neraca', 1),
(354, 3, 'Akuntansi', 'Saldo Normal (posisi bertambah) untuk kelompok akun Kewajiban dan Pendapatan berada di sisi?', 'Debet', 'Kredit', 'Sesuai transaksi', 'Debet untuk Kewajiban, Kredit untuk Pendapatan', 1),
(355, 3, 'Akuntansi', 'Ketika terjadi transaksi pembelian peralatan secara tunai, akun Kas (Aset) akan berkurang. Pencatatan penurunan ini harus dilakukan di sisi?', 'Debet', 'Kredit', 'Sesuai Kode Akun', 'Sisi Saldo Normal', 1),
(356, 3, 'Akuntansi', 'Akun Beban Gaji dicatat di sisi Debet ketika bertambah. Jika perusahaan membayar gaji, posisi akun Beban Gaji dalam jurnal adalah?', 'Kredit', 'Debet', 'Sama dengan Kas', 'Saldo Normalnya berkurang', 1),
(357, 3, 'Akuntansi', 'Penerimaan pendapatan jasa akan menyebabkan akun Pendapatan Jasa bertambah. Penambahan ini dicatat di sisi?', 'Debet', 'Kredit', 'Sesuai Beban', 'Aset', 1),
(358, 3, 'Akuntansi', 'Ketika perusahaan membayar utang usaha, akun Utang Usaha (Kewajiban) akan berkurang. Pencatatan penurunan ini harus dilakukan di sisi?', 'Debet', 'Kredit', 'Debet dan Kredit', 'Modal', 0),
(359, 3, 'Akuntansi', 'Akun Modal (Ekuitas) memiliki Saldo Normal di Kredit. Jika pemilik mengambil uang untuk keperluan pribadi (Prive), akun Modal akan berkurang dan dicatat di sisi?', 'Kredit', 'Debet', 'Sesuai dengan Kas', 'Hanya di Neraca', 1),
(360, 3, 'Akuntansi', 'Daftar lengkap dari seluruh akun yang digunakan perusahaan, masing-masing memiliki nomor atau kode agar mudah ditemukan, disebut?', 'Buku Jurnal', 'Laporan Keuangan', 'Chart of Accounts (Kode Akun)', 'Neraca Saldo', 2),
(361, 3, 'Akuntansi', 'Dalam pengkodean akun yang umum, kelompok akun Aset biasanya diawali dengan angka?', '2xxx', '3xxx', '1xxx', '4xxx', 2),
(362, 3, 'Akuntansi', 'Dalam pengkodean akun yang umum, kelompok akun Pendapatan biasanya diawali dengan angka?', '3xxx', '5xxx', '4xxx', '1xxx', 2),
(363, 3, 'Akuntansi', 'Ketika perusahaan membeli perlengkapan secara kredit, akun Utang Usaha (Kewajiban) akan bertambah. Penambahan ini dicatat di sisi?', 'Debet', 'Kredit', 'Kredit dan Debet', 'Aset', 1),
(364, 3, 'Akuntansi', 'Perlengkapan, Kas, dan Peralatan termasuk dalam kelompok akun?', 'Kewajiban', 'Aset', 'Modal', 'Beban', 1),
(365, 3, 'Akuntansi', 'Utang Bank dan Utang Gaji termasuk dalam kelompok akun?', 'Aset', 'Modal', 'Kewajiban', 'Beban', 2),
(366, 3, 'Akuntansi', 'Apa fungsi utama dari Akun dalam akuntansi?', 'Hanya untuk menghitung laba perusahaan', 'Menyusun laporan keuangan tanpa perlu jurnal', 'Mengelompokkan transaksi sesuai jenisnya dan mempermudah analisis', 'Menggantikan fungsi bukti transaksi', 2),
(367, 3, 'Akuntansi', 'Jika Modal awal adalah Rp 100.000.000 dan terjadi Laba Rp 20.000.000, maka Laba tersebut dicatat di akun Modal di sisi?', 'Debet (Mengurangi Modal)', 'Kredit (Menambah Modal)', 'Aset (Bertambah)', 'Kewajiban (Berkurang)', 1),
(368, 3, 'Akuntansi', 'Akun yang memiliki saldo normal Kredit adalah?', 'Kas, Piutang, dan Beban', 'Kewajiban, Modal, dan Pendapatan', 'Aset, Beban, dan Prive', 'Hanya Modal dan Kewajiban', 1),
(369, 3, 'Akuntansi', 'Akun yang memiliki saldo normal Debet adalah?', 'Kewajiban, Modal, dan Pendapatan', 'Hanya Beban dan Prive', 'Aset dan Beban', 'Kas, Utang, dan Modal', 2),
(370, 3, 'Akuntansi', 'Dalam praktik pencatatan akuntansi, akun disajikan dalam bentuk T-account yang terdiri dari sisi?', 'Laba dan Rugi', 'Pemasukan dan Pengeluaran', 'Debet dan Kredit', 'Aset dan Kewajiban', 2),
(371, 4, 'Akuntansi', 'Tempat pertama untuk mencatat semua transaksi keuangan secara kronologis dan berfungsi sebagai buku harian perusahaan adalah?', 'Buku Besar', 'Neraca Saldo', 'Laporan Keuangan', 'Jurnal Umum', 3),
(372, 4, 'Akuntansi', 'Prinsip pencatatan akuntansi yang menyatakan bahwa setiap transaksi selalu mempengaruhi minimal dua akun, yaitu Debet dan Kredit, disebut?', 'Single-entry system', 'Double-entry system', 'Cash basis system', 'Accrual basis system', 1),
(373, 4, 'Akuntansi', 'Setelah dicatat di jurnal umum, transaksi akan dipindahkan atau diringkas ke tempat pencatatan akhir setiap akun, yang disebut?', 'Laporan Laba Rugi', 'Neraca', 'Buku Besar (Ledger)', 'Jurnal Penyesuaian', 2),
(374, 4, 'Akuntansi', 'Pencatatan di jurnal umum harus dilakukan berdasarkan urutan waktu terjadinya transaksi. Prinsip ini disebut?', 'Pencatatan Berurut', 'Pencatatan Kronologis', 'Pencatatan Sistematik', 'Pencatatan Rinci', 1),
(375, 4, 'Akuntansi', 'Prinsip utama dalam sistem Debet dan Kredit yang harus selalu dipatuhi saat menjurnal adalah?', 'Total Debet harus lebih besar dari Kredit', 'Total Kredit harus lebih besar dari Debet', 'Total Debet selalu harus sama dengan Total Kredit', 'Debet harus selalu pada sisi Aset', 2),
(376, 4, 'Akuntansi', 'Ketika Akun Kredit ditulis di bawah Akun Debet dengan posisi menjorok ke kanan (indent), hal ini dilakukan untuk?', 'Menghemat ruang di jurnal', 'Mempercepat proses posting', 'Membedakan posisi Debet dan Kredit sehingga mudah dilihat', 'Menyesuaikan dengan format buku besar', 2),
(377, 4, 'Akuntansi', 'Akun yang posisi Saldo Normalnya (bertambah) ada di Debet dan termasuk kelompok Aset adalah?', 'Utang Usaha', 'Kas', 'Modal', 'Pendapatan Jasa', 1),
(378, 4, 'Akuntansi', 'Transaksi pembelian perlengkapan secara tunai sebesar Rp500.000 akan dicatat di jurnal umum dengan mendebet akun?', 'Kas', 'Utang Usaha', 'Perlengkapan', 'Beban Perlengkapan', 2),
(379, 4, 'Akuntansi', 'Transaksi pembelian perlengkapan secara tunai sebesar Rp500.000 akan dicatat di jurnal umum dengan mengkredit akun?', 'Modal', 'Piutang', 'Kas', 'Perlengkapan', 2),
(380, 4, 'Akuntansi', 'Dokumen sumber yang menjadi dasar pencatatan transaksi penjualan atau pembelian secara kredit adalah?', 'Nota Kontan', 'Faktur (Invoice)', 'Kwitansi', 'Bukti Setoran Bank', 1),
(381, 4, 'Akuntansi', 'Jika perusahaan menerima pendapatan jasa secara tunai, pencatatan di jurnal umum yang benar adalah?', 'Debet Kas, Kredit Modal', 'Debet Piutang, Kredit Pendapatan Jasa', 'Debet Kas, Kredit Pendapatan Jasa', 'Debet Pendapatan Jasa, Kredit Kas', 2),
(382, 4, 'Akuntansi', 'Jika perusahaan membayar beban sewa gedung secara tunai, akun yang harus didebet adalah?', 'Kas', 'Utang Usaha', 'Modal', 'Beban Sewa', 3),
(383, 4, 'Akuntansi', 'Transaksi pembayaran utang usaha sebesar Rp1.000.000 secara tunai akan dicatat di jurnal umum dengan:', 'Debet Utang Usaha, Kredit Kas', 'Debet Kas, Kredit Utang Usaha', 'Debet Kas, Kredit Modal', 'Debet Beban, Kredit Utang Usaha', 0),
(384, 4, 'Akuntansi', 'Pengambilan uang tunai oleh pemilik untuk keperluan pribadi (Prive) dicatat dengan:', 'Debet Prive, Kredit Kas', 'Debet Kas, Kredit Prive', 'Debet Modal, Kredit Kas', 'Debet Kas, Kredit Modal', 0),
(385, 4, 'Akuntansi', 'Fungsi jurnal umum yang menyediakan catatan transaksi yang lengkap dengan tanggal, akun, dan nominal secara terperinci disebut fungsi?', 'Pencatatan', 'Analisis', 'Historis', 'Informatif', 2),
(386, 4, 'Akuntansi', 'Apa yang harus dilakukan segera setelah transaksi dicatat di jurnal umum?', 'Mencetak Laporan Keuangan', 'Membuat Jurnal Penyesuaian', 'Memposting ke Buku Besar', 'Menghitung Neraca Saldo', 2),
(387, 4, 'Akuntansi', 'Dalam format jurnal umum, letak akun Debet selalu ditulis?', 'Di bawah akun Kredit', 'Menjorok ke kanan (indent)', 'Terlebih dahulu tanpa indent', 'Hanya pada kolom Keterangan', 2),
(388, 4, 'Akuntansi', 'Dokumen yang menjadi bukti bahwa perusahaan telah menerima pelunasan utang pelanggan adalah?', 'Faktur', 'Nota Kontan', 'Bukti Kas Keluar', 'Bukti Kas Masuk', 3),
(389, 4, 'Akuntansi', 'Ketika terjadi transaksi pembelian perlengkapan secara kredit, akun yang harus dikredit adalah?', 'Kas', 'Piutang Usaha', 'Utang Usaha', 'Perlengkapan', 2),
(390, 4, 'Akuntansi', 'Jika perusahaan membayar gaji karyawan secara tunai sebesar Rp2.000.000, maka akun Kas dicatat di sisi?', 'Debet sebesar Rp2.000.000', 'Kredit sebesar Rp2.000.000', 'Debet sebesar Rp1.000.000', 'Kredit sebesar Rp1.000.000', 1),
(391, 5, 'Akuntansi', 'Kumpulan seluruh akun yang berisi ringkasan transaksi yang sudah dipindahkan dari jurnal umum dan menunjukkan saldo akhir setiap akun disebut?', 'Jurnal Umum', 'Laporan Keuangan', 'Neraca Saldo', 'Buku Besar (Ledger)', 3),
(392, 5, 'Akuntansi', 'Proses memindahkan transaksi dari jurnal umum ke akun masing-masing di buku besar disebut?', 'Penjurnalan', 'Pembukuan', 'Posting', 'Adjusting', 2),
(393, 5, 'Akuntansi', 'Apa tujuan utama dari penyusunan Buku Besar?', 'Mencatat transaksi secara kronologis', 'Mengetahui saldo akhir setiap akun', 'Memastikan semua transaksi tunai tercatat', 'Menghitung laba bersih perusahaan', 1),
(394, 5, 'Akuntansi', 'Bentuk Buku Besar yang paling sederhana dan sering digunakan untuk pembelajaran dasar, yang menyerupai bentuk huruf T, disebut?', 'Bentuk Stafle', 'Bentuk T-Account', 'Bentuk Skontro', 'Bentuk Running Balance', 1),
(395, 5, 'Akuntansi', 'Jika di jurnal umum tertulis Kas (Debet) dan Pendapatan Jasa (Kredit), maka proses posting di akun Pendapatan Jasa harus dicatat di sisi?', 'Debet', 'Kredit', 'Sesuai saldo awal', 'Di kolom Keterangan', 1),
(396, 5, 'Akuntansi', 'Kolom dalam Buku Besar yang berfungsi untuk mencatat nomor halaman jurnal sebagai sumber transaksi disebut?', 'Keterangan', 'Debet', 'Ref (Referensi)', 'Saldo', 2),
(397, 5, 'Akuntansi', 'Daftar seluruh akun yang terdapat di Buku Besar beserta saldonya (Debet atau Kredit) yang bertujuan memastikan keseimbangan adalah?', 'Laporan Laba Rugi', 'Jurnal Penyesuaian', 'Neraca Saldo (Trial Balance)', 'Buku Besar', 2),
(398, 5, 'Akuntansi', 'Tujuan utama dari penyusunan Neraca Saldo adalah?', 'Menghitung Beban yang belum dibayar', 'Menyajikan Laporan Perubahan Modal', 'Memastikan bahwa total Debet = total Kredit', 'Mencatat transaksi yang terlewat di jurnal', 2),
(399, 5, 'Akuntansi', 'Kapan Neraca Saldo biasanya disusun?', 'Sebelum transaksi dimulai', 'Setelah semua transaksi bulan tersebut diposting ke Buku Besar', 'Setiap kali ada transaksi kredit', 'Sebelum Jurnal Umum dibuat', 1),
(400, 5, 'Akuntansi', 'Jika total Debet di Neraca Saldo tidak sama dengan total Kredit, ini menunjukkan adanya?', 'Perusahaan mengalami kerugian', 'Perusahaan mengalami keuntungan', 'Kesalahan dalam proses pencatatan atau posting', 'Semua akun sudah seimbang', 2),
(401, 5, 'Akuntansi', 'Neraca Saldo berfungsi sebagai dasar untuk penyusunan laporan keuangan berikut, kecuali?', 'Laporan Laba Rugi', 'Neraca', 'Laporan Perubahan Modal', 'Jurnal Umum', 3),
(402, 5, 'Akuntansi', 'Jika akun Kas memiliki Saldo Normal Debet sebesar Rp5.000.000, maka dalam Neraca Saldo angka tersebut dicatat di kolom?', 'Kredit', 'Ref', 'Debet', 'Saldo Akhir', 2),
(403, 5, 'Akuntansi', 'Jika akun Utang Usaha memiliki Saldo Normal Kredit sebesar Rp2.000.000, maka dalam Neraca Saldo angka tersebut dicatat di kolom?', 'Debet', 'Kredit', 'Ref', 'Keterangan', 1),
(404, 5, 'Akuntansi', 'Salah satu fungsi penting Neraca Saldo adalah mendeteksi kesalahan teknis, seperti?', 'Salah menentukan harga jual', 'Posting terbalik (Debet ditaruh Kredit)', 'Kesalahan strategi pemasaran', 'Perubahan harga bahan baku', 1),
(405, 5, 'Akuntansi', 'Bentuk Buku Besar yang menghitung saldo setiap terjadi transaksi (Saldo dihitung per baris) disebut?', 'Bentuk T-Account', 'Bentuk Skontro', 'Bentuk Running Balance', 'Bentuk Sederhana', 2),
(406, 5, 'Akuntansi', 'Mengapa Buku Besar disebut sebagai buku induk?', 'Karena ukurannya paling besar', 'Karena merangkum semua perubahan transaksi berdasarkan jenis akun', 'Karena hanya mencatat aset saja', 'Karena digunakan untuk mencatat pengeluaran harian', 1),
(407, 5, 'Akuntansi', 'Ketika Akun Kewajiban bertambah di jurnal, maka saat di-posting ke Buku Besar, penambahan tersebut harus dicatat di sisi?', 'Debet', 'Kredit', 'Ref', 'Keterangan', 1),
(408, 5, 'Akuntansi', 'Manfaat Neraca Saldo bagi akuntan adalah?', 'Memperumit proses audit', 'Mengetahui posisi keuangan perusahaan sebelum disesuaikan', 'Menggantikan fungsi Jurnal Umum', 'Mempercepat pencatatan transaksi baru', 1),
(409, 5, 'Akuntansi', 'Jika Neraca Saldo sudah seimbang, apakah bisa dipastikan Laporan Keuangan sudah benar 100%?', 'Pasti benar', 'Pasti salah', 'Belum tentu, karena masih mungkin ada kesalahan non-teknis (misal: posting ke akun yang salah)', 'Hanya benar jika jumlah saldonya genap', 2),
(410, 5, 'Akuntansi', 'Jika perusahaan membeli peralatan secara kredit, maka posting di akun Peralatan (Aset) akan dicatat di sisi Debet dan akun Utang Usaha (Kewajiban) akan dicatat di sisi?', 'Debet', 'Kredit', 'Keterangan', 'Ref', 1),
(411, 1, 'Pemasaran', 'Rangkaian kegiatan yang dilakukan organisasi untuk mengenal, menciptakan, dan menyampaikan nilai kepada pelanggan serta membangun hubungan yang saling menguntungkan disebut?', 'Penjualan Langsung', 'Distribusi', 'Pemasaran', 'Manajemen Keuangan', 2),
(412, 1, 'Pemasaran', 'Tujuan utama dari pemasaran bukan sekadar menjual, tetapi proses memahami pelanggan, merancang solusi, dan menyampaikannya dengan cara yang membuat pelanggan?', 'Cepat beralih ke merek lain', 'Merasa puas dan mau kembali', 'Tidak membandingkan harga', 'Hanya fokus pada promosi', 1),
(413, 1, 'Pemasaran', 'Kondisi dasar yang diperlukan manusia untuk bertahan hidup atau merasa nyaman (mis. pangan, sandang, papan) dan bersifat fundamental disebut?', 'Permintaan', 'Keinginan', 'Kebutuhan (Needs)', 'Tujuan', 2),
(414, 1, 'Pemasaran', 'Bentuk kebutuhan yang dipengaruhi budaya, pribadi, dan lingkungan (mis. butuh makanan, keinginannya makan pizza) disebut?', 'Kebutuhan', 'Permintaan', 'Keinginan (Wants)', 'Nilai', 2),
(415, 1, 'Pemasaran', 'Keinginan yang didukung oleh kemampuan atau daya beli konsumen disebut?', 'Kebutuhan Dasar', 'Keinginan Spesifik', 'Permintaan (Demands)', 'Loyalitas', 2),
(416, 1, 'Pemasaran', 'Persepsi pelanggan tentang manfaat yang diterima dibandingkan biaya yang dikeluarkan (termasuk waktu, tenaga, risiko) disebut?', 'Harga Jual', 'Nilai (Value)', 'Kepuasan', 'Profit', 1),
(417, 1, 'Pemasaran', 'Tingkat perasaan pelanggan setelah membandingkan kinerja produk/jasa dengan harapannya. Jika kinerja lebih baik dari harapan, maka pelanggan akan merasa?', 'Loyal', 'Terkejut', 'Puas (Satisfaction)', 'Mencari pesaing', 2),
(418, 1, 'Pemasaran', 'Keputusan pelanggan untuk tetap memilih dan membeli merek yang sama secara berulang kali menunjukkan adanya?', 'Kepuasan Sementara', 'Keseimbangan', 'Loyalitas (Loyalty)', 'Komunikasi', 2),
(419, 1, 'Pemasaran', 'Strategi pemasaran yang efektif fokus pada menciptakan nilai, yang kemudian menghasilkan kepuasan, dan pada akhirnya membangun?', 'Harga yang mahal', 'Tekanan penjualan', 'Loyalitas pelanggan', 'Produk baru', 2),
(420, 1, 'Pemasaran', 'Alasan utama orang membeli suatu produk (misalnya: kenyamanan transportasi untuk sepeda) disebut?', 'Produk Nyata (Actual Product)', 'Layanan Purna Jual', 'Manfaat Inti (Core Benefit)', 'Produk Tambahan', 2),
(421, 1, 'Pemasaran', 'Elemen produk yang mencakup fitur, desain, kualitas, merek, dan kemasan adalah?', 'Manfaat Inti', 'Produk Nyata (Actual Product)', 'Garansi', 'Augmented Product', 1),
(422, 1, 'Pemasaran', 'Elemen produk yang mencakup layanan purna jual, garansi, pengiriman, dan layanan pelanggan disebut?', 'Core Benefit', 'Produk Nyata', 'Produk Tambahan (Augmented Product)', 'Diferensiasi', 2),
(423, 1, 'Pemasaran', 'Pemasaran yang efektif bertujuan untuk meningkatkan penjualan dan juga?', 'Menurunkan harga produk', 'Menurunkan kualitas produk', 'Meningkatkan pangsa pasar (market share)', 'Mengabaikan riset pasar', 2),
(424, 1, 'Pemasaran', 'Tujuan pemasaran yang berfokus pada retensi pelanggan, bukan hanya transaksi sekali beli, adalah?', 'Menciptakan harga termurah', 'Menciptakan hubungan jangka panjang dengan pelanggan', 'Menghilangkan semua pesaing', 'Mengurangi biaya promosi', 1),
(425, 1, 'Pemasaran', 'Fokus utama dari riset pasar dalam kegiatan pemasaran adalah?', 'Menentukan gaji karyawan', 'Memahami kebutuhan, keinginan, dan preferensi konsumen', 'Mengendalikan biaya produksi', 'Menjaga persediaan barang', 1),
(426, 1, 'Pemasaran', 'Jika kinerja produk lebih rendah dari harapan pelanggan, maka pelanggan akan merasa?', 'Puas', 'Loyal', 'Tidak puas', 'Netral', 2),
(427, 1, 'Pemasaran', 'Untuk mencapai keuntungan dan pertumbuhan bisnis, strategi pemasaran harus diarahkan pada?', 'Pengurangan karyawan', 'Meningkatkan profitabilitas dan ekspansi', 'Mengabaikan kualitas produk', 'Hanya menjual barang fisik', 1),
(428, 1, 'Pemasaran', 'Manakah yang merupakan contoh dari Kebutuhan?', 'Makan burger di restoran mewah', 'Merasa aman saat berada di rumah', 'Membeli mobil sport terbaru', 'Memiliki smartphone canggih', 1),
(429, 1, 'Pemasaran', 'Manakah yang merupakan contoh dari Permintaan?', 'Butuh pakaian', 'Ingin membeli kemeja merek X', 'Ingin membeli kemeja merek X dan memiliki uang untuk membelinya', 'Hanya ingin melihat-lihat kemeja', 2),
(430, 1, 'Pemasaran', 'Tujuan pemasaran dalam jangka panjang yang berkaitan dengan citra positif di mata konsumen adalah?', 'Mengurangi persediaan', 'Menciptakan diferensiasi kompetitif', 'Meningkatkan biaya promosi', 'Menghilangkan garansi produk', 1),
(431, 2, 'Pemasaran', 'Kombinasi strategi pemasaran yang digunakan perusahaan untuk mempengaruhi keputusan konsumen yang terdiri dari Product, Price, Place, dan Promotion disebut?', 'Riset Pasar', 'Analisis SWOT', 'Bauran Pemasaran (Marketing Mix)', 'Segmentasi Pasar', 2),
(432, 2, 'Pemasaran', 'Dalam Bauran Pemasaran (4P), unsur yang mencakup kualitas, desain, fitur, dan kemasan adalah?', 'Price', 'Place', 'Product', 'Promotion', 2),
(433, 2, 'Pemasaran', 'Fungsi atau kemampuan tambahan yang membuat produk berbeda dengan produk lain dan meningkatkan daya tarik produk termasuk dalam unsur mana dari 4P?', 'Price', 'Place', 'Promotion', 'Product', 3),
(434, 2, 'Pemasaran', 'Bagian luar produk yang melindungi isi, berfungsi sebagai identitas visual, dan memberikan pengalaman unboxing yang menyenangkan disebut?', 'Kualitas', 'Desain', 'Kemasan (Packaging)', 'Fitur', 2),
(435, 2, 'Pemasaran', 'Unsur dalam Bauran Pemasaran yang paling memengaruhi daya beli pelanggan dan berhubungan dengan penetapan harga premium atau harga ekonomis adalah?', 'Product', 'Price', 'Place', 'Promotion', 1),
(436, 2, 'Pemasaran', 'Potongan harga yang diberikan untuk menarik perhatian, meningkatkan penjualan, atau menghabiskan stok barang tertentu disebut?', 'Harga Kompetitif', 'Harga Penetration', 'Diskon', 'Harga Premium', 2),
(437, 2, 'Pemasaran', 'Strategi penetapan harga dengan menyesuaikan harga produk berdasarkan harga kompetitor agar produk tetap bersaing di pasar disebut?', 'Harga Psikologis', 'Harga Promosi', 'Harga Kompetitif', 'Harga Penetration', 2),
(438, 2, 'Pemasaran', 'Unsur Bauran Pemasaran yang berkaitan dengan bagaimana produk sampai ke tangan konsumen dan kemudahan pelanggan menemukan produk adalah?', 'Product', 'Price', 'Place', 'Promotion', 2),
(439, 2, 'Pemasaran', 'Proses menyalurkan produk melalui agen, toko, reseller, distributor, atau pengiriman langsung disebut?', 'Promosi', 'Logistik', 'Distribusi', 'Produksi', 2),
(440, 2, 'Pemasaran', 'Di era digital, tempat penjualan juga mencakup platform seperti Tokopedia, Shopee, atau website toko sendiri, yang dikenal sebagai?', 'Marketplace', 'Gudang', 'Toko Fisik', 'Pusat Distribusi', 0),
(441, 2, 'Pemasaran', 'Tujuan utama dari unsur Promotion (Promosi) adalah?', 'Menurunkan biaya produksi', 'Memperkecil jaringan distribusi', 'Menginformasikan, menarik perhatian, dan membujuk konsumen membeli produk', 'Menjaga kualitas produk', 2),
(442, 2, 'Pemasaran', 'Upaya menciptakan identitas, karakter, warna, logo, dan citra produk agar mudah dikenali dan dipercaya dalam jangka panjang disebut?', 'Iklan', 'Branding', 'Event Promosi', 'Penjualan Personal', 1),
(443, 2, 'Pemasaran', 'Menggunakan platform seperti Instagram, TikTok, atau YouTube untuk membangun interaksi dengan audiens dan memperluas eksposur termasuk dalam bentuk?', 'Iklan Tradisional', 'Media Sosial', 'Distribusi Langsung', 'Penetapan Harga', 1),
(444, 2, 'Pemasaran', 'Kegiatan seperti launching produk, bazar, pameran, atau giveaway untuk meningkatkan minat dan penjualan termasuk dalam kategori?', 'Perencanaan Produk', 'Penetapan Harga', 'Event Promosi', 'Pengendalian Kualitas', 2),
(445, 2, 'Pemasaran', 'Apa tujuan dari unsur Product dalam Marketing Mix?', 'Mendapatkan keuntungan setinggi-tingginya', 'Memberikan solusi terbaik bagi konsumen dan membangun identitas yang kuat', 'Mempermudah distribusi ke seluruh wilayah', 'Menarik perhatian melalui diskon besar', 1),
(446, 2, 'Pemasaran', 'Keempat unsur dalam Bauran Pemasaran (4P) harus dirancang secara?', 'Terpisah satu sama lain', 'Bersaing secara internal', 'Saling berhubungan dan seimbang', 'Hanya fokus pada Price', 2),
(447, 2, 'Pemasaran', 'Jika sebuah perusahaan memutuskan untuk menjual produknya di Tokopedia dan Shopee, ini merupakan keputusan yang berkaitan dengan unsur?', 'Product', 'Price', 'Place', 'Promotion', 2),
(448, 2, 'Pemasaran', 'Strategi harga yang menetapkan harga jual di bawah harga normal atau harga pesaing untuk mendapatkan pangsa pasar yang besar di awal disebut?', 'Harga Premium', 'Harga Psikologis', 'Harga Kompetitif', 'Harga Penetrasi Pasar', 3),
(449, 2, 'Pemasaran', 'Unsur Kualitas produk yang baik akan secara langsung memengaruhi apa dalam hubungan pelanggan?', 'Biaya Distribusi', 'Nilai dan kepuasan pelanggan', 'Jumlah diskon', 'Jaringan reseller', 1),
(450, 2, 'Pemasaran', 'Dalam Bauran Pemasaran, Iklan digital seperti Google Ads dan banner website termasuk dalam kegiatan?', 'Product', 'Price', 'Place', 'Promotion', 3),
(451, 3, 'Pemasaran', 'Proses membagi pasar yang luas menjadi kelompok-kelompok kecil berdasarkan karakteristik tertentu disebut?', 'Targeting', 'Positioning', 'Segmentasi Pasar', 'Diferensiasi', 2),
(452, 3, 'Pemasaran', 'Pembagian pasar berdasarkan usia, jenis kelamin, atau pendapatan termasuk dalam dasar segmentasi?', 'Psikografis', 'Geografis', 'Demografis', 'Behavioral', 2),
(453, 3, 'Pemasaran', 'Pembagian pasar berdasarkan wilayah (kota/desa, provinsi, iklim) termasuk dalam dasar segmentasi?', 'Demografis', 'Psikografis', 'Geografis', 'Ekonomi', 2),
(454, 3, 'Pemasaran', 'Pembagian pasar berdasarkan gaya hidup, hobi, dan kepribadian (misalnya: pecinta olahraga atau penggemar teknologi) termasuk dalam dasar segmentasi?', 'Geografis', 'Demografis', 'Psikografis', 'Ekonomi', 2),
(455, 3, 'Pemasaran', 'Proses memilih salah satu atau beberapa segmen pasar yang paling potensial dan menguntungkan untuk dilayani oleh perusahaan disebut?', 'Segmentasi', 'Positioning', 'Targeting', 'Diferensiasi', 2),
(456, 3, 'Pemasaran', 'Jika sebuah perusahaan menjual mobil mewah, kriteria pemilihan target pasar yang paling utama dipertimbangkan adalah?', 'Lokasi (Geografis)', 'Minat (Hobi)', 'Daya Beli (Pendapatan)', 'Usia (Remaja)', 2),
(457, 3, 'Pemasaran', 'Upaya untuk menanamkan citra, kesan, dan identitas produk di benak konsumen sehingga mereka melihatnya berbeda dari pesaing disebut?', 'Segmentasi', 'Targeting', 'Positioning', 'Diferensiasi', 2),
(458, 3, 'Pemasaran', 'Ketika Aqua memposisikan diri sebagai \"air minum paling aman dan terpercaya\", hal ini bertujuan untuk menciptakan?', 'Kenaikan harga', 'Persepsi dan citra tertentu di benak konsumen', 'Penurunan kualitas', 'Perubahan wilayah pemasaran', 1),
(459, 3, 'Pemasaran', 'Salah satu cara utama melakukan positioning adalah dengan membangun keunggulan yang membuat produk unik, yang disebut?', 'Homogenitas', 'Efektivitas', 'Diferensiasi', 'Diversifikasi', 2),
(460, 3, 'Pemasaran', 'Manakah yang menjadi fokus utama dalam tahap Segmentasi?', 'Memilih satu segmen terbesar', 'Memecah pasar besar menjadi kelompok yang lebih kecil dan homogen', 'Menentukan harga jual produk', 'Menciptakan slogan perusahaan', 1),
(461, 3, 'Pemasaran', 'Setelah melakukan segmentasi, kriteria apakah yang harus dipertimbangkan untuk menentukan segmen mana yang akan dijadikan target?', 'Ukuran segmen dan potensi pertumbuhannya', 'Warna kesukaan konsumen', 'Tipe kemasan yang paling disukai', 'Penggunaan marketplace yang populer', 0),
(462, 3, 'Pemasaran', 'Jika perusahaan menjual jaket tebal, segmen yang paling relevan untuk dipertimbangkan adalah berdasarkan?', 'Minat (Psikografis)', 'Lokasi (Geografis / Iklim)', 'Usia (Demografis)', 'Pendapatan (Ekonomi)', 1),
(463, 3, 'Pemasaran', 'Pernyataan \"Produk kami adalah yang termurah dengan kualitas terbaik\" merupakan contoh dari strategi?', 'Targeting', 'Segmentasi', 'Positioning', 'Promosi', 2),
(464, 3, 'Pemasaran', 'Mengapa perusahaan harus menerapkan STP?', 'Agar dapat menjual ke semua orang', 'Agar strategi pemasaran lebih terarah dan efektif', 'Untuk menghilangkan kebutuhan riset pasar', 'Agar produk tidak perlu diubah lagi', 1),
(465, 3, 'Pemasaran', 'Jika sebuah perusahaan menargetkan kelompok \"usia 20-35, suka traveling, dan berpenghasilan menengah-atas\", perusahaan tersebut menggabungkan segmentasi?', 'Geografis dan Behavioral', 'Demografis dan Psikografis', 'Ekonomi dan Lokasi', 'Geografis dan Demografis', 1),
(466, 3, 'Pemasaran', 'Apa yang terjadi jika perusahaan tidak konsisten dalam positioningnya?', 'Harga produk akan stabil', 'Konsumen akan bingung mengenai citra dan keunggulan produk tersebut', 'Penjualan pasti meningkat drastis', 'Kompetitor akan meninggalkan pasar', 1),
(467, 3, 'Pemasaran', 'Pendekatan pemasaran yang melibatkan tiga langkah berurutan: membagi pasar, memilih sasaran, dan menanamkan citra adalah?', 'Marketing Mix (4P)', 'Positioning, Targeting, Segmentasi', 'STP (Segmentasi, Targeting, Positioning)', 'Analisis SWOT', 2),
(468, 3, 'Pemasaran', 'Jika perusahaan menjual produk skincare yang ditujukan khusus untuk remaja, maka perusahaan telah memilih target berdasarkan kriteria?', 'Minat', 'Geografis', 'Usia', 'Pendapatan', 2),
(469, 3, 'Pemasaran', 'Tujuan dari segmentasi adalah untuk membuat pasar menjadi?', 'Lebih besar', 'Kelompok yang lebih heterogen', 'Kelompok yang lebih homogen (serupa)', 'Kelompok yang berharga mahal', 2),
(470, 3, 'Pemasaran', 'Seorang pemasar harus memastikan bahwa pesan positioning produknya disampaikan secara?', 'Mahal', 'Berubah-ubah setiap bulan', 'Konsisten di semua media dan interaksi', 'Hanya melalui media cetak', 2),
(471, 4, 'Pemasaran', 'Studi mengenai bagaimana individu atau kelompok memilih, membeli, menggunakan, dan mengevaluasi produk atau jasa untuk memenuhi kebutuhannya disebut?', 'Analisis Pasar', 'Riset Produk', 'Perilaku Konsumen', 'Manajemen Sumber Daya', 2),
(472, 4, 'Pemasaran', 'Nilai, norma, kebiasaan, dan kepercayaan yang dipelajari seseorang sejak kecil dan sangat memengaruhi pembelian disebut Faktor?', 'Sosial', 'Pribadi', 'Budaya', 'Psikologis', 2),
(473, 4, 'Pemasaran', 'Keputusan seseorang membeli smartphone tertentu karena digunakan oleh teman-temannya termasuk dalam pengaruh Faktor?', 'Pribadi', 'Sosial', 'Budaya', 'Psikologis', 1),
(474, 4, 'Pemasaran', 'Pengaruh Keluarga, Teman Sebaya, dan Kelompok Referensi merupakan bagian dari Faktor yang memengaruhi keputusan membeli?', 'Pribadi', 'Budaya', 'Sosial', 'Ekonomi', 2),
(475, 4, 'Pemasaran', 'Faktor yang meliputi Usia, Pekerjaan, Keadaan Ekonomi, dan Gaya Hidup konsumen adalah Faktor?', 'Budaya', 'Sosial', 'Pribadi', 'Psikologis', 2),
(476, 4, 'Pemasaran', 'Seorang manajer senior yang cenderung memilih produk premium yang sesuai dengan citra dirinya dipengaruhi oleh Faktor Pribadi, yaitu?', 'Gaya Hidup', 'Keadaan Ekonomi', 'Pekerjaan dan Status Sosial', 'Motivasi', 2),
(477, 4, 'Pemasaran', 'Faktor yang berhubungan dengan cara seseorang memandang dan memproses informasi tentang produk, seperti Motivasi, Persepsi, dan Sikap, adalah Faktor?', 'Sosial', 'Budaya', 'Pribadi', 'Psikologis', 3),
(478, 4, 'Pemasaran', 'Dorongan dalam diri untuk memenuhi kebutuhan (misalnya: ingin tampil rapi atau ingin sehat) dalam konteks psikologis disebut?', 'Persepsi', 'Sikap', 'Motivasi', 'Pembelajaran', 2),
(479, 4, 'Pemasaran', 'Tahap pertama dalam Proses Pembelian Konsumen adalah?', 'Pencarian Informasi', 'Keputusan Membeli', 'Pengenalan Kebutuhan (Need Recognition)', 'Evaluasi Setelah Pembelian', 2),
(480, 4, 'Pemasaran', 'Ketika seorang konsumen menyadari bahwa ia merasa haus dan harus mendapatkan minuman, ini termasuk tahap?', 'Pencarian Informasi', 'Pengenalan Kebutuhan', 'Keputusan Membeli', 'Evaluasi', 1),
(481, 4, 'Pemasaran', 'Konsumen mencari informasi mengenai produk dari internet, teman, atau iklan termasuk dalam tahap?', 'Keputusan Membeli', 'Evaluasi Setelah Pembelian', 'Pencarian Informasi', 'Pengenalan Kebutuhan', 2),
(482, 4, 'Pemasaran', 'Tahap di mana konsumen memilih produk yang paling sesuai dari berbagai pilihan, dipengaruhi oleh harga, merek, dan ketersediaan stok, adalah?', 'Pencarian Informasi', 'Keputusan Membeli (Purchase Decision)', 'Evaluasi Awal', 'Pembelajaran', 1),
(483, 4, 'Pemasaran', 'Tahap terakhir dalam Proses Pembelian Konsumen adalah?', 'Keputusan Membeli', 'Pencarian Informasi', 'Evaluasi Setelah Pembelian (Post-purchase Evaluation)', 'Pengenalan Kebutuhan', 2),
(484, 4, 'Pemasaran', 'Jika konsumen membeli merek yang sama berulang kali karena pengalaman sebelumnya baik, faktor psikologis yang bekerja adalah?', 'Motivasi', 'Sikap', 'Pembelajaran (Learning)', 'Persepsi', 2),
(485, 4, 'Pemasaran', 'Makanan yang dikonsumsi, gaya berpakaian, dan preferensi warna yang dipengaruhi oleh adat atau tradisi termasuk pengaruh?', 'Sosial', 'Pribadi', 'Budaya', 'Ekonomi', 2),
(486, 4, 'Pemasaran', 'Orang dengan pendapatan tinggi cenderung memilih produk premium. Hal ini dipengaruhi oleh Faktor?', 'Budaya', 'Sosial', 'Pribadi (Keadaan Ekonomi)', 'Psikologis', 2),
(487, 4, 'Pemasaran', 'Apa yang dilakukan konsumen jika hasil evaluasi setelah pembelian produk ternyata mengecewakan?', 'Membeli produk yang sama lagi', 'Merekomendasikan produk tersebut ke teman', 'Mencari dan berpindah ke produk merek lain', 'Meningkatkan loyalitas pada merek tersebut', 2),
(488, 4, 'Pemasaran', 'Seorang pemasar harus memahami perilaku konsumen agar dapat merancang strategi pemasaran yang?', 'Acak dan tidak terstruktur', 'Hanya fokus pada harga', 'Tepat sasaran dan efektif', 'Tidak memerlukan riset lagi', 2),
(489, 4, 'Pemasaran', 'Kelompok atau komunitas yang dijadikan panutan oleh seseorang (misal komunitas gamers) disebut?', 'Keluarga', 'Teman Sebaya', 'Kelompok Referensi', 'Status Sosial', 2),
(490, 4, 'Pemasaran', 'Tahapan proses pembelian yang dipengaruhi oleh iklan, rekomendasi, dan review produk di internet adalah?', 'Pengenalan Kebutuhan', 'Keputusan Membeli', 'Pencarian Informasi', 'Evaluasi Setelah Pembelian', 2),
(491, 5, 'Pemasaran', 'Strategi pemasaran yang memanfaatkan internet dan teknologi digital untuk mempromosikan produk atau layanan disebut?', 'Traditional Marketing', 'Personal Selling', 'Digital Marketing', 'Direct Marketing', 2),
(492, 5, 'Pemasaran', 'Salah satu keunggulan utama dari Media Sosial Marketing (Instagram, TikTok) adalah kemampuannya untuk?', 'Mengabaikan pelanggan', 'Menciptakan kedekatan dan membangun citra merek', 'Hanya fokus pada penjualan langsung', 'Mempertahankan biaya iklan yang mahal', 1),
(493, 5, 'Pemasaran', 'Penggunaan tagar yang relevan dan pembuatan kampanye challenge di TikTok termasuk dalam strategi?', 'SEO', 'Content Marketing', 'Media Sosial Marketing', 'Email Marketing', 2),
(494, 5, 'Pemasaran', 'Tempat jual beli online yang sudah menyediakan fitur lengkap dari etalase hingga sistem pembayaran yang aman (contoh: Shopee, Tokopedia) disebut?', 'Website Perusahaan', 'Blog', 'Marketplace', 'Gudang Virtual', 2),
(495, 5, 'Pemasaran', 'Strategi marketplace yang efektif untuk meningkatkan visibilitas produk di platform tersebut adalah?', 'Hanya menjual produk paling mahal', 'Tidak menggunakan foto produk', 'Menggunakan fitur iklan seperti Shopee Ads atau Tokopedia Ads', 'Mempromosikan melalui koran', 2);
INSERT INTO `bank_soal` (`id`, `materi_id`, `jurusan`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`) VALUES
(496, 5, 'Pemasaran', 'Strategi membuat dan membagikan konten yang bermanfaat untuk menarik dan mempertahankan pelanggan (misalnya: video tutorial, artikel edukasi) disebut?', 'Influencer Marketing', 'Marketplace Strategy', 'Content Marketing', 'Iklan Berbayar', 2),
(497, 5, 'Pemasaran', 'Tujuan utama dari Content Marketing adalah?', 'Langsung menghasilkan penjualan saat itu juga', 'Membangun kepercayaan sehingga konsumen tertarik membeli secara alami', 'Menurunkan ranking website', 'Mencari pengikut sebanyak-banyaknya', 1),
(498, 5, 'Pemasaran', 'Teknik untuk membuat website tampil di halaman pertama Google agar mudah ditemukan oleh calon konsumen disebut?', 'Social Media Marketing', 'Email Marketing', 'Search Engine Optimization (SEO)', 'Pay-Per-Click (PPC)', 2),
(499, 5, 'Pemasaran', 'Manfaat utama dari SEO adalah mendapatkan pengunjung secara?', 'Berbayar (Iklan)', 'Gratis (Organik)', 'Hanya dari media sosial', 'Melalui email', 1),
(500, 5, 'Pemasaran', 'Komponen SEO yang paling penting agar website mendapatkan ranking tinggi dan relevan adalah?', 'Warna website yang cerah', 'Konten berkualitas dan penggunaan kata kunci yang tepat', 'Jumlah foto yang diunggah', 'Harga produk yang sangat mahal', 1),
(501, 5, 'Pemasaran', 'Mempromosikan produk melalui orang yang memiliki banyak pengikut dan dipercaya oleh audiens disebut?', 'Word of Mouth', 'Influencer Marketing', 'Affiliate Marketing', 'Direct Selling', 1),
(502, 5, 'Pemasaran', 'Jenis influencer yang memiliki jumlah pengikut 10k–100k dan dikenal efektif serta terjangkau bagi UMKM adalah?', 'Mega Influencer', 'Nano Influencer', 'Micro Influencer', 'Macro Influencer', 2),
(503, 5, 'Pemasaran', 'Proses mengumpulkan dan menganalisis data dari berbagai platform untuk meningkatkan strategi pemasaran disebut?', 'Data Collection', 'Data Analysis', 'Data Analytics', 'Data Mining', 2),
(504, 5, 'Pemasaran', 'Jika data analytics menunjukkan posting jam 19.00 mendapatkan engagement tertinggi, maka tujuannya adalah?', 'Mengurangi biaya iklan', 'Mengetahui waktu terbaik untuk posting dan menyesuaikan jadwal', 'Mengubah desain produk', 'Menjual produk di marketplace saja', 1),
(505, 5, 'Pemasaran', 'Manakah yang bukan termasuk komponen SEO?', 'Kata kunci (keyword) yang tepat', 'Kecepatan website yang baik', 'Struktur website yang rapi', 'Menggunakan diskon 50% untuk semua produk', 3),
(506, 5, 'Pemasaran', 'Marketplace Strategy memberikan keuntungan berupa sistem pembayaran yang aman dan mudah, karena adanya fitur?', 'Cash On Delivery (COD) saja', 'Sistem rekber (rekening bersama) di platform tersebut', 'Pembayaran langsung ke penjual', 'Pengiriman gratis', 1),
(507, 5, 'Pemasaran', 'Mengapa digital marketing dianggap lebih efektif dibanding marketing tradisional?', 'Biaya yang lebih mahal', 'Dapat menjangkau audiens yang lebih luas dan cepat', 'Hanya dapat dilakukan oleh perusahaan besar', 'Tidak memerlukan koneksi internet', 1),
(508, 5, 'Pemasaran', 'Ketika sebuah brand skincare membuat konten edukasi \"cara merawat kulit berminyak\", mereka sedang menerapkan?', 'SEO', 'Content Marketing', 'Influencer Marketing', 'Pemasaran Tradisional', 1),
(509, 5, 'Pemasaran', 'Jenis konten yang paling cepat viral dan cocok untuk brand awareness di Instagram dan TikTok adalah?', 'Artikel panjang di blog', 'Video pendek (Reels/TikTok)', 'Iklan di koran', 'Poster produk di billboard', 1),
(510, 5, 'Pemasaran', 'Dalam data analytics, menganalisis Engagement Instagram/TikTok berguna untuk mengetahui?', 'Kualitas produk secara keseluruhan', 'Seberapa interaktif audiens terhadap konten yang diunggah', 'Jumlah bahan baku yang dibutuhkan', 'Harga produk pesaing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `diskusi`
--

CREATE TABLE `diskusi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskusi`
--

INSERT INTO `diskusi` (`id`, `judul`, `isi`, `user_id`, `jurusan`, `created_at`) VALUES
(1, '', 'halo', 1, 'TKJ', '2025-12-02 13:18:44'),
(3, '', 'halo', 1, 'TKJ', '2025-12-02 13:18:58'),
(5, '', 'ha', 6, 'TKJ', '2025-12-02 13:21:19'),
(6, '', 'halo', 6, 'TKJ', '2025-12-02 13:30:36'),
(7, '', 'halo', 1, 'TKJ', '2025-12-03 02:03:04'),
(9, '', 'uiouo', 7, 'TKJ', '2025-12-03 02:29:53'),
(10, '', 'gdfgfdgsd', 7, 'TKJ', '2025-12-03 02:42:35'),
(11, '', 'hello', 3, 'RPL', '2025-12-03 06:36:50'),
(12, '', 'davila', 8, 'Multimedia', '2025-12-03 06:53:16'),
(15, '', 'fdgfdg', 8, 'Multimedia', '2025-12-08 02:49:55'),
(16, '', 'dfgdfgdf', 8, 'Multimedia', '2025-12-08 02:50:01'),
(17, '', 'halo', 8, 'Multimedia', '2025-12-08 03:05:09'),
(18, '', 'halo', 7, 'TKJ', '2025-12-17 03:26:07'),
(19, '', 'hahaha', 1, 'TKJ', '2025-12-17 06:35:41'),
(21, '', 'kelazzz', 4, 'RPL', '2025-12-21 13:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `diskusi_reply`
--

CREATE TABLE `diskusi_reply` (
  `id` int(11) NOT NULL,
  `diskusi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskusi_reply`
--

INSERT INTO `diskusi_reply` (`id`, `diskusi_id`, `user_id`, `isi`, `jurusan`, `created_at`) VALUES
(1, 5, 6, 'dsfsdf', 'TKJ', '2025-12-02 13:24:40'),
(2, 5, 6, 'dsfsdf', 'TKJ', '2025-12-02 13:28:04'),
(4, 7, 7, 'aaa\\', 'TKJ', '2025-12-03 02:18:25'),
(5, 6, 7, 'haha', 'TKJ', '2025-12-03 02:38:16'),
(6, 1, 7, 'halo', 'TKJ', '2025-12-03 02:38:37'),
(7, 1, 7, 'apa kabar', 'TKJ', '2025-12-03 02:38:49'),
(8, 11, 3, 'keren', 'RPL', '2025-12-03 06:37:00'),
(9, 12, 8, 'halo', 'Multimedia', '2025-12-03 06:53:23'),
(10, 9, 1, 'kelas king', 'TKJ', '2025-12-04 04:18:37'),
(11, 9, 7, 'halo', 'TKJ', '2025-12-17 03:33:42'),
(12, 10, 7, 'halo', 'TKJ', '2025-12-17 03:42:11'),
(13, 10, 7, 'oi oi', 'TKJ', '2025-12-17 03:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `jumlah_benar` int(11) NOT NULL,
  `jumlah_salah` int(11) NOT NULL,
  `tanggal_selesai` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_ujian`
--

INSERT INTO `hasil_ujian` (`id`, `ujian_id`, `siswa_id`, `nilai`, `jumlah_benar`, `jumlah_salah`, `tanggal_selesai`) VALUES
(1, 2, 1, 27.27, 3, 8, '2025-12-14 12:13:50'),
(2, 3, 1, 100.00, 5, 0, '2025-12-16 20:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_siswa`
--

CREATE TABLE `jawaban_siswa` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `jawaban_siswa` enum('A','B','C','D') NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `file_tugas` varchar(255) NOT NULL,
  `catatan` text DEFAULT NULL,
  `dikumpulkan_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `guru_id`, `judul`, `isi`, `tanggal`, `file_attachment`) VALUES
(9, 11, 'Traspac competition', 'deadline 1 januari 2026', '2025-12-20 03:29:28', NULL),
(10, 11, 'Masuk Sekolah', 'Tanggal 5 Januari 2026', '2025-12-20 03:30:37', 'uploads/pengumuman/1766201437_9a11c49f.png'),
(11, 11, 'Pengambilan Rapot kelas XI dan XII', 'pada tanggal 18 Desember 2025', '2025-12-20 03:32:05', NULL),
(12, 11, 'Upacara Bendera', 'masuk langsung upacara bendera', '2025-12-22 01:49:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_scores`
--

CREATE TABLE `quiz_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `skor` int(11) NOT NULL,
  `total_soal` int(11) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `nilai_persen` decimal(5,2) GENERATED ALWAYS AS (`skor` / `total_soal` * 100) STORED,
  `tanggal_mengerjakan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_scores`
--

INSERT INTO `quiz_scores` (`id`, `user_id`, `materi_id`, `skor`, `total_soal`, `jurusan`, `tanggal_mengerjakan`) VALUES
(33, 1, 1, 20, 20, 'TKJ', '2025-12-09 11:01:14'),
(34, 4, 1, 3, 40, 'RPL', '2025-12-12 03:43:05'),
(36, 5, 1, 5, 100, 'RPL', '2025-12-13 02:31:13'),
(37, 7, 1, 7, 100, 'TKJ', '2025-12-13 03:36:24'),
(48, 1, 2, 15, 20, 'TKJ', '2025-12-13 07:14:48'),
(49, 6, 1, 3, 20, 'TKJ', '2025-12-13 07:33:44'),
(50, 1, 3, 11, 15, 'TKJ', '2025-12-16 05:07:07'),
(51, 1, 4, 12, 15, 'TKJ', '2025-12-16 05:11:24'),
(52, 1, 5, 16, 20, 'TKJ', '2025-12-16 05:18:47'),
(53, 9, 1, 8, 20, 'Akuntansi', '2025-12-22 11:12:22'),
(54, 4, 2, 5, 20, 'RPL', '2025-12-22 12:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `kunci_jawaban` enum('A','B','C','D') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `ujian_id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `kunci_jawaban`, `created_at`) VALUES
(2, 2, '4543', '455', '45', '45', '45', 'A', '2025-12-14 04:54:03'),
(3, 2, '1-4', '3', 'rer', 'eer', 'ere', 'A', '2025-12-14 04:54:03'),
(4, 2, 'dgfrgwqwq', '0wq', '3', '12', '2ty', 'B', '2025-12-14 04:54:03'),
(5, 2, '5654654', '343', '34', '3', '43', 'C', '2025-12-14 04:54:03'),
(6, 2, '343', '3434', '565', '454', '767', 'A', '2025-12-14 04:54:03'),
(7, 2, 'dfds', 'dstr', 'tytr', 'tryt', 'tytr', 'C', '2025-12-14 04:54:03'),
(8, 2, 'ytry', '645', '76', '546', '765', 'B', '2025-12-14 04:54:03'),
(9, 2, '66', '5566', '6555', '56', '6544', 'C', '2025-12-14 04:54:03'),
(10, 2, '6546', '565', '56', '55', '56', 'A', '2025-12-14 04:54:03'),
(11, 2, '54654', '56', '56', '546', '456', 'C', '2025-12-14 04:54:03'),
(12, 2, '7dfdsdfgfd', 'dfgdfgdf', 'dfgdfg', 'fdgdfg', 'dfgdfgdf', 'A', '2025-12-14 04:54:55'),
(13, 3, 'wqwqw', 'wqwq', 'qwqw', 'wqwq', 'wqwqw', 'A', '2025-12-16 13:20:17'),
(14, 3, 'wqwqwre', 'wqqwq', 'wqw', 'qw', 'wqwq', 'A', '2025-12-16 13:20:17'),
(15, 3, 'wwqwq', 'wqw', 'wwqw', 'qwq', 'eww', 'A', '2025-12-16 13:20:17'),
(16, 3, 'qwqdw', 'wqw', 'sds', 'ytyrt', 'dweerw', 'A', '2025-12-16 13:20:17'),
(17, 3, 'sdqdqe', 'asds', 'qwerew', 'rty', 'tretr', 'A', '2025-12-16 13:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `guru_id`, `jurusan`, `judul`, `deskripsi`, `gambar`, `deadline`, `created_at`) VALUES
(23, 11, 'TKJ', 'tugas tkj', 'jangan sampai terlambat', '[{\"name\":\"OIP (2).jpg\",\"path\":\"uploads\\/tugas\\/1766371623_0_OIP (2).jpg\",\"mime\":\"image\\/jpeg\"}]', '2025-12-31 11:48:00', '2025-12-22 02:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `guru_id` int(11) NOT NULL,
  `durasi_menit` int(11) NOT NULL DEFAULT 60,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `judul`, `jurusan`, `guru_id`, `durasi_menit`, `is_active`, `created_at`) VALUES
(2, 'matematika', 'TKJ', 11, 60, 1, '2025-12-14 04:54:03'),
(3, 'Jaringan', 'TKJ', 11, 10, 1, '2025-12-16 13:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` enum('RPL','TKJ','Akuntansi','Multimedia','Pemasaran','N/A') NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('siswa','guru') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `jurusan`, `email`, `password`, `role`, `foto_profil`, `token`, `is_verified`, `created_at`, `reset_token`, `reset_expired`) VALUES
(1, 'hilmy', 'TKJ', 'hilmy@gmail.com', '$2y$10$Dd0QbwuQjIc.eFGULAJJnus5ST7.JC885F2wqtT7G6xT/oyLguTCO', 'siswa', 'uploads/profiles/profil_1_1765966142.jpg', NULL, 0, '2025-12-01 13:13:45', NULL, NULL),
(3, 'siska', 'RPL', 'siska@gmail.com', '$2y$10$tmvWD.bA1gweBbcFVLtZNu41WhcDrenYf4T7lcKJTpWfQYy9qQMqO', 'guru', NULL, NULL, 0, '2025-12-01 14:17:03', NULL, NULL),
(4, 'gilang', 'RPL', 'gilang@gmail.com', '$2y$10$ewyyHqm.a3wdSzJqUyeNzeGkfnDmvA7S6UuThfyI1VigrEPQgceSK', 'siswa', NULL, NULL, 0, '2025-12-01 14:36:42', NULL, NULL),
(5, 'yanto S.PD', 'RPL', 'yanto@gmail.com', '$2y$10$5ABfnvgKnNQzAmEC1XUAuee614PQsKu6vkP2ADIBclK9xoOT3wwE6', 'guru', NULL, NULL, 0, '2025-12-02 09:06:15', NULL, NULL),
(6, 'darwin', 'TKJ', 'darwin@gmail.com', '$2y$10$Gg/2m4tPHQYlsYKgiRrkCey6I5gMq/SLO.AjAzQEiGZ2dCdRxBr4W', 'siswa', NULL, NULL, 0, '2025-12-02 13:21:01', NULL, NULL),
(7, 'alfan', 'TKJ', 'alfan@gmail.com', '$2y$10$CU7uxP2ArKNFtVgO9rQS4eE9K7C88i9dHDHzZzZjf2Akp9gJgN0Yi', 'siswa', NULL, NULL, 0, '2025-12-03 02:04:11', NULL, NULL),
(8, 'davila', 'Multimedia', 'davila@gmail.com', '$2y$10$DclkqXWTtk92Oos/TbVzOOPdEF1Z3O/8/K0o1273SiHsk85CG8Q7q', 'guru', 'uploads/profiles/692fde2bae22f_lovepik-book-cartoon-illustration-png-image_401539554_wh1200.png', NULL, 0, '2025-12-03 06:52:27', NULL, NULL),
(9, 'bunga', 'Akuntansi', 'bunga@gmail.com', '$2y$10$EAJ041MFS8fIgPqc3J94j.Dt9Z2xfzVttzu/T.8BJ3X4aL3tgFfGi', 'guru', NULL, NULL, 0, '2025-12-10 06:03:22', NULL, NULL),
(10, 'rahma', 'Pemasaran', 'rahma@gmail.com', '$2y$10$wcwh2nVmAuU0.bpSUxMwg.EuhVFU0ImRFytX4ZyTWh.1Ka501UmNG', 'guru', NULL, NULL, 0, '2025-12-10 11:34:57', NULL, NULL),
(11, 'budiono', 'TKJ', 'budiono@gmail.com', '$2y$10$KDNvBBpVdI7ZcmOvN5stsOewi03OraKvT8ED.9oCocF5cKOqJwE0O', 'guru', NULL, NULL, 0, '2025-12-12 10:39:15', NULL, NULL),
(12, 'gamang', 'TKJ', 'gamang@gmail.com', '$2y$10$cVh.0ilxXojwbCuiOqzWrOMY41qjyUNKIuN5gNlaqodGe7CcpU786', 'siswa', NULL, NULL, 0, '2025-12-21 02:13:40', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `diskusi_reply`
--
ALTER TABLE `diskusi_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reply_diskusi` (`diskusi_id`),
  ADD KEY `fk_reply_user` (`user_id`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ujian_id` (`ujian_id`,`siswa_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ujian_id` (`ujian_id`,`siswa_id`,`soal_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`ujian_id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_soal`
--
ALTER TABLE `bank_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;

--
-- AUTO_INCREMENT for table `diskusi`
--
ALTER TABLE `diskusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `diskusi_reply`
--
ALTER TABLE `diskusi_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD CONSTRAINT `diskusi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diskusi_reply`
--
ALTER TABLE `diskusi_reply`
  ADD CONSTRAINT `fk_reply_diskusi` FOREIGN KEY (`diskusi_id`) REFERENCES `diskusi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reply_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_ujian_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jawaban_siswa`
--
ALTER TABLE `jawaban_siswa`
  ADD CONSTRAINT `jawaban_siswa_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_siswa_ibfk_3` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_scores`
--
ALTER TABLE `quiz_scores`
  ADD CONSTRAINT `quiz_scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
