-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 May 2022, 22:14:15
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `projectdb`
--
CREATE DATABASE IF NOT EXISTS `projectdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projectdb`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `user_id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `admins`
--

INSERT INTO `admins` (`user_id`, `name`, `lastname`, `email`, `password`) VALUES
(1, 'irem', 'uslu', 'iremuslu12@gmail.com', '$2y$10$44YZHkx20IoVY0wTozGUEOxl51mZNGZ9stmWR332vlEf1wp9Xtf3u'),
(2, 'oguzhan', 'uslu', 'oguzhanuslu@hotmail.com', '$2y$10$3yE1gQb9TmZzrGpaDizMZepPp/WtMhAKlogoVfv63ueI64/z4njFK'),
(8, 'deneme', 'deneme', 'deneme@gmail.com', '$2y$10$ZRAmck0bMHoqcRIig04sxu.K29oek06/92lpNoGJq.pvc4wme4t3W'),
(9, 'türkan', 'uslu', 'turkanu@gmail.com', '$2y$10$ZuncO0Ae5sDXKbV564u.aOqaT.EGy3cgCYFKzRDmNiDWuIoy1RrYi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'woman'),
(2, 'men'),
(3, 'room'),
(4, 'cologne');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `customers`
--

CREATE TABLE `customers` (
  `user_id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `customers`
--

INSERT INTO `customers` (`user_id`, `name`, `lastname`, `email`, `password`) VALUES
(2, 'a', 'b', 'ab@gmail.com', '$2y$10$44YZHkx20IoVY0wTozGUEOxl51mZNGZ9stmWR332vlEf1wp9Xtf3u');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `cat_id` tinyint(4) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `price`) VALUES
(1, 1, 'Emporio Armani She', 'A modern fragrance of bergamot, grass, angelica, sandalwood, crop, musk, oriental spices.', 'armani.jpg', 950),
(2, 1, 'Chanel Coco Mademoiselle', 'Composed of bergamot extracts, the scent blends with vanilla and white musk as it settles on the body, and turns into a sweet, sugary, caramel-like scent.', 'chanel.jpg', 2500),
(3, 1, 'Calvin Klein Euphoria', 'Top notes are khaki and dates. Middle notes are amber, violet, lotus flower and black orchid. Base notes are musk and amber.', 'ck.jpg', 374.8),
(4, 1, 'Lancome La Vie Est Belle', 'A light yet striking, comfortable and powerful perfume. A selection of 4 roses is enriched with a light jasmine touch, radiating a floral light around it.', 'lancome.jpg', 1439.41),
(5, 1, 'Yves Saint Laurent', 'The first flower is lavender. A feminine fragrance born from the combination of the burning sensation of orange blossom from Morocco and French lavender.', 'yves.jpg', 2000),
(6, 2, 'Burberry Classic EDT', 'It is a perfume that can be chosen by those who prefer to stand out with its masculine, sophisticated, elegant and stylish scent.', 'burbery.jpg', 119.99),
(7, 2, 'Paco Rabanne Invictus Legend', 'Representing a sporty and refreshed aroma, this fragrance evokes power and dynamism. ', 'invictus.jpg', 1095),
(8, 2, 'Avon Perceive', 'Thoughtful woody scents A blend of orange and grapefruit scents with sandalwood and patchouli.The name of the perfume obtained from the mixture of tangerine.', 'perceive.jpg', 174),
(9, 2, 'Versace Eros', 'In the opening, Peppermint oil (like menthol peppermint), synthetic lemon and synthetic green apple behind. 5-10 min. then the sweet scent of Tonka Bean, Vanilla and Ambroxan begins to emerge.', 'versace.jpg', 260),
(10, 3, 'Febreze Hava Ferahlatıcı Sprey', 'Febreze Air Freshener with Deodorization technology removes stubborn odors and leaves a light.', 'hava.jpg', 34.9),
(11, 3, 'Ritm Kış Mumu Oda Spreyi', 'It refreshes the whole room with its light, fresh and floral scent.It traps the cigarette smell in the house.Your home always smells clean and good.\r\n', 'ritm.jpg', 17),
(12, 4, 'Dalin Sprey Kolonya Daisy', 'Dalin Colognes give the skin a feeling of freshness, freshness and cleanliness with its lasting effect throughout the day.', 'dalin.jpg', 29.9),
(13, 4, 'Rebul Limited Edition Bouquet Kolonya', 'It is a light, fresh, floral fragrance that can even be used as a perfume.\r\n', 'çiçek.jpg', 52);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
