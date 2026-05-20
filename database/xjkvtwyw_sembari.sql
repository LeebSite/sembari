-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Bulan Mei 2026 pada 11.48
-- Versi server: 10.5.29-MariaDB-cll-lve
-- Versi PHP: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xjkvtwyw_sembari`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','super_admin') NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'adminbalai@gmail.com', 'adminbalai', '$2y$12$Pf2EdaW/MZok4rbiuDqoXOrjisIAHjg0EYVn1CjDUncZGiae11cRe', 'super_admin', '2026-02-13 23:46:45', '2026-02-13 23:46:45'),
(2, 'zakiyahkk017@gmail.com', 'Kiki', '$2y$12$s7i7CkaV7dQj8lNB1Snqg.IUCEuhsmQm.UrZAwyXd/X9AVQUe2Esi', 'admin', '2026-02-24 00:03:33', NULL),
(3, 'testingsembari@gmail.com', 'sembari', '$2y$12$flzEaG/kF6leExxZUDEjxupeLCO.lc5eNCBAj8aISOVIhvPV/gsYm', 'super_admin', '2026-03-16 21:16:21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `detail` text DEFAULT NULL COMMENT 'Penulis, Penerjemah, Editor, dll',
  `license` enum('Buku Edisi Terbatas','Buku Edisi Umum') DEFAULT NULL,
  `tahun_terbit` smallint(6) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL COMMENT 'Path ke file PDF buku',
  `cover_image` varchar(255) DEFAULT NULL COMMENT 'Cover untuk thumbnail frontend',
  `reading_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `daerah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `slug`, `description`, `detail`, `license`, `tahun_terbit`, `pdf_file`, `cover_image`, `reading_level_id`, `daerah_id`, `created_at`, `updated_at`) VALUES
(3, 'Asal Mula Desa Bedari', 'asal-mula-desa-bedari', NULL, 'Penulis : Darmaiyah\r\nPenerjemah : Abd Aziz\r\nPenyunting : Ahmad Nawari, Irwanto\r\nIlustrator : Sunadar Imam Saputro\r\nPenata Letak : Remi Guswand', 'Buku Edisi Umum', 2021, 'books/J7D8tZXM90i66f0F1q3ZkBJwrsejnNlts0yFZHts.pdf', 'covers/GaAuVjuGwtYfgmLCJcRF0P0rB4m4K1FiJm62xE3A.png', 14, 3, '2026-02-22 00:39:10', '2026-03-08 21:17:38'),
(4, 'Selendang Delima', 'selendang-delima', 'Cerita rakyat ini mengisahkan seorang anak yang bernama Selendang Delima. Selendang Delima terlahir dari perut seorang ibu yang hamil karena memakan buah delima yang dilarang oleh abangnya. Selendang Delima kecil hidup dalam penderitaan akibat disiksa oleh enam orang adik\r\nipar Raja. Awalnya, kejadiannya ini tidak diketahui oleh Raja. Berkat syair yang dilantukan Selendang Delima, Raja pun mengenali kejadian itu.\r\nAkhirnya, Raja murka dan akan menyiksa putri yang berenam, termasuk istrinya. Putri Bungsu karena\r\ntelah memberikan penyiksaan yang dialami Selendang Delima. Mengetahui raja murka, Selendang Delima meminta rencana raja dibatalkan karena Selendang Delima sudah memaafkan semua orang yang bersalah.\r\nSifat pemaaf Selendang Delima, akhirnya meredam amarah raja. Itulah kisah tentang Selendang Delima yang hidup di masyarakat Rokan Hilir, Provinsi Riau. Kisah yang syarat dengan nilai dan pesan moral ini merupakan cerita rakyat yang sebelumnya hanya dituturkan dari generasi ke generasi.', 'Penulis : Irsal Fauzana\r\nPenerjemah : Wawan Safie\r\nPenyunting : Ahmad Nawari,  Adeliany Azfar\r\nIlustrator : Sunandar Imam\r\nPenata Letak : Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/qEesgPjsaXnXINaANM6F4XnctjsPVWZu963J8dmX.pdf', 'covers/behQ3ClVTZJaTiPiOiC7Z9UGvD1FuBABI6kP3xXy.png', 15, 10, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(5, 'Sungai Musuh Kampung Bekawan', 'sungai-musuh-kampung-bekawan', 'Buku berjudul Sungai Musuh Kampung Bekawan ini menceritakan keseharian masyarakat suku Akit di Tanjung Samak, Pulau Rangsang, Kepulauan Meranti. Kisah ini tentang kearifan lokal mereka dalam menjaga hutan sebagai tempat tinggal mereka dan kemampuan mereka dalam beradaptasi dengan perkembangan zaman.', 'Penulis: Sohibul Ahyar & Kaza\r\nPenerjemah: Zulpikal\r\nPenyunting: Noezafri Amar, Irwanto\r\nIlustrator: Sohibul Ahyar & Kaza\r\nPenata Letak: Azhar Bambang Gultom\r\nISBN: 978-623-99145-3-0', 'Buku Edisi Umum', 2021, 'books/dmqOl97EZoDX3ylA2TbahOlxDYuGcxZRSxrUUyMq.pdf', 'covers/kgy0xEzFp9Dx2z88xQ7p2ZCWU5AdxzRjU5WdLlxb.png', 14, 6, '2026-02-23 02:24:48', '2026-03-08 21:21:14'),
(7, 'Asal Mula Desa Gajah Sakti', 'asal-mula-desa-gajah-sakti', 'Daerah itu dulu adalah hutan. Banyak kayu besar di dalamnya. Ada juga binatang besar seperti gajah dan rusa. Kemudian hari, hutan itu menjadi pemukiman penduduk. Banyak pula ladang minyak di sekitarnya. Tapi, suatu hari seekor gajah besar tiba di daerah itu. Warga menyebutnya; “gajah tasosek”. Artinya gajah tersesat. Saat orang ramai, datanglah Pak Sakti. Ia berkata akan mengikat gajah itu. Saat tali dia coba lemparkan, gajah itu mengamuk sehingga memukul Pak Sakti dengan\r\nbelalainya. Seketika itu juga Pak Sakti wafat. Sejak itu, daerah tersebut dinamakan “Desa Gajah Sakti”.', 'Penulis: Andi Mulya\r\nPenerjemah: Salahudin Al Asadullah\r\nPenyunting: Yalta Jalinus, Irwanto\r\nIlustrator: M. Zaenal Muttaqien, S.Ag.\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/8BKHGSWpUBxfcSZVONNR36pgjjYNdIXWKVlb66nv.pdf', 'covers/rsusle2YuMtCV9rdtJbPlb0GifqZlUs1nGtsOypW.jpg', NULL, 1, '2026-03-05 00:01:14', '2026-03-08 21:17:56'),
(8, 'Asal Mula Desa Pusaran', 'asal-mula-desa-pusaran', 'Beberapa pengembara menempati sebuah hutan di tepi sebuah sungai. Rombongan pengembara itu kehabisan bekal sehingga berencana akan ke kota. Sebelum berangkat ke kota, para pengembara membuat perahu. Tibalah saatnya mereka melaju di sungai.  Tiba-tiba langit mendung, hujan badai, dan munculah pusaran air. Para pengembara melompat dari perahu dan berenang ke tepian. Perahu itu ditelan pusaran. Keesokan harinya, mereka membuat dua perahu yang baru. Jika pusaran datang lagi, mereka siap merelakan perahu kecil ditelan pusaran. Ternyata benar, pusaran memangsa satu perah lagi. Para pengembara segera meminta izin pada  penunggu sungai. Perjalanan pun lancar. Pusaran air pun tidak pernah muncul lagi.', 'Penulis: Dahlia, S.Pd.\r\nPenerjemah: Mahyaruddin, S.Pd.\r\nPenyunting: Ahmad Nawari, Marlina\r\nIlustrator: Sunandar Imam Syahputro\r\nPenata Letak: Azhar Bambang Gultom', 'Buku Edisi Umum', 2021, 'books/A61yAVs7AHMzNWHqHCXwpeFfb2kY1zFW4bjn0EFB.pdf', 'covers/gjuWv7bqQmsFcKws2N2VgPuNaQJJHZVRAlwCaKrg.jpg', NULL, 3, '2026-03-05 00:06:44', '2026-03-08 21:18:17'),
(9, 'Asal Mula Nama Air Tiris', 'asal-mula-nama-air-tiris', 'Air Tiris merupakan nama sebuah Ibukota kecamatan yang terdapat di Kabupaten Kampar. Asal\r\nmula terjadinya nama air tiris berasal dari cerita seorang pemuda yang baik budi saat diseret ikan tapa raksasa selama berharihari, lalu sampai di sebuah daerah yang memiliki kerajaan. Di kerajaan tersebut dia diangkat menjadi panglima. Suatu hari, panglima mengajak ibunya melihat kuburan ayahnya. Namun, terjadi sesuatu yang menakjubkan. Ibunya menangis karena tidak bisa menemukan kuburan suaminya. Tangis Mak tidak bisa berhenti sehingga air matanya mengalir\r\nsampai menenggelamkan desa tempat panglima Khatib dibesarkan.', 'Penulis: Zulkaidah\r\nPenerjemah: Aprianto\r\nPenyunting: Noezafri Amar, Adeliany Azfar\r\nIlustrator: Endi Astiko\r\nPenata Letak: Azhar Bambang Gultom', 'Buku Edisi Umum', 2021, 'books/cxjnCSydKaMvqhGxJGl5sYsv7pv0kTxSFqNIiIWY.pdf', 'covers/FlRrj2HiPedBtvwPwmaqPzBULfQMbmn7lHV49Yqb.jpg', NULL, 5, '2026-03-05 00:13:23', '2026-03-05 00:13:23'),
(10, 'Asal Usul Danau Naga Sakti', 'asal-usul-danau-naga-sakti', 'Cerita ini tentang asal usul nama Danau Naga Sakti yang berada di Kampung Dosan Kecamatan Pusako, Kabupaten Siak. Kisah ini bermula dari seorang perempuan yang melahirkan anak kembar, satu di antara anaknya berwujud naga dan diberi nama si Jalar. Tubuh anak naga tersebut semakin hari semakin besar dan penduduk kampung takut kalau dia akan membunuh manusia dan hewan peliharaan. Akhirnya mereka berencana menangkap si Jalar. Akan tetapi, naga besar itu berhasil selamat. Dia hidup menetap di danau yang airnya berwana hitam. Penduduk sering melihat sosok naga itu keti ka mereka berada di sana. Akhirnya, mereka menamakan danau tersebut dengan nama “Danau Naga Sakti”.', 'Penulis: Fery Mulyadi, S.H.I.\r\nPenerjemah: Musyrifah\r\nPenyunting: Noezafri Amar, Irwanto\r\nIlustrator: Fery Mulyadi, S.H.I.\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/kJzU7uitb0ZBxvae4Du6ijRr7d8a1SMUrXmnL3n6.pdf', 'covers/G4Pw1RuOYwNN46flIAIPKA0xHWP8qYJzrW4807Zh.jpg', NULL, 12, '2026-03-05 00:17:56', '2026-03-05 00:17:56'),
(11, 'Asal Usul Ikan Patin', 'asal-usul-ikan-patin', 'Awang tinggal bersama ibunya  yang sudah tua. Suatu hari, ia berminat pergi ke Kuala. Saat itu ia tertidur dan bermimpi ibunya mendapat sepasag burung merpati. Mendapatkan mimpi tersebut, ia khawatir telah terjadi sesuatu pada ibunya, ia pun bergegas pulang. Namun dalam perjalanan, ia menemukan seorang bayi cantik di pinggir hutan. Awang memungut bayi tersebut dan membesarkannya bersama ibunya dengan penuh cinta. Bayi tersebut diberi nama Dayang. Ia tumbuh menjadi gadis cantik, ia pun dipinang pemuda baik-baik. Mereka menikah dan memiliki tiga orang anak. Setelah Awang meninggal, Dayang selalu muram. Suatu ketika, Bujang, suaminya, berhasil membuat Dayang tertawa. Akan tetapi, ia berubah menjadi ikan yang cantik. Rakyat Indragiri menyebutnya ikan patin.', 'Penulis: Andi Mulya\r\nPenerjemah: Apriandi Arifwan\r\nPenyunting: Ahmad Nawari, Adeliany Azfar\r\nIlustrator: M. Zaenal Muttaqien\r\nPenata Letak: Fandi Agusman', 'Buku Edisi Umum', 2021, 'books/8JL8EdK6c3CQelO4AtVKFeQmbSNaAQSvN3sXe8FT.pdf', 'covers/ZklYhJGbo05k7MYgTXPDL1CbmExu8R8G2JztPLKf.jpg', NULL, 4, '2026-03-05 00:23:03', '2026-03-08 21:18:59'),
(12, 'Buaya Batang Gaharu', 'buaya-batang-gaharu', 'Semenjak subuh, suasana di Bukit Batu terlihat biasa-biasa saja,  baik cuacanya maupun keadaan di sekitar kampung. Seperti  biasa, orang-orang dan pedagang lalu lalang, kereta dan pedati hilir mudik. Begitu juga dengan kedai gorengan dan ketupat sayur paku yang selalu ramai dikunjungi orang. Akan tetapi, setelah Zuhur ketika  matahari hendak melintas di pertengahan batas langit, mulailah orang datang ke dermaga dengan beramai-ramai karena ada seekor buaya yang mengambang melintas di sekitar jembatan. Perahu-perahu pedagang yang sedang hilir mudik kembali merapat ke tepi  kanal jembatan.  Orang-orang yang berada di atas perahu berhamburan ke darat  karena penasaran ingin  melihat buaya yang sedang melintas itu. Waiau perlahan tapi jelas terlihat kulit berdurinya yang keras dan kusam gelap lebam  seperti  ada sedikit Iuka dan bersisik.\r\nSaat itu  muncullah Rosmali dalam kerumunan, dia bermaksud hendak mengusir buaya dengan batang tonggal. Tindakannya  itu  menarik perhatian semua orang. Rosmali sangat bernafsu ingin  melawan buaya. Bagaimanakah kisah berikutnya? Dapatkah Rosmali mengusir buaya itu? Apa yang terjadi dengan Rosmali?', 'Penulis: Agus DS\r\nPenerjemah: Pauzun\r\nPenyunting: Noezafri Amar, MArlina\r\nIlustrator: Agus DS\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/HNLlo5ZU7m4rgNFKS1gY9Ne6BtNhiSoehEInIWxg.pdf', 'covers/3gTMyq6popjzjJsY8yrelMmdYQSaNTYfW0PyaMQT.jpg', NULL, 1, '2026-03-05 00:30:14', '2026-03-05 00:30:58'),
(13, 'Bujang Manja', 'bujang-manja', 'Keluarg Tolamah hidup dengan sangat sederhana, rumah panggung dinding papan, beratapkan rumbia, tidaklah membuat keluarga ini lelah beramal baik. Mereka suka bersedekah pada anak yatim piatu dan orang fakir miskin. Tolamah memiliki seorang suami yang bekerja sebagai nelayan di laut. Selama beberapa hari suami Tolamah tidak melaut dan sibuk membantu Tolamah berjualan. Pada suatu hari beberapa orang suku pedalaman yang singgah di kedainya. “Kami ini mau membeli tembakau, tetapi kami tidak ada uang, namun jika Puan berkenan kami bayar dengan anak harimau ini,” sambil menunjuk anak harimau tersebut yang dirangkulnya. “Bayar dengan anak harimau?” Tolamah merasa sangat heran antara percaya atau tidak. Tolamah mencubit-cubit pipi dan tangannya. Bagaimana akhir dari kisah ini. Apakah Tolamah akan menerima anak harimau \r\ntersebut dan memliharanya. Mari baca cerita rakyat ini sampai akhir.', 'Penulis: Agus DS\r\nPenerjemah: Robi Komari AA\r\nPenyunting: Noezafri Amar, Irwanto\r\nIlustrator: Agus DS\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/EQT1lu0uHWuir1wdpNiBxtJO1hKQ4OIr0jNhf0VX.pdf', 'covers/42aPnDcVHZNlQFdH0XHPOKqhhbd9Ole7Wi5ODYnR.jpg', NULL, 2, '2026-03-05 00:33:01', '2026-03-08 21:17:02'),
(14, 'Cinta Raja Rokan Terkubur di Kersik Putih', 'cinta-raja-rokan-terkubur-di-kersik-putih', 'Raja Rokan Sakti Ibrahim adalah raja terakhir dari Kerajaan Rokan IV Koto di Kecamatan Rokan IV Koto, Kabupaten Rokan Hulu. Raja Ibrahim merupakan Raja kesebelas yang memerintah di Luhak\r\nRokan IV Koto. Raja Rokan Ibrahim yang bergelar Yang Dipertuan Sakti tersebut memotong kerbau\r\nsebanyak dua belas ekor untuk jamuan selama tujuh hari sebelum dinobatkan oleh Tengku Ibrahim menjadi raja dalam Luhak Rokan IV Koto. Dalam kisah cinta Raja Rokan di Kersik Putih, meninggalkan aturan adat yang masih berlaku sampai sekarang, salah satunya anak gadis Kersik Putih dilarang keras untuk dimadu. Bagaimanakah kisah cinta Raja Rokan yang mengharukan? Ketika sudah tujuh tahun menikah, tapi belum juga dikaruniai keturunan? Sanggupkah Raja menceraikan Siti Zulaiha yang dicintainya, tapi tidak sudi dimadu? Jawabannya ada di dalam buku Cinta Raja Rokan Terkubur di Kersik Putih.', 'Penulis: Arnita Adam\r\nPenerjemah: Hamdi Saputra\r\nPenyunting: Ahmad Nawari, Adeliany Azfar\r\nIlustrator: Sunandar Imam Syahputro\r\nPenata Letak: Fandi Agusman', 'Buku Edisi Umum', 2021, 'books/vRYy4I8OsW0QA4s2hzAHvzbpHHtwtulLLHsHhOPv.pdf', 'covers/knsQs4UkrDKdJ7djYONH7PaflCBVx8QZAReD8K57.jpg', NULL, 11, '2026-03-05 00:37:05', '2026-03-05 00:37:05'),
(15, 'Daerah Itu Bernama Sikijang Mati', 'daerah-itu-bernama-sikijang-mati', 'Ongku Mudo Incin maju selangkah untuk mendekat supaya binatang itu mundur. Akan tetapi, hewan itu diam saja. Ongku Mudo Incin semakin tidak paham. Apa gerangan yang terjadi? Kemudian, diperhatikannya baik-baik. Akhirnya dia tahu bahwa binatang itu adalah seekor kijang.\r\nTanduknya bercabang tiga. Tanduknya itu tersangkut di akar-akar rotan. Namun, tampaknya kijang itu telah lama mati. “Ada kijang mati, Ongku,” kata Wak Atan, rekan Ongku Mudo Incin. Rupanya, lelaki itu pun ikut memperhatikan.', 'Penulis: Fitri Mayani, S.S.\r\nPenerjemah: Emilia. KH, S.Hum., M.M.\r\nPenyunting: Noezafri Amar, Adeliany Azfar\r\nIlustrator: Endy Astiko\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/mMbfmYF9urLaduosid6J2JNXNQx4LO5Y7M0YGiyf.pdf', 'covers/pMxyt94Y5WHrzR4YlK0tWJMipaYHAQReO9wbsHFa.jpg', NULL, 9, '2026-03-05 00:38:51', '2026-03-05 00:38:51'),
(16, 'Dan Dendang', 'dan-dendang', 'Pada zaman dahulu hiduplah sepasang suami istri di Indragiri Hilir. Mereka hidup sebagai petani. Ketika sang istri sedang hamil, ia mengidam makan udang dari telaga yang tidak jauh dari tempat \r\ntinggalnya. Di telaga itu, hidup seekor raja buaya bernama Dan Dendang. Sang Petani diizinkan mengambil udang di telaganya dengan syarat, apabila anaknya yang akan lahir itu seorang perempuan, maka harus dinikahkan dengan Raja Buaya ketika berusia 20 tahun. Bagaimanakah nasib anak petani tersebut selanjutnya?', 'Penulis: Mulyati Umar\r\nPenerjemah: Akmaludin\r\nPenyunting: Noezafri Amar, Adeliany Azfar\r\nIlustrator: Sunandar Iman\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/qmHvz1U3Z5mL7SPqUFfc9CLdS8iF752oUplVzpD8.pdf', 'covers/TbWLDlUFVP0x73FLvp5b0Mply8E06qZnSvkqGCfC.jpg', NULL, 3, '2026-03-05 00:40:43', '2026-03-05 00:40:43'),
(17, 'Datuk Lelo Ajo dan Pulau Berlayar', 'datuk-lelo-ajo-dan-pulau-berlayar', 'Alkisah, ada seorang datuk yang bernama Lelo Ajo. Suatu hari Sultan Siak memerintahkan Datuk \r\nLelo Ajo untuk mencari obat. Datuk Lele Ajo pun menempuh perjalanan didampingi seorang pengawal istana. Perjalanannya sangat lama, sehingga bekal nasi goreng buatan istrinya tidak mencukupi. Di sebuah hutan, Datuk Lelo Ajo menemukan buah ajaib. Kemudian ia menaiki Pulau Berlayar. Akankah Datuk Lelo Ajo dan sang Pengawal memakan buah itu? Lalu, akan sampai dimanakah ketika beliau menaiki Pulau Berlayar? Yuk, baca cerita rakyat ini sampai habis! Semoga cerita ini bisa memberi manfaat bagi banyak orang, bisa menumbuhkan rasa cinta terhadap cerita  dari negeri sendiri. Salam literasi. Semangat membaca.', 'Penulis: Kamalia, S.Pd.\r\nPenerjemah: Nurbalian Noviani\r\nPenyunting: Noezafri Amar, Irwanto\r\nIlustrator: Endi Estiko\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/fiRFTdwnjO22d5ZtVPZFl4VegAHmJveHjhUJT0Av.pdf', 'covers/ehc13785P8ba6NcY98lwAYspyQF0aochwNFYLZ0I.jpg', NULL, 10, '2026-03-05 00:44:08', '2026-03-08 21:16:14'),
(18, 'Dubalang Alam', 'dubalang-alam', 'Buku ini menceritakan tentang anak lelaki  yang diti nggal sendiri oleh ibunya. Sebab, ibunya pergi ke ladang untuk menuai padi. Anak lelaki tersebut harus berjuang pergi mengaji dalam ketakutan kerena sering dimata-matai oleh Dubalang Alam. Siapa sebenarnya Dubalang Alam? Dan mengapa\r\nDubalang Alam melakukan hal yang demikian. Ingin tahu seperti  apa kisah Dubalang Alam secara lengkap? Mari baca buku cerita rakyat masyarakat Riau ini dari awal hingga akhir. Banyak pelajaran hidup dan hikmah yang bisa diambil dari perjalan hidup seorang anak lelaki yang ditinggal ibunya.', 'Penulis: Nur Atika\r\nPenerjemah: Arasti Okti Rahmi\r\nPenyunting: Yalta Jalinus, Marlina\r\nIlustrator: Sunandar Imam Syahputro\r\nPenata Letak: Fandi Agusman', 'Buku Edisi Umum', 2021, 'books/FHFbDtj7rvIZG9F0MPiWvfr4YJHDt85WIYRjqOho.pdf', 'covers/IKgEG7qWMpD794SA6PwuVIOuNpykF0gcKKvjlIsh.jpg', NULL, 11, '2026-03-05 00:45:57', '2026-03-08 21:15:59'),
(19, 'Legenda Batang Paing', 'legenda-batang-paing', 'Di Kuantan Singingi, Riau, si Raja Hutan Harimau Paing dipercaya sebagai ‘Penunggu Batang Paing’. Mereka biasa memanggilnya Datuk Belang. Datuk Belang yang dipercaya sebagai penunggu \r\nBatang Paing, akan mengaum dan keluar dari persembunyiannya apabila ada warga kampung yang\r\nmelanggar adat dan norma-norma yang berlaku di tengah masyarakat. Dikisahkan, Pak Oman yang bermukim di kawasan Batang Paing, bertemu Datuk Belang saat pergi menyadap karet hingga pertemuannya dengan seorang bapak tua yang tak dikenalnya yang menitip pesan agar tidak menyadap karet hingga lima belas hari kedepan, dan juga kisah heroiknya menyelamatkan anak Datuk Belang yang jatuh ke jurang yang sangat dalam. Bagaimana nasib Pak Oman selanjutnya? Yuk, baca cerita rakyat Legenda Batang Paing ini dari awal hingga akhir. Semoga bacaan ini memberi nilai edukatif yang sarat dengan pesan moral. Selamat membaca!', 'Penulis: Aswidiarti\r\nPenerjemah: Diky Yuandi\r\nPenyunting: Ahmad Nawawi, Adeliany Azfar\r\nIlustrator: Endi Estiko\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', 2021, 'books/GsnQKXGLaLPuqJpjgmFf0NkFXW0rktpGDtCGsryq.pdf', 'covers/4jSm5H8QOQP1l1PNGvQ09VVhUHnOgItSlduMTRyy.jpg', NULL, 7, '2026-03-06 01:04:17', '2026-03-06 01:04:17'),
(20, 'Legenda Batu Tobat', 'legenda-batu-tobat', 'Di sebuah desa bernama Rantau Langsat di Indragiri hulu, terdapat sebuah sungai yang \r\nairnya jernih dan kaya dengan jenis-jenis ikan. Pada suatu hari, sungai itu dipenuhi batu-batu raksasa sehingga aliran sungai mengecil dan ikan pun susah dicari. Hal ini membuat penduduk desa gelisah. Ternyata, batu-batu raksasa itu berasal dari bukit. Atas ulah Siklambai, batu-batu itu menutup aliran sungai. Siklambai mau menguasai kawasan sungai. Ulah jahat Siklambai pun segera ditaklukan oleh dua pemimpin yang sangat mencintai rakyatnya, yaitu Datuk Kuntum dan Datuk Reges. Desa kembali aman dan sungai kembali normal, meskipun masih terdapat beberapa batu penghalang (batu tobat) di tepian sungai.', 'Penulis: Listi Mora Rangkuti\r\nPenerjemah: Binta Milyanniarti\r\nPenyunting: Noezafri Amar, Marlina\r\nIlustrator: Sunandar Imam Syahputro\r\nPenata Letak: Azhar Bambang Gultom', 'Buku Edisi Umum', NULL, 'books/GWrZ3jxuFfO93apQfq7nEGEPR5DJKJzNPauxqBtK.pdf', 'covers/iBtbBc3irVs6BhtKJvcztK76mrYai6WNxYc8CfMG.jpg', NULL, 4, '2026-03-06 01:06:20', '2026-03-06 01:06:20'),
(21, 'Legenda Umbut Muda', 'legenda-umbut-muda', 'Legenda Umbut Muda “UMBUT, canti k sekali dirimu. Bolehkah kami meminjam gelang kepunyaanmu itu?” teman-teman umbut menyapa. “Iya, aku memang canti k. Kalian tahu kenapa aku canti k? Sebab, diriku merawat wajah. Selain itu, aku punya pakaian bagus dan perhiasan. Jika kalian ingin cantik, kalian harus berusaha sendiri. Jangan hanya meminjam barang-barangku \r\nkarena barang milikku sangat mahal. Kalian ti dak akan sanggup untuk membelinya!” jawab Umbut kepada teman-temannya.', 'Penulis: Sugiarti\r\nPenerjemah: Winda Harniati,M.Pd.\r\nPenyunting: Ahmad Nawari, Irwanto\r\nIlustrator: Reni Lestari\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', NULL, 'books/OhgE3pgbXbZVWEG5j5DHYKnsZfX9h33Hm4uTc0y1.pdf', 'covers/0ZumLY8ipBZL84rNNf6dPlDYyq3HeLP7e0DwDxlc.jpg', NULL, 12, '2026-03-06 01:08:26', '2026-03-08 21:15:17'),
(22, 'Mancaka, Legenda Batang Kinang', 'mancaka-legenda-batang-kinang', 'Dahulu kala kata orang-orang, Bangkinang hanya hamparan sawah sejauh mata memandang yang dipagari Bukit Batang Kinang tempat muasal air Sungai Sonsang menghilir dan bermuara ke Sungai Kampar. Sungai mengalir tenang. Pada tepiannya yang dipagari hutan belantara itulah sekelompok orang berjalan tidak tahu arah. Mereka ditangkap dan dikurung oleh para pendekar. Lalu, dua di antara mereka lari, seorang ibu muda dan anak lelakinya menyusuri sungai di tengah malam menuju entah ke mana. Si anak lelaki, Mancaka, berguru dengan pendekar masyhur di Ulak. Setelah dirasa cukup, ia kembali menjemput saudara-saudaranya yang baru bisa dibebaskan jika ia memenangkan \r\npertarungan. Berhasilkah Mancaka? Inilah kisah cikal bakal Kampung Deliong, sebuah desa di tepi \r\nSungai Kampar. Kisah yang bermula dari pertaruhan sebuah marwah yang harus dijunjung tinggi                 meski nyawa taruhannya.', 'Penulis: Hendri Burhan\r\nPenerjemah: Amelia Anggraini\r\nPenyunting: Yalta Jalinus, Marlina\r\nIlustrator: Hendri Burhan\r\nPenata Letak: Fandi Agusman', 'Buku Edisi Umum', NULL, 'books/0sZ2X0we9pvBiLP7k81kY1YZz4xtIGmxJ0Ipimbg.pdf', 'covers/KD7gZKQosmZbNQuKsPixnEQ3p86g6XpSIgEGgGPy.jpg', NULL, 5, '2026-03-06 01:12:07', '2026-03-06 01:12:07'),
(23, 'Nago Balengko', 'nago-balengko', 'Lambang Kerajaan Pelalawan, sebuah kerajaan Melayu di Provinsi Riau yang sudah berdiri sejak \r\nabad ke 14, yang antara lain berupa dua ular naga bermahkota saling berhadapan ternyata memiliki\r\nkisahnya sendiri. Naga tersebut konon merupakan jelmaan sorban Tuanku Lintau. Dikisahkan, sorban Tuanku Lintau berubah menjadi naga setelah serdadu Belanda membunuh penjuang agam Islam pada masa Perang Paderi di Sumatra Barat tersebut. Bagaimana sorban Tuanku Lintau bisa berubah menjadi ular naga? Lalu kaitannya dengan Sungai Nago Balengko? Silahkan dibaca buku ini dari awal sampai akhir. Selamat membaca!', 'Penulis: Budi Suseno\r\nPenerjemah: Tengku Hamid Darmawan\r\nPenyunting: Noezafri Amar, Marlina\r\nIlustrator: Ade Permadi Arifﬁ anto\r\nPenata Letak: Remi Guswandi', 'Buku Edisi Umum', NULL, 'books/FUo8tX9BNeRdSneaWFdJdhJUwygcHi3zGnciOvUP.pdf', 'covers/fk0sb0eGzISc61UHds11MEXnDvKcz97bNGCjWMv4.jpg', NULL, 9, '2026-03-06 01:14:09', '2026-03-06 01:14:09'),
(24, 'Paduka Tuan Pitopang di Bukit Keramat', 'paduka-tuan-pitopang-di-bukit-keramat', 'Konon katanya, pada zaman dahulu, Kuantan Singgihi merupakan daerah yang kering. Orang-orang kampung telah melakukan berbagai usaha. Namun, tidak juga membuahkan hasil. Hingga akhirnya,\r\nwarga sepakat untuk mencari penyebabnya. Semua mulai mencari-cari kesalahan apa yang pernah diperbuat oleh orang kampung. Tuduhan jatuh pada orang asing yang baru tiba. Orang kampung berniat mengusirnya. Suatu hari, seorang laki-laki yang baik dan rajin beribadah bertemu orang asing. Orang asing mengingatkan agar pemuda itu mengajak warga kampung berdoa. Benar\r\nsaja, setelah berdoa bersama, sumber air mulai ditemukan dan mengaliri kampung mereka. Orang asing itu lalu diberi nama Paduka Tuan Pitopang.', 'Penulis: Yulismar\r\nPenerjemah: Villa Indah Delﬁ a\r\nPenyunting: Yalta Jalinus, Adeliany Azfar\r\nIlustrator: Hendri Burhan\r\nPenata Letak: Azhar Bambang Gultom', 'Buku Edisi Umum', NULL, 'books/3OIycu2jwS1ykQko4oMAwXearWYUxDpHt1HOU4Rq.pdf', 'covers/XFKOOp0bneJCAyNB5ucVgEN4oHt9gaV3xAmSODo6.jpg', NULL, 7, '2026-03-06 01:16:19', '2026-03-06 01:16:19'),
(25, 'Puti Pitopang', 'puti-pitopang', 'Penulis: Afrinaldi, dkk.\r\nPenerjemah: Salman Aziz\r\nPenyunting: Yalta Jalinus, Adeliany Azfar\r\nIlustrator: Afrinaldi, dkk\r\nPenata Letak: Azhar Bambang Gultom', 'Pada masa dahulu, ada seorang gadis berparas cantik, perangai elok dan kaya. Gadis itu dipanggil Puti Pitopang. Puti Pitopang memiliki tanah yang luas di area atas dan area bawah. Ia suka menolong siapa pun. Puti Pitopang banyak memberi tanah kepada orang lain untuk berkebun dan membangun rumah. Banyak lelaki yang meminang Puti Pitopang. Namun tidak seorang pun yang diterima pinangannya oleh Puti Pitopang. Sampai suatu ketika, datanglah pinangan dari orang yang tidak mungkin ditolak oleh Puti Pitopang. Seperti apa nasib Puti Pitopang selanjutnya? Apa keputusan yang diambil oleh Puti Pitopang? Selamat membaca.', 'Buku Edisi Umum', NULL, 'books/pzs9jrUnthUwZcBHrkmeSl5YqNJz7B6LcWCx98Qt.pdf', 'covers/uoqpnuYNMAMVzUDJ32gaytkcrWZqv41BqXoQ2zIh.jpg', NULL, 5, '2026-03-06 01:18:39', '2026-03-08 21:13:18'),
(26, 'Satu, Dua, Tiga, Tarik!', 'satu-dua-tiga-tarik', 'Satu, Dua, Tiga Tarik! bercerita tentang sebuah tradisi yang sudah turun-temurun di Kuantan Singingi. Tradisi itu dinamakan menarik jalur yaitu bagian dari prosesi pacu jalur yang telah menjadi warisan budaya masyarakat Kuantan Singingi, Provinsi Riau Ada hal yang berubah dari tradisi itu, yaitu cara tradisional masyarakat dalam menarik jalur dipengaruhi oleh berbagai perkembangan. Hal itu sekaligus menggerus nilai-nilai yang terkandung di dalamnya, kebersamaan, kerja keras, sosial, dan lain-lain. Penasaran dengan tradisi menarik jalur? Silahkan baca buku Satu, Dua, Tiga Tarik! dari awal hingga akhir.', 'Penulis: Ira Mairiyanti\r\nPenerjemah: Tiara Bella Pratiwi\r\nPenyunting: Yalta Jalinus, Marlina\r\nIlustrator: Dadang Surya\r\nPenata Letak: Fandi Agusman', 'Buku Edisi Umum', NULL, 'books/ughPy5RjiAkSbqGPEVA5LddP8G8MuJvSyOecVf2W.pdf', 'covers/kW74X2aj7V18iDTnGTvz8KLkVdXTuLzaz17jjcr9.jpg', NULL, 7, '2026-03-06 01:20:20', '2026-03-07 18:16:55'),
(27, 'Caito Odan Anak Kuantan', 'caito-odan-anak-kuantan', NULL, 'Penulis: Desti Marlina\nPenerjemah: -\nPenyunting: Riyan Nofardo Putra\nIlustrator: Miftahul Risqa Asmi\nPenelaah: Noezafri Amar\nPenata Letak: Supri Ismadi\nISBN: 978-623-504-194-0 (pdf); 978-623-504-193-3', 'Buku Edisi Umum', 2023, 'books/KsLttSH5BFFXlIoJxqhpJ8ngKHAUddFy6SV1Ukqg.pdf', 'covers/VQuoqlk6xlz0BM8gVtCB3vX6tmpRFIL0n8YuRctX.jpg', 14, 7, '2026-05-18 18:00:23', '2026-05-18 21:41:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_book_type`
--

CREATE TABLE `book_book_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `book_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_book_type`
--

INSERT INTO `book_book_type` (`id`, `book_id`, `book_type_id`, `created_at`, `updated_at`) VALUES
(19, 3, 1, '2026-02-23 02:07:50', '2026-02-23 02:07:50'),
(20, 3, 4, '2026-02-23 02:07:50', '2026-02-23 02:07:50'),
(21, 4, 1, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(22, 4, 2, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(23, 4, 4, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(26, 5, 1, '2026-02-23 02:40:45', '2026-02-23 02:40:45'),
(27, 5, 2, '2026-02-23 02:40:45', '2026-02-23 02:40:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_categories`
--

CREATE TABLE `book_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_categories`
--

INSERT INTO `book_categories` (`id`, `book_id`, `category_id`, `created_at`, `updated_at`) VALUES
(23, 4, 6, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(24, 4, 9, '2026-02-23 02:19:49', '2026-02-23 02:19:49'),
(30, 9, 2, '2026-03-05 00:13:23', '2026-03-05 00:13:23'),
(32, 10, 2, '2026-03-05 00:17:56', '2026-03-05 00:17:56'),
(35, 12, 2, '2026-03-05 00:30:58', '2026-03-05 00:30:58'),
(37, 14, 2, '2026-03-05 00:37:05', '2026-03-05 00:37:05'),
(38, 15, 2, '2026-03-05 00:38:51', '2026-03-05 00:38:51'),
(39, 16, 2, '2026-03-05 00:40:43', '2026-03-05 00:40:43'),
(42, 19, 2, '2026-03-06 01:04:17', '2026-03-06 01:04:17'),
(43, 20, 2, '2026-03-06 01:06:20', '2026-03-06 01:06:20'),
(45, 22, 2, '2026-03-06 01:12:07', '2026-03-06 01:12:07'),
(46, 23, 2, '2026-03-06 01:14:09', '2026-03-06 01:14:09'),
(47, 24, 2, '2026-03-06 01:16:19', '2026-03-06 01:16:19'),
(50, 26, 2, '2026-03-07 18:16:55', '2026-03-07 18:16:55'),
(51, 25, 2, '2026-03-08 21:13:18', '2026-03-08 21:13:18'),
(52, 21, 2, '2026-03-08 21:15:17', '2026-03-08 21:15:17'),
(53, 18, 2, '2026-03-08 21:15:59', '2026-03-08 21:15:59'),
(54, 17, 2, '2026-03-08 21:16:14', '2026-03-08 21:16:14'),
(55, 13, 2, '2026-03-08 21:17:02', '2026-03-08 21:17:02'),
(56, 3, 2, '2026-03-08 21:17:38', '2026-03-08 21:17:38'),
(57, 3, 8, '2026-03-08 21:17:38', '2026-03-08 21:17:38'),
(58, 7, 2, '2026-03-08 21:17:56', '2026-03-08 21:17:56'),
(59, 8, 2, '2026-03-08 21:18:17', '2026-03-08 21:18:17'),
(60, 11, 2, '2026-03-08 21:18:59', '2026-03-08 21:18:59'),
(61, 5, 2, '2026-03-08 21:21:14', '2026-03-08 21:21:14'),
(63, 27, 2, '2026-05-18 21:41:45', '2026-05-18 21:41:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_stats`
--

CREATE TABLE `book_stats` (
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `views_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `likes_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `reads_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_stats`
--

INSERT INTO `book_stats` (`book_id`, `views_count`, `likes_count`, `reads_count`, `created_at`, `updated_at`) VALUES
(3, 54, 4, 111, '2026-02-22 00:39:10', '2026-05-15 00:16:06'),
(4, 43, 2, 27, '2026-02-23 02:19:49', '2026-05-15 09:13:16'),
(5, 59, 5, 48, '2026-02-23 02:24:48', '2026-05-18 20:10:44'),
(7, 24, 2, 11, '2026-03-05 00:01:14', '2026-05-12 21:38:28'),
(8, 21, 0, 10, '2026-03-05 00:06:44', '2026-05-18 17:53:51'),
(9, 23, 0, 12, '2026-03-05 00:13:23', '2026-05-12 23:07:26'),
(10, 23, 0, 11, '2026-03-05 00:17:56', '2026-05-16 01:33:25'),
(11, 16, 0, 8, '2026-03-05 00:23:03', '2026-05-11 02:25:39'),
(12, 19, 0, 8, '2026-03-05 00:30:14', '2026-05-13 16:20:28'),
(13, 23, 0, 11, '2026-03-05 00:33:01', '2026-05-17 17:30:30'),
(14, 23, 0, 10, '2026-03-05 00:37:05', '2026-05-18 16:14:40'),
(15, 17, 1, 10, '2026-03-05 00:38:51', '2026-05-18 15:50:48'),
(16, 16, 0, 6, '2026-03-05 00:40:43', '2026-05-12 11:53:41'),
(17, 13, 0, 6, '2026-03-05 00:44:08', '2026-05-17 10:55:40'),
(18, 20, 1, 11, '2026-03-05 00:45:57', '2026-05-12 22:59:08'),
(19, 21, 0, 13, '2026-03-06 01:04:17', '2026-05-17 15:40:46'),
(20, 19, 0, 9, '2026-03-06 01:06:20', '2026-05-11 02:26:25'),
(21, 11, 0, 4, '2026-03-06 01:08:26', '2026-05-13 11:26:09'),
(22, 25, 0, 15, '2026-03-06 01:12:07', '2026-05-18 07:11:23'),
(23, 32, 0, 16, '2026-03-06 01:14:09', '2026-05-18 21:36:14'),
(24, 37, 0, 16, '2026-03-06 01:16:19', '2026-05-13 11:05:14'),
(25, 32, 1, 27, '2026-03-06 01:18:39', '2026-05-18 21:44:57'),
(26, 38, 0, 24, '2026-03-06 01:20:20', '2026-05-18 18:15:11'),
(27, 3, 0, 3, '2026-05-18 18:00:23', '2026-05-18 18:39:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_types`
--

CREATE TABLE `book_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `book_types`
--

INSERT INTO `book_types` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Anak - Anak', 'anak-anak', '2026-02-18 03:36:32', '2026-02-26 00:50:16'),
(2, 'Fiksi', 'fiksi', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(3, 'Nonfiksi', 'nonfiksi', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(4, 'Pendidikan', 'pendidikan', '2026-02-18 03:36:32', '2026-02-18 03:36:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Alam', 'alam', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(2, 'Cerita Rakyat', 'cerita-rakyat', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(3, 'Edisi Terbatas', 'edisi-terbatas', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(4, 'Ekonomi Kreatif', 'ekonomi-kreatif', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(5, 'Matematika', 'matematika', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(6, 'Pengembangan Diri', 'pengembangan-diri', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(7, 'Sains', 'sains', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(8, 'Seni Budaya', 'seni-budaya', '2026-02-18 03:36:32', '2026-02-18 03:36:32'),
(9, 'Tokoh', 'tokoh', '2026-02-18 03:36:32', '2026-02-18 03:36:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daerah`
--

CREATE TABLE `daerah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `daerah`
--

INSERT INTO `daerah` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Bengkalis', 'bengkalis', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(2, 'Dumai', 'dumai', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(3, 'Indragiri Hilir', 'indragiri-hilir', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(4, 'Indragiri Hulu', 'indragiri-hulu', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(5, 'Kampar', 'kampar', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(6, 'Kepulauan Meranti', 'kepulauan-meranti', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(7, 'Kuantan Singingi', 'kuantan-singingi', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(8, 'Pekanbaru', 'pekanbaru', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(9, 'Pelalawan', 'pelalawan', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(10, 'Rokan Hilir', 'rokan-hilir', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(11, 'Rokan Hulu', 'rokan-hulu', '2026-03-08 00:54:31', '2026-03-08 00:54:31'),
(12, 'Siak', 'siak', '2026-03-08 00:54:31', '2026-03-08 00:54:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `library_tables`
--

CREATE TABLE `library_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_14_064512_create_admin_table', 1),
(2, '2026_02_15_103511_create_library_tables', 2),
(3, '2026_02_15_103523_create_library_tables', 2),
(4, '2026_02_15_103559_create_books_table', 2),
(5, '2026_02_15_103559_create_books_table', 2),
(6, '2026_02_20_194232_add_tahun_terbit_to_books_table', 3),
(7, '2026_02_21_173710_add_icon_to_reading_levels_table', 4),
(8, '2026_02_21_173711_add_icon_to_reading_levels_table', 4),
(9, '2026_02_21_173722_add_icon_to_reading_levels_table', 4),
(10, '2026_02_22_052016_fix_reading_levels_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reading_levels`
--

CREATE TABLE `reading_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reading_levels`
--

INSERT INTO `reading_levels` (`id`, `name`, `icon`, `slug`, `order`, `description`, `created_at`, `updated_at`) VALUES
(13, 'E', 'reading_levels/icons/uV02FvUU7hTScQzSxycYiJbwfOhygnjhZ6T5Z1oy.png', NULL, 7, 'Pembaca Mahir', '2026-02-22 00:27:57', '2026-02-22 01:48:52'),
(14, 'D', 'reading_levels/icons/hZs8Lj39YCFJwdhjiJWyPfvsslZDLh95msqQZWqL.png', NULL, 6, 'Pembaca Madya', '2026-02-22 00:31:24', '2026-02-22 01:49:17'),
(15, 'C', 'reading_levels/icons/yPgpacqEt1QVvVJsIUDFwTFEvcvI0eHUdOQASmi3.png', NULL, 5, 'Pembaca Semenjana', '2026-02-22 00:32:09', '2026-02-22 01:49:47'),
(16, 'B3', 'reading_levels/icons/hrf8RRmbRjXj4LqKZmojlm6wLgk8wUEg5A8bKsEQ.png', NULL, 4, 'Pembaca Awal', '2026-02-22 00:32:32', '2026-02-22 00:33:00'),
(17, 'B2', 'reading_levels/icons/4pSo6ZgcZ6e3vmmQJuw6j3Cx4wXbK0R0UVrdv1x8.png', NULL, 3, 'Pembaca Awal', '2026-02-22 00:32:54', '2026-02-22 01:49:36'),
(18, 'B1', 'reading_levels/icons/y8qJcReZrjGwuUZMZPt9yDD8Nr8TCWUoH3Y84btV.png', NULL, 2, 'Pembaca Awal', '2026-02-22 00:33:26', '2026-02-22 01:49:28'),
(19, 'A', 'reading_levels/icons/coMtlo15BllKRLWK0If8i36SOBWHKHs0w6SsaBFw.png', NULL, 1, 'Pembaca Dini', '2026-02-22 00:33:47', '2026-02-22 01:49:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`),
  ADD UNIQUE KEY `admin_username_unique` (`username`);

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_slug_unique` (`slug`),
  ADD KEY `books_reading_level_id_foreign` (`reading_level_id`),
  ADD KEY `books_daerah_id_foreign` (`daerah_id`);

--
-- Indeks untuk tabel `book_book_type`
--
ALTER TABLE `book_book_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_book_type_book_id_foreign` (`book_id`),
  ADD KEY `book_book_type_book_type_id_foreign` (`book_type_id`);

--
-- Indeks untuk tabel `book_categories`
--
ALTER TABLE `book_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_categories_book_id_foreign` (`book_id`),
  ADD KEY `book_categories_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `book_stats`
--
ALTER TABLE `book_stats`
  ADD PRIMARY KEY (`book_id`);

--
-- Indeks untuk tabel `book_types`
--
ALTER TABLE `book_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_types_slug_unique` (`slug`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `daerah`
--
ALTER TABLE `daerah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `daerah_name_unique` (`name`),
  ADD UNIQUE KEY `daerah_slug_unique` (`slug`);

--
-- Indeks untuk tabel `library_tables`
--
ALTER TABLE `library_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reading_levels`
--
ALTER TABLE `reading_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `book_book_type`
--
ALTER TABLE `book_book_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `book_categories`
--
ALTER TABLE `book_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `book_types`
--
ALTER TABLE `book_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `daerah`
--
ALTER TABLE `daerah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `library_tables`
--
ALTER TABLE `library_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `reading_levels`
--
ALTER TABLE `reading_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_daerah_id_foreign` FOREIGN KEY (`daerah_id`) REFERENCES `daerah` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `books_reading_level_id_foreign` FOREIGN KEY (`reading_level_id`) REFERENCES `reading_levels` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `book_book_type`
--
ALTER TABLE `book_book_type`
  ADD CONSTRAINT `book_book_type_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_book_type_book_type_id_foreign` FOREIGN KEY (`book_type_id`) REFERENCES `book_types` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `book_categories`
--
ALTER TABLE `book_categories`
  ADD CONSTRAINT `book_categories_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `book_stats`
--
ALTER TABLE `book_stats`
  ADD CONSTRAINT `book_stats_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
