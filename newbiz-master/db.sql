-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table veriler.anasayfa
CREATE TABLE IF NOT EXISTS `anasayfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `ustBaslik` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `ustIcerik` varchar(6000) COLLATE utf8_turkish_ci NOT NULL,
  `link` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `altBaslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `altIcerik` varchar(6000) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- Dumping data for table veriler.anasayfa: 1 rows
/*!40000 ALTER TABLE `anasayfa` DISABLE KEYS */;
INSERT INTO `anasayfa` (`id`, `foto`, `ustBaslik`, `ustIcerik`, `link`, `altBaslik`, `altIcerik`) VALUES
	(1, 'intro.jpg', '.', '<p>.</p>', '.', '.', '<p>.</p>');
/*!40000 ALTER TABLE `anasayfa` ENABLE KEYS */;

-- Dumping structure for table veriler.hakkimizda
CREATE TABLE IF NOT EXISTS `hakkimizda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `ustBaslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- Dumping data for table veriler.hakkimizda: 3 rows
/*!40000 ALTER TABLE `hakkimizda` DISABLE KEYS */;
INSERT INTO `hakkimizda` (`id`, `foto`, `ustBaslik`, `baslik`, `icerik`) VALUES
	(1, 'img2.jpg', 'Hakk??m??zda', '??an Grup', '<p>Ticari faaliyetlerine 1978 y??l??nda 20 metrekare alanda&nbsp; perakende elektrik malzemeleri sat???? ve servis olarak Mustafa ??ANLI taraf??ndan kurulan firmam??z ikinci nesil&nbsp; olan Ayhan ??ANLI taraf??ndan 2010 y??l??ndan itibaren faaliyet alan?? geni??letilmeye ba??lanm???? ve&nbsp; &nbsp;??an Grup San. Tic. Ltd. ??ti unvan?? alt??nda b??y??yerek devam etmektedir.;&nbsp; Firmam??z??n b??nyesinde 40 ?? a??k??n ??al????an??, 4.000 metrekare kapal?? depo alan?? , ayd??nlatma ve perakende ??ubesi elektrik taahh??t birimi ve&nbsp; zengin ??r??n yelpazesi, g????l?? ve h??zl??&nbsp; servisi ve sat???? sonras?? hizmet anlay??????yla, Sivas ??n ve b??lgenin g????l?? markalar??ndan biri olmu??tur.</p>'),
	(2, 'img1.jpg', 'bo??', '??zcan Ayd??nlatma', '<p>1987 y??l??nda kurulan ??zcan Ayd??nlatma San. Tic. Ltd. ??ti; i?? mekan ayd??nlatmas?? sekt??r??nde hizmet vermektedir. 100\'?? a??k??n ??al????an??, 8.000 metrekare ??retim tesisi, zengin ??r??n yelpazesi, g????l?? ve h??zl?? teknik servisi ve sat???? sonras?? hizmet anlay??????yla, yurt i??i ve yurt d?????? sat???? noktalar?? ile ??lkemizin ??nde gelen markalar??ndan biri olmu??tur.</p><p>??zcan Ayd??nlatma, t??keticilere en iyi hizmeti vermek ve ??evre dostu ??r??nler ??retmek i??in, teknolojinin t??m imkanlar??ndan yararlanmaktad??r.<br>Merkezi ??stanbul\'da bulunan ??irketimiz, T??rkiye\'nin d??rt bir yan??ndaki yetkili sat???? temsilcileri ve bayi a????yla, i?? mekan ayd??nlatmas?? alan??nda ??lkemize hem ulusal hem de uluslararas?? d??zlemde art?? de??er kazand??rmaktad??r.<br><br>"Ayd??nlatmada ????kl??k" slogan??yla yola ????kan ??zcan Ayd??nlatma, s??z??n g??c??n?? de arkas??na alarak emin ad??mlarla ilerlerken, kalitesi ve estetik ??r??n portf??y?? sayesinde kazand?????? sayg??n ve ??zg??n ??izgisini her ge??en g??n daha da sa??lamla??t??rmaktad??r.<br>&nbsp;</p>'),
	(3, 'img3.jpg', 'bo??', 'Ges seyfebeli', 'Seyfebelindeki ges santrali');
/*!40000 ALTER TABLE `hakkimizda` ENABLE KEYS */;

-- Dumping structure for table veriler.iletisim
CREATE TABLE IF NOT EXISTS `iletisim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- Dumping data for table veriler.iletisim: 2 rows
/*!40000 ALTER TABLE `iletisim` DISABLE KEYS */;
INSERT INTO `iletisim` (`id`, `ad`, `email`, `mesaj`, `tarih`) VALUES
	(32, '', '', '', '2022-06-28 10:28:38'),
	(24, 'aaa', 'aaa', 'aaa', '2019-03-18 08:45:53');
/*!40000 ALTER TABLE `iletisim` ENABLE KEYS */;

-- Dumping structure for table veriler.katalog
CREATE TABLE IF NOT EXISTS `katalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `ustBaslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `sira` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- Dumping data for table veriler.katalog: 1 rows
/*!40000 ALTER TABLE `katalog` DISABLE KEYS */;
INSERT INTO `katalog` (`id`, `foto`, `baslik`, `ustBaslik`, `icerik`, `aktif`, `sira`) VALUES
	(8, 'unnamed.png', 'CATA', 'www.cata.com', '<p>Katalog Fiyatlar?? A??a????daki Gibidir</p>', 1, 1);
/*!40000 ALTER TABLE `katalog` ENABLE KEYS */;

-- Dumping structure for table veriler.kullanicilar
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` char(50) NOT NULL,
  `parola` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table veriler.kullanicilar: 2 rows
/*!40000 ALTER TABLE `kullanicilar` DISABLE KEYS */;
INSERT INTO `kullanicilar` (`id`, `kadi`, `parola`) VALUES
	(1, 'admin', '105a9a2d46f64e147097c986076d2164'),
	(11, 'ali', '105a9a2d46f64e147097c986076d2164');
/*!40000 ALTER TABLE `kullanicilar` ENABLE KEYS */;

-- Dumping structure for table veriler.magaza
CREATE TABLE IF NOT EXISTS `magaza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ustBaslik` char(50) NOT NULL DEFAULT '0',
  `anaBaslik` varchar(500) NOT NULL DEFAULT '0',
  `adres` char(250) NOT NULL DEFAULT '0',
  `telefon` char(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table veriler.magaza: 1 rows
/*!40000 ALTER TABLE `magaza` DISABLE KEYS */;
INSERT INTO `magaza` (`id`, `ustBaslik`, `anaBaslik`, `adres`, `telefon`) VALUES
	(1, 'info@sangrup.com', '??al????ma Saatleri', 'Mehmet Akif Ersoy, 49-13. Sk. No:31, 58060 Sivas Merkez/Sivas', '05012580158');
/*!40000 ALTER TABLE `magaza` ENABLE KEYS */;

-- Dumping structure for table veriler.magazasaat
CREATE TABLE IF NOT EXISTS `magazasaat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gun` char(50) NOT NULL,
  `saat` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table veriler.magazasaat: 7 rows
/*!40000 ALTER TABLE `magazasaat` DISABLE KEYS */;
INSERT INTO `magazasaat` (`id`, `gun`, `saat`) VALUES
	(1, 'Pazartesi', '08:00 - 20:00'),
	(2, 'Sal??', '08:00 - 20:00'),
	(3, '??ar??amba', '08:00 - 20:00'),
	(4, 'Per??embe', '08:00 - 20:00'),
	(5, 'Cuma', '08:00 - 20:00'),
	(6, 'Cumartesi', 'Kapal??'),
	(7, 'Pazar', 'Kapal??');
/*!40000 ALTER TABLE `magazasaat` ENABLE KEYS */;

-- Dumping structure for table veriler.ortaklar
CREATE TABLE IF NOT EXISTS `ortaklar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `sira` int(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table veriler.ortaklar: 24 rows
/*!40000 ALTER TABLE `ortaklar` DISABLE KEYS */;
INSERT INTO `ortaklar` (`id`, `foto`, `baslik`, `icerik`, `aktif`, `sira`) VALUES
	(24, '15.png', 'http://simge-ess.com.tr/', '<p>S??MGE</p>', 1, 15),
	(25, '16.png', 'https://www.recber.com.tr/', '<p>RECBER</p>', 1, 16),
	(26, '17.png', 'https://mekaskablo.com/', '<p>MEKAS KABLO</p>', 1, 17),
	(27, '18.png', 'https://www.bemis.com.tr/', '<p>BEM??S</p>', 1, 18),
	(28, '19.png', 'https://www.universal.com.tr/', '<p>UNIVERSAL</p>', 1, 19),
	(19, '11.png', 'http://www.isildar.eu/', '<p>I??ILDAR</p>', 1, 11),
	(21, '12.png', 'https://www.gunsanelectric.com/', '<p>G??NSAN</p>', 1, 12),
	(22, '13.png', 'https://www.mutlusan.com.tr/', '<p>MUTLUSAN</p>', 1, 13),
	(23, '14.png', 'https://www.audio.com.tr/', '<p>AUDIO</p>', 1, 14),
	(14, '4.jpg', 'https://www.oznurkablo.com.tr/', '<p>??ZNUR KABLO</p>', 1, 6),
	(15, '6.png', 'https://www.acklighting.com/', '<p>ACK</p>', 1, 7),
	(16, '8.png', 'https://www.horozelektrik.com/#/', '<p>HOROZ ELEKTR??K</p>', 1, 8),
	(17, '9.png', 'https://www.ledmar.com/', '<p>LEDMAR</p>', 1, 9),
	(18, '10.png', 'https://kendalelektrik.com.tr/', '<p>KENDAL</p>', 1, 10),
	(10, '5.png', 'https://www.borsan.com.tr/', '<p>BORSAN</p>', 1, 2),
	(11, '1.png', 'https://new.abb.com/tr', '<p>ABB</p>', 1, 3),
	(12, '2.jpg', 'https://www.pelsan.com.tr/', '<p>PELSAN</p>', 1, 4),
	(13, '3.png', 'https://www.unalkablo.com/', '<p>??NAL KABLO</p>', 1, 5),
	(8, '7.png', 'https://cata.com.tr/', '<p>CATA</p>', 1, 1),
	(29, '20.png', 'https://www.cet-san.com.tr/', '<p>??ET-SAN</p>', 1, 20),
	(30, '21.png', 'https://www.ozcanaydinlatma.com.tr/', '<p>??ZCAN AYDINLATMA</p>', 1, 21),
	(31, '22.png', 'https://www.avonni.com/', '<p>AVONN??</p>', 1, 22),
	(32, '23.png', 'https://yilpapano.com/', '<p>YILPANO</p>', 1, 23),
	(33, '24.png', 'https://www.apexelektrik.com/', '<p>APEX ELEKTR??K</p>', 1, 24);
/*!40000 ALTER TABLE `ortaklar` ENABLE KEYS */;

-- Dumping structure for table veriler.portfolyo
CREATE TABLE IF NOT EXISTS `portfolyo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `ustBaslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `sira` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table veriler.portfolyo: 3 rows
/*!40000 ALTER TABLE `portfolyo` DISABLE KEYS */;
INSERT INTO `portfolyo` (`id`, `foto`, `baslik`, `ustBaslik`, `icerik`, `aktif`, `sira`) VALUES
	(8, '1.jpg', 'Avize', 'www.google.com', '<p>Avizelerimiz Gelmi??tir</p>', 1, 3),
	(9, '2.jpg', 'Priz', 'www.sangrup.com', '<p>Priz ??e??itlerimiz Gelmi??tir</p>', 1, 2),
	(10, '3.jpg', 'Kablo', 'www.sangrup.com', '<p>Kablo ??e??itlerimiz Gelmi??tir</p>', 1, 1);
/*!40000 ALTER TABLE `portfolyo` ENABLE KEYS */;

-- Dumping structure for table veriler.takim
CREATE TABLE IF NOT EXISTS `takim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` char(250) COLLATE utf8_turkish_ci NOT NULL,
  `facebook` char(150) COLLATE utf8_turkish_ci NOT NULL,
  `instagram` char(150) COLLATE utf8_turkish_ci NOT NULL,
  `linkedin` char(150) COLLATE utf8_turkish_ci NOT NULL,
  `google` char(150) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `sira` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table veriler.takim: 2 rows
/*!40000 ALTER TABLE `takim` DISABLE KEYS */;
INSERT INTO `takim` (`id`, `foto`, `baslik`, `facebook`, `instagram`, `linkedin`, `google`, `icerik`, `aktif`, `sira`) VALUES
	(9, 'team-4.jpg', 'Kad??n', '#', '#', '#', '#', '<p>ltknmhl</p>', 1, 1),
	(10, 'testimonial-1.jpg', 'Erkek', '#', '#', '#', '#', '<p>Tak??mdaki Erkek</p>', 1, 2);
/*!40000 ALTER TABLE `takim` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
