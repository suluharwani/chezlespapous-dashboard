-- --------------------------------------------------------
-- Host:                         153.92.15.63
-- Server version:               10.11.10-MariaDB-log - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for u375117440_cdkp
CREATE DATABASE IF NOT EXISTS `u375117440_cdkp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `u375117440_cdkp`;

-- Dumping structure for table u375117440_cdkp.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.admins: ~1 rows (approximately)
INSERT INTO `admins` (`id`, `username`, `email`, `password`, `full_name`, `profile_picture`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@rajaampat.com', '$2y$10$trTY62ombEs6UdPaHW3g/unHaIuEFd7nmLAOGlbJwlhE0B65mlrPS', 'Administrator', NULL, 1, NULL, '2025-06-30 04:25:37', '2025-06-30 04:25:37');

-- Dumping structure for table u375117440_cdkp.destinations
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `category` enum('diving','beach','island','viewpoint','cultural') NOT NULL,
  `price_range` decimal(10,2) DEFAULT NULL,
  `best_season` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.destinations: ~5 rows (approximately)
INSERT INTO `destinations` (`id`, `name`, `description`, `location`, `category`, `price_range`, `best_season`, `image_url`, `created_at`) VALUES
	(1, 'Wayag Island', 'Pulau dengan pemandangan karst yang menakjubkan dan spot foto ikonis Raja Ampat.', 'Pulau Wayag', 'viewpoint', 1000000.00, 'Oktober-April', 'wayag.jpeg', '2025-06-14 15:30:03'),
	(2, 'Pasir Timbul', 'Pantai pasir putih mungil yang muncul saat air laut surut.', 'Kepulauan Gam', 'beach', 50000.00, 'April-November', 'pasir-timbul.jpg', '2025-06-14 15:30:03'),
	(3, 'Manta Sandy', 'Spot snorkeling terkenal untuk melihat pari manta.', 'Pulau Arborek', 'diving', 750000.00, 'Desember-Maret', 'manta-sandy.jpg', '2025-06-14 15:30:03'),
	(4, 'Pianemo', 'Spot view point terkenal dengan pemandangan gugusan pulau karst.', 'Pulau Pianemo', 'viewpoint', 500000.00, 'September-Mei', 'pianemo.jpg', '2025-06-14 15:30:03'),
	(5, 'Village of Arborek', 'Desa tradisional dengan budaya lokal dan kerajinan tangan.', 'Pulau Arborek', 'cultural', 0.00, 'Sepanjang tahun', 'arborek-village.jpg', '2025-06-14 15:30:03');

-- Dumping structure for table u375117440_cdkp.dive_spots
CREATE TABLE IF NOT EXISTS `dive_spots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `depth_range` varchar(50) NOT NULL,
  `current_level` enum('low','medium','high') NOT NULL,
  `marine_life` text NOT NULL,
  `best_time` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.dive_spots: ~3 rows (approximately)
INSERT INTO `dive_spots` (`id`, `name`, `description`, `location`, `depth_range`, `current_level`, `marine_life`, `best_time`, `image_url`, `created_at`) VALUES
	(1, 'Cape Kri', 'Spot menyelam dengan keragaman ikan tertinggi di dunia.', 'Pulau Kri', '5-40 meter', 'medium', 'Hiu, Napoleon wrasse, Giant trevally, Barracuda', 'Oktober-April', 'cape-kri.jpg', '2025-06-14 15:30:03'),
	(2, 'Blue Magic', 'Spot drift dive dengan arus kuat dan banyak manta ray.', 'Pulau Mioskon', '10-30 meter', 'high', 'Manta ray, Eagle ray, Sharks, Tuna', 'Desember-Maret', 'blue-magic.jpg', '2025-06-14 15:30:03'),
	(3, 'The Passage', 'Drift dive unik melalui kanal sempit antara dua pulau.', 'Pulau Waigeo', '5-20 meter', 'medium', 'Seahorses, Pygmy seahorses, Mandarin fish', 'September-Mei', 'the-passage.jpg', '2025-06-14 15:30:03');

-- Dumping structure for table u375117440_cdkp.galleries
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `category` enum('nature','diving','culture','resort') NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.galleries: ~8 rows (approximately)
INSERT INTO `galleries` (`id`, `title`, `description`, `image_url`, `category`, `location`, `is_featured`, `display_order`, `created_at`) VALUES
	(1, 'Pulau Wayag', 'Pemandangan ikonis gugusan pulau karst', 'gallery/wayag.jpeg', 'nature', 'Pulau Wayag', 1, 0, '2025-06-14 16:29:12'),
	(2, 'Snorkeling dengan Manta', 'Pengalaman bertemu pari manta di Manta Sandy', 'gallery/manta-sandy.jpg', 'diving', 'Pulau Arborek', 1, 0, '2025-06-14 16:29:12'),
	(3, 'Desa Arborek', 'Budaya lokal masyarakat Raja Ampat', 'gallery/arborek-village.jpg', 'culture', 'Pulau Arborek', 1, 0, '2025-06-14 16:29:12'),
	(4, 'Resort Papua Paradise', 'Bungalow eksklusif di atas air', 'gallery/honeymoon.jpg', 'resort', 'Pulau Birie', 0, 0, '2025-06-14 16:29:12'),
	(5, 'Cape Kri Diving', 'Spot menyelam dengan keragaman ikan tertinggi', 'gallery/cape-kri.jpeg', 'diving', 'Pulau Kri', 0, 0, '2025-06-14 16:29:12'),
	(6, 'Pasir Timbul', 'Pasir putih muncul saat air laut surut', 'gallery/pasir-timbul.jpg', 'nature', 'Kepulauan Gam', 0, 0, '2025-06-14 16:29:12'),
	(7, 'Sunset Pianemo', 'Matahari terbenam di titik view Pianemo', 'gallery/pianemo.jpg', 'nature', 'Pulau Pianemo', 0, 0, '2025-06-14 16:29:12'),
	(8, 'Rumah Tradisional', 'Arsitektur khas masyarakat setempat', 'gallery/traditional-house.webp', 'culture', 'Pulau Waigeo', 0, 0, '2025-06-14 16:29:12');

-- Dumping structure for table u375117440_cdkp.local_guides
CREATE TABLE IF NOT EXISTS `local_guides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `languages` varchar(255) NOT NULL,
  `specialization` enum('diving','snorkeling','photography','cultural','adventure') NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `rating` decimal(3,1) DEFAULT 5.0,
  `is_verified` tinyint(1) DEFAULT 0,
  `years_experience` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.local_guides: ~5 rows (approximately)
INSERT INTO `local_guides` (`id`, `full_name`, `email`, `phone`, `address`, `experience`, `languages`, `specialization`, `price_per_day`, `photo_url`, `rating`, `is_verified`, `years_experience`, `created_at`, `updated_at`) VALUES
	(1, 'Yohanis Deda', 'yohanis@rajaampatguide.com', '+6282244556677', 'Kampung Saonek, Raja Ampat', 'Pemandu profesional dengan sertifikasi PADI Divemaster. Spesialis spot menyelam di Cape Kri dan Blue Magic.', 'Indonesia, Inggris', 'diving', 850000.00, 'guides/yohanis.webp', 4.9, 1, 8, '2025-06-14 16:41:16', '2025-06-14 16:41:16'),
	(2, 'Martha Fonataba', 'martha@rajaampatguide.com', '+6283344557788', 'Pulau Arborek, Raja Ampat', 'Ahli budaya lokal dan sejarah Raja Ampat. Memandu tur ke desa tradisional dan spot foto terbaik.', 'Indonesia, Inggris dasar', 'cultural', 650000.00, 'guides/martha.jpeg', 4.7, 1, 5, '2025-06-14 16:41:16', '2025-06-14 16:49:04'),
	(3, 'Samuel Kareth', 'samuel@rajaampatguide.com', '+6285566778899', 'Waisai, Raja Ampat', 'Fotografer underwater profesional dengan 10 tahun pengalaman. Bisa memandu ke spot foto bawah air terbaik.', 'Indonesia, Inggris, Jepang', 'photography', 1200000.00, 'guides/samuel.webp', 5.0, 1, 10, '2025-06-14 16:41:16', '2025-06-14 16:41:16'),
	(4, 'Budi Santoso', 'budi@rajaampatguide.com', '+6281234567890', 'Pulau Kri, Raja Ampat', 'Pemandu snorkeling berpengalaman. Menguasai semua spot terbaik untuk melihat manta dan kehidupan laut.', 'Indonesia, Inggris, Mandarin', 'snorkeling', 750000.00, 'guides/budi.webp', 4.8, 1, 6, '2025-06-14 16:41:16', '2025-06-14 16:41:16'),
	(5, 'Maria Waisimon', 'maria@rajaampatguide.com', '+6289876543210', 'Pulau Gam, Raja Ampat', 'Pemandu petualangan spesialis trekking dan eksplorasi pulau-pulau terpencil.', 'Indonesia, Inggris, Spanyol', 'adventure', 900000.00, 'guides/maria.jpg', 4.9, 1, 7, '2025-06-14 16:41:16', '2025-06-14 16:51:18');

-- Dumping structure for table u375117440_cdkp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.migrations: ~2 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2025-06-16-032342', 'App\\Database\\Migrations\\CreateAdminTable', 'default', 'App', 1751255186, 1),
	(2, '2025-06-30-040642', 'App\\Database\\Migrations\\CreateAdminTable', 'default', 'App', 1751257461, 2);

-- Dumping structure for table u375117440_cdkp.resorts
CREATE TABLE IF NOT EXISTS `resorts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `price_range` varchar(50) NOT NULL,
  `facilities` text NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.resorts: ~3 rows (approximately)
INSERT INTO `resorts` (`id`, `name`, `description`, `location`, `price_range`, `facilities`, `contact_phone`, `contact_email`, `website`, `image_url`, `created_at`) VALUES
	(1, 'Raja Ampat Dive Lodge', 'Resort nyaman dengan akses langsung ke spot menyelam terbaik.', 'Pulau Kri', 'Rp2.500.000 - Rp5.000.000/malam', 'Restoran, Dive Center, AC, WiFi area umum', '+628124567890', 'info@dive-lodge.com', 'www.dive-lodge.com', 'dive-lodge.jpg', '2025-06-14 15:30:03'),
	(2, 'Meridian Adventure Marina', 'Resort mewah dengan marina pribadi dan fasilitas lengkap.', 'Pulau Waigeo', 'Rp5.000.000 - Rp10.000.000/malam', 'Kolam renang, Spa, Restoran, Marina, WiFi', '+628523456789', 'reservation@meridianmarina.com', 'www.meridianmarina.com', 'meridian-marina.jpg', '2025-06-14 15:30:03'),
	(3, 'Papua Paradise Eco Resort', 'Resort ramah lingkungan dengan bungalow di atas air.', 'Pulau Birie', 'Rp3.000.000 - Rp6.000.000/malam', 'Restoran, Dive Center, Snorkeling gear, WiFi terbatas', '+628127654321', 'book@papua-paradise.com', 'www.papua-paradise.com', 'papua-paradise.jpg', '2025-06-14 15:30:03');

-- Dumping structure for table u375117440_cdkp.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `button_text` varchar(50) DEFAULT 'Explore Now',
  `button_link` varchar(255) DEFAULT '#',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.sliders: ~4 rows (approximately)
INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image_url`, `button_text`, `button_link`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
	(1, 'Discover Raja Ampat', 'The Last Paradise on Earth', 'sliders/raja-ampat-hero-1.jpeg', 'Explore Now', '#destinations', 1, 1, '2025-06-14 15:58:16', '2025-06-14 16:11:27'),
	(2, 'Diving Adventure', 'Explore the Underwater Wonders', 'sliders/raja-ampat-diving.webp', 'Dive Spots', '#dive-spots', 1, 2, '2025-06-14 15:58:16', '2025-06-14 16:07:27'),
	(3, 'Luxury Resorts', 'Stay in Overwater Bungalows', 'sliders/raja-ampat-resort.webp', 'View Resorts', '#resorts', 1, 3, '2025-06-14 15:58:16', '2025-06-14 16:09:06'),
	(4, 'Cultural Experience', 'Meet the Local Tribes', 'sliders/raja-ampat-culture.avif', 'Learn More', '#culture', 1, 4, '2025-06-14 15:58:16', '2025-06-14 16:09:54');

-- Dumping structure for table u375117440_cdkp.testimonials
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(100) NOT NULL,
  `origin_country` varchar(100) NOT NULL,
  `testimonial` text NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `visit_date` date NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.testimonials: ~3 rows (approximately)
INSERT INTO `testimonials` (`id`, `visitor_name`, `origin_country`, `testimonial`, `rating`, `visit_date`, `photo_url`, `is_featured`, `created_at`) VALUES
	(1, 'Sophie Martin', 'France', 'Raja Ampat adalah surga di bumi! Snorkeling di Manta Sandy adalah pengalaman tak terlupakan.', 5, '2023-03-15', 'sophie.jpg', 1, '2025-06-14 15:30:03'),
	(2, 'David Tanaka', 'Japan', 'Pemandangan dari Pianemo sangat menakjubkan. Tour guide kami sangat berpengetahuan.', 5, '2023-02-20', 'david.jpg', 1, '2025-06-14 15:30:03'),
	(3, 'Emma Johnson', 'USA', 'Resortnya nyaman dan makanan enak. Spot diving terbaik yang pernah saya kunjungi!', 4, '2023-04-10', 'emma.jpg', 1, '2025-06-14 15:30:03');

-- Dumping structure for table u375117440_cdkp.tour_guides
CREATE TABLE IF NOT EXISTS `tour_guides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `experience` text NOT NULL,
  `languages` varchar(255) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.tour_guides: ~0 rows (approximately)

-- Dumping structure for table u375117440_cdkp.tour_packages
CREATE TABLE IF NOT EXISTS `tour_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `includes` text NOT NULL,
  `itinerary` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table u375117440_cdkp.tour_packages: ~3 rows (approximately)
INSERT INTO `tour_packages` (`id`, `name`, `description`, `duration`, `price`, `includes`, `itinerary`, `image_url`, `created_at`) VALUES
	(1, 'Paket Raja Ampat 4D3N', 'Paket lengkap eksplorasi Raja Ampat dengan snorkeling dan kunjungan ke spot ikonis.', '4 Hari 3 Malam', 7500000.00, 'Penginapan, Makan, Transportasi laut, Guide, Alat snorkeling', 'Hari 1: Pianemo - Hari 2: Wayag - Hari 3: Manta Sandy - Hari 4: Desa Arborek', 'Raja-Ampat-4-Hari-3-Malam.jpg', '2025-06-14 15:30:03'),
	(2, 'Liveaboard Diving 7D6N', 'Pengalaman menyelam di spot-spot terbaik Raja Ampat dengan liveaboard.', '7 Hari 6 Malam', 25000000.00, 'Liveaboard, 3x makan sehari, Dive guide, 15x penyelaman, Tank & weights', 'Penyelaman di Cape Kri, Blue Magic, The Passage, Manta Sandy, dll', 'liveaboard.jpg', '2025-06-14 15:30:03'),
	(3, 'Honeymoon Package 5D4N', 'Paket romantis untuk pasangan dengan penginapan eksklusif dan aktivitas privat.', '5 Hari 4 Malam', 15000000.00, 'Bungalow private, Makanan premium, Aktivitas privat, Transportasi', 'Private island hopping, Sunset dinner, Spa treatment', 'honeymoon.jpg', '2025-06-14 15:30:03');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
