-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 31, 2018 lúc 06:40 PM
-- Phiên bản máy phục vụ: 10.1.30-MariaDB
-- Phiên bản PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phimphp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `user_id` int(11) NOT NULL,
  `phim_id` int(11) NOT NULL,
  `danhgia_star` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phim`
--

CREATE TABLE `phim` (
  `phim_id` int(11) NOT NULL,
  `theloai_id` text COLLATE utf8_unicode_ci,
  `phim_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phim_tenkhac` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phim_gioithieu` text COLLATE utf8_unicode_ci,
  `phim_sotap` int(4) NOT NULL,
  `phim_nam` int(4) NOT NULL,
  `phim_tag` text COLLATE utf8_unicode_ci,
  `phim_hinhanh` text COLLATE utf8_unicode_ci NOT NULL,
  `phim_hinhnen` text COLLATE utf8_unicode_ci NOT NULL,
  `phim_luotxem` int(11) NOT NULL DEFAULT '0',
  `phim_ngaycapnhat` date NOT NULL,
  `phim_hoanthanh` tinyint(1) NOT NULL DEFAULT '0',
  `phim_nguon` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'Đang cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phim`
--

INSERT INTO `phim` (`phim_id`, `theloai_id`, `phim_ten`, `phim_tenkhac`, `phim_gioithieu`, `phim_sotap`, `phim_nam`, `phim_tag`, `phim_hinhanh`, `phim_hinhnen`, `phim_luotxem`, `phim_ngaycapnhat`, `phim_hoanthanh`, `phim_nguon`) VALUES
(8, '[\"11\",\"16\",\"17\"]', 'Claymore', 'Phù Thủy Mắt Bạc', 'Yoma! Quái vật ăn phủ tạng con người. Chúng sống dưới lốt nạn nhân trà trộn vào thế giới loài người. Không ai hay cũng ko ai biết duy chỉ có Claymore - Những thiếu nữ mang trong mình máu thịt của loài quái vật sở hữu đôi mắt làm thành danh tiếng của họ. Phù Thủy Mắt Bạc! Những thiếu nữ mất đi hạnh phúc, mất đi tương lai và liệu Clare - Teresa có bảo vệ họ trước loài Awakened Beings hay với cái tên là loài Thức Tỉnh ...', 26, 2007, 'claymore', 'https://orig00.deviantart.net/9029/f/2015/134/a/2/icon_folder___claymore_by_alex_064-d8td4eq.png', 'http://wallpaperstop.net/wp-content/uploads/2018/04/Claymore%20Anime%20Computer%20Wallpaper.jpg', 0, '2018-07-29', 0, 'youtube,BTT,Noahs Fansub'),
(9, '[\"11\"]', 'Tokyo Ghoul Phần 1', 'Ngạ quỷ Phần 1', NULL, 12, 2014, 'tokyo ghoul, ngạ quỷ', 'https://orig00.deviantart.net/5618/f/2014/270/9/e/tokyo_ghoul_folder_icon_by_adrianecchi-d80qf3y.png', 'https://i.pinimg.com/originals/72/51/6a/72516a470c0cb4c2610742e181a2a074.jpg', 0, '2018-07-29', 0, 'phimmoi'),
(10, '[\"11\",\"16\"]', 'Attack on Titan Phần 1', 'Shingeki no Kyojin Phần 1', NULL, 25, 2013, 'attack on titan, titan', 'https://orig00.deviantart.net/8e7b/f/2014/266/0/1/shingeki_no_kyojin___icon_folder_by_ubagutobr-d80bkqw.png', 'https://i2.wp.com/attackongeek.com/wp-content/uploads/2017/08/attack-on-titan-ss2-wallpaper-backgrounds-hd-08.jpg', 0, '2018-07-30', 0, 'phimmoi, youtube'),
(11, '[\"11\",\"16\",\"17\"]', 'Tokyo Ghoul Phần 2', 'Ngạ Quỷ Phần 2', NULL, 12, 2015, 'tokyo ghoul, ngạ quỷ', 'https://orig00.deviantart.net/aba6/f/2015/013/2/3/tokyo_ghoul_2_by_rest_in_torment-d8dsfte.png', 'https://images5.alphacoders.com/526/thumb-1920-526889.jpg', 0, '2018-07-31', 0, 'phimmoi, khác'),
(12, '[\"11\",\"16\",\"17\"]', 'Tokyo Ghoul:Re (Phần 3)', 'Ngạ Quỷ Phần 3', NULL, 12, 2018, 'tokyo ghoul, ngạ quỷ', 'https://orig00.deviantart.net/9dc3/f/2018/119/c/a/tokyo_ghoul_re_folder_icon_by_tatas18-dca5ydn.png', 'https://images4.alphacoders.com/554/thumb-1920-554421.jpg', 0, '2018-07-31', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_code` int(3) NOT NULL,
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_code`, `role_name`) VALUES
(1, 100, 'Quản trị hệ thống'),
(2, 200, 'Quản trị tài khoản'),
(3, 300, 'Quản lý phim');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tap`
--

CREATE TABLE `tap` (
  `tap_id` int(11) NOT NULL,
  `phim_id` int(11) NOT NULL,
  `tap_ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tap_tapsohienthi` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tap_tapso` int(5) NOT NULL,
  `tap_googlelink` text COLLATE utf8_unicode_ci,
  `tap_openloadlink` text COLLATE utf8_unicode_ci,
  `tap_youtubelink` text COLLATE utf8_unicode_ci,
  `tap_localhostlink` text COLLATE utf8_unicode_ci,
  `tap_luotxem` int(11) NOT NULL,
  `tap_ngaycapnhat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tap`
--

INSERT INTO `tap` (`tap_id`, `phim_id`, `tap_ten`, `tap_tapsohienthi`, `tap_tapso`, `tap_googlelink`, `tap_openloadlink`, `tap_youtubelink`, `tap_localhostlink`, `tap_luotxem`, `tap_ngaycapnhat`) VALUES
(5, 8, '', 'Tập 1', 1, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipPKic9uPaaj114Y1LFigNm5Dtxy2uD9TxN4CIkb?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'rbHosMC8mwE', 'https://www.youtube.com/embed/XNu1jLd4JdA?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(6, 8, '', 'Tập 2', 2, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipMfQpDey1vwyA08CpvKEDoy4OsPZSjDjKxwvvy-?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', '6b2VmOFR0ho', 'https://www.youtube.com/embed/ZkTTAmkL0r0?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(7, 8, '', 'Tập 3', 3, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipMC4o2OhLVNKjJy-dLZm0b15B5c-_elIgQjwl_D?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'ohf0lXBmcgM', 'https://www.youtube.com/embed/qg8cSdp55vQ?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(8, 8, '', 'Tập 4', 4, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipPmKgct7HbLNXUGVwkNemRGlsEa73qDKlQP6WvR?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', '9ZDMc6fnt5Q', 'https://www.youtube.com/embed/xjFkfFg4u-Y?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(9, 8, '', 'Tập 5', 5, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipMrxvVdRX0JCen3poxC4QDo0Ayy3uz9xuxBeZa_?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'RB0NdBGbGJM', 'https://www.youtube.com/embed/ZlOIdJBiH7g?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(10, 9, '', 'Tập 1', 1, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipP-NusXExaefjC7OYrvRzhB0oJBD3K_s6rsHyiB?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '82Hgik78H4w', '', '', 156, '2018-07-29'),
(12, 9, '', 'Tập 2', 2, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMn_aYQsMO913S2hK702Z4tJd_hV-2k7pyucdFQ?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'upSYhDqMTpM', '', '', 0, '2018-07-30'),
(13, 9, '', 'Tập 3', 3, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipO4ATEKazVV187weT5dbL4bjmWk2aoIZGzxmR_J?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'Mg8hX_HxzA8', '', '', 0, '2018-07-30'),
(14, 9, '', 'Tập 4', 4, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOUOiZ2zSHWZjcbN2yULHKOVUk5Ux9RLeJI_Adl?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '1KhDdLreyAc', '', '', 0, '2018-07-30'),
(15, 9, '', 'Tập 5', 5, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNjxvUbAtQ4Rq9ANKrn_h9IpLuSINMXDNB8VKkM?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'z7WiWURDumw', '', '', 0, '2018-07-30'),
(16, 9, '', 'Tập 6', 6, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMUwhwvPgjdHU01dwSBeRuDjE_hVVY0wKfm6S82?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'PduJnx0dHLw', '', '', 0, '2018-07-30'),
(17, 9, '', 'Tập 7', 7, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOIPLH34i2AywyvzI7xfr5ikl8tjN0z_OBWvU0A?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'fOEfAwDaQC4', '', '', 0, '2018-07-30'),
(18, 9, '', 'Tập 8', 8, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipPG1qfIITGUui3BQbWYBnr9C0txYQayEJusOD9J?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'zxrizTI2vEY', '', '', 0, '2018-07-30'),
(19, 9, '', 'Tập 9', 9, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOB9sE1AKpI5maX-Lo2G4liOre8C9Ir6aIWj19k?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'pVA0HDt3Qtc', '', '', 0, '2018-07-30'),
(20, 9, '', 'Tập 10', 10, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipP5Vjo6I7YAuQPsnLR0ZLkZmUcGh85jHFbj6NLC?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'z95ryUc6CW8', '', '', 0, '2018-07-30'),
(21, 9, '', 'Tập 11', 11, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOPaCEXVvD17k9XUSIOJ6_S9gUH2lY0dNCOvhke?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '0WVWF7mMv6g', '', '', 0, '2018-07-30'),
(22, 9, '', 'Tập 12', 12, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOL5vl4kNF5KZ50MyMc6OCJixZ6lY7xu-zQwLsx?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'Cle00_fhZJg', '', '', 325, '2018-07-30'),
(30, 10, '', 'Tập 1', 1, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPriLHADe_EengoqJAwiAYjFX29Im2RYs7OoKzG?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'qFmeaCOxZ6M', '', '', 0, '2018-07-30'),
(31, 10, '', 'Tập 2', 2, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipN0tROVBWWpHKPSgZKplX_YqOJUHTQ8to5fcYrg?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'z0OG9J8WOq8', '', '', 0, '2018-07-30'),
(32, 10, '', 'Tập 3', 3, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipO-DzaAqYQByIMljzjWewSPNOJ3owqMX7TacfED?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'TyNXDSDZJKw', '', '', 0, '2018-07-30'),
(33, 10, '', 'Tập 4', 4, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPEd5fSW4Gr3DXY-GCZIkOjOdCjHmds1LGytbjI?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', '3MFEn0-8CjQ', '', '', 0, '2018-07-30'),
(34, 10, '', 'Tập 5', 5, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipMxQ6EaOZESNo4plJSEqouk6B0ObifY3bIdS9Y7?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'PNsiMh6cp6s', '', '', 0, '2018-07-30'),
(35, 10, '', 'Tập 6', 6, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipOsX1v2UATxGAQvhVa83PTmjcWdP5nS0Nl0FAP0?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'bWMYLDDKqCA', '', '', 0, '2018-07-30'),
(36, 10, '', 'Tập 7', 7, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipOp-pLt3GwTLtjNWploXZNlsJNZXgUrQ0q4VIuj?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'XoM4j4r99So', '', '', 0, '2018-07-30'),
(37, 10, '', 'Tập 8', 8, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipOO9oZVBzTOoWfLyJahEJ57OisdP2IDECky7b1o?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'DdGz6GCrQS8', '', '', 0, '2018-07-30'),
(38, 10, '', 'Tập 9', 9, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipNk5yFqd7joUXzXSCIleRWRR4WOR6yiN1-O7lF3?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'tYKW6YmCRgA', '', '', 0, '2018-07-30'),
(39, 10, '', 'Tập 10', 10, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipM2sdrNYawnpCZvydSpRN4BFFfGiuNWqEHHqzKm?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'zvsuioJTtg8', '', '', 0, '2018-07-30'),
(40, 10, '', 'Tập 11', 11, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPhn4BdcZnunAabwERP1JOMCPfbXqU628xP1VBw?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', '-ZP6t7YkjXk', '', '', 0, '2018-07-30'),
(41, 10, '', 'Tập 12', 12, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipMO9Rsn8lGTCNYJ1yB15KqAort6Qpt_DO5_7w2b?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'Hw8-c6Uijac', '', '', 0, '2018-07-30'),
(42, 10, '', 'Tập 13', 13, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipNvVS--E3mvK4ZBLrO76lsqBnnPk6w3_qpNkSWN?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'tKr1AJ6CMUc', '', '', 0, '2018-07-30'),
(43, 10, '', 'Tập 14', 14, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPnPBPj-y5nX2x466rbvhwAbElyl5YSfs5oiK61?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'TrRDFjd4Ut4', '', '', 0, '2018-07-30'),
(44, 10, '', 'Tập 15', 15, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipP0fhMrHRFB7Wh8ZKHlSf4eqnWwrz7XSPq0am0u?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'BVgoMI6S-xw', '', '', 0, '2018-07-30'),
(45, 10, '', 'Tập 16', 16, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipO6B_C6cLNW0EiA36jSCjI_D6IxGwLOKq3d793b?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'efjTb_Me6LU', '', '', 0, '2018-07-30'),
(46, 10, '', 'Tập 17', 17, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPd9nIaB_OiSTwSe-fux6m_xrSiMaszh3odkjdw?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'sPBHvGbRlY0', '', '', 0, '2018-07-30'),
(47, 10, '', 'Tập 18', 18, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipM9T-FZIoBOJj1nvqRHzFVYEQoJfj1P8p62taJr?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'KFw86CSUlPM', '', '', 0, '2018-07-30'),
(48, 10, '', 'Tập 19', 19, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipO8VlXm1QF00y3Xws5jQKXcIzxihCWw8UmOP08n?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'HqQUN_5duHk', '', '', 0, '2018-07-30'),
(49, 10, '', 'Tập 20', 20, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipPZozUmOlVcLRGY6w8ey58mGa4hJ3NkQcXgmg6M?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'lVbbswxyqrc', '', '', 0, '2018-07-30'),
(50, 10, '', 'Tập 21', 21, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipNlkgwDDEzkoSGv6-FPLHfAGAnKBxQfT4FeEAjg?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'ddUlu-ilCS8', '', '', 0, '2018-07-30'),
(51, 10, '', 'Tập 22', 22, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipOM9MO3JUbF0Y3ha1sJ4i9-L72hNdRFtRQtFr7y?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'dIGGbJuwkU8', '', '', 0, '2018-07-30'),
(52, 10, '', 'Tập 23', 23, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipNdlYdH238xDbYGg6xc0RxILj8avHAn-dPAj9hX?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'IvHc78xysf4', '', '', 0, '2018-07-30'),
(53, 10, '', 'Tập 24', 24, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipM1ywlY1b5yBDhRDaMxE65q6QK1GpH44ckLmBSz?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'FWEtqo0fbbc', '', '', 0, '2018-07-30'),
(54, 10, '', 'Tập 25', 25, 'https://photos.google.com/u/1/share/AF1QipNrzvwU3f5MRUGFMJmKP8CLyBxqF1UH6dRuQ_IQI5biZbAhioWNZ8eH3FNoGEL1xA/photo/AF1QipOmdGdT73dQV8U8s42NmTbIgcu_9z8SwpTJN4Mq?key=dG5oOVJHZ2lDMDNtR1BWX2gtZ19wd2p6N05ud3hB', 'mhDsqh9IuhU', '', '', 0, '2018-07-30'),
(55, 11, '', 'Tập 1', 1, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMnug1ki5cX94alDFLUzhhS4kBXXb2M12OCTPze?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(56, 11, '', 'Tập 2', 2, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNx1kgP70ohkuhck2aoSnFmZvxvN67XoIN0hj0F?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(57, 11, '', 'Tập 3', 3, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMjbbq7vIjwfxCr0g1sOml5RYwPkCWLlaz-rlA4?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(58, 11, '', 'Tập 4', 4, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOij9s6bM96aDAqjt1Ljk_y6F0yF14bPLvBk78_?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(59, 11, '', 'Tập 5', 5, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipO31TYVOImBk7mXLN4_1uC2R94KuIKzX7VNdn8h?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(60, 11, '', 'Tập 6', 6, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNPvOA5F8p81NXSPuaziAgNRB7TFm6P4qPDGtje?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(61, 11, '', 'Tập 7', 7, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNF3qZFF5wO6vCNEhHdI4rpo0NCOnSZTfmzi5Vc?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(62, 11, '', 'Tập 8', 8, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOoGxBF9ZJ1kjMfhvIw3HaaLy7rF98DJFA-oDOc?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(63, 11, '', 'Tập 9', 9, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNpbUcH37W8E_0vAmFLISjJaSvMWodfrj7J9yiJ?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(64, 11, '', 'Tập 10', 10, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipM8O9am2WhC2tZbK_loAD4VlYIearLFutLb3nSJ?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(65, 11, '', 'Tập 11', 11, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMVzIFwVDbGPsQtBp27Ga-nVdziOHaHRdeR94U6?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(66, 11, '', 'Tập 12', 12, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipN0JD0dvHDM4JgJSqozKwgrJXvFSGemk4xCvuvy?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(67, 12, '', 'Tập 1', 1, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipPTIigU7kqEezcJ5cJHP5p8CDKMoJjC8HSk4uIW?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(68, 12, '', 'Tập 2', 2, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOsjJMuuRj6-EjUB9MzWX2HR3nJd5MIBXZBLCtt?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(69, 12, '', 'Tập 3', 3, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMAb_dOPB3AKPFosOnmtiRWj5thLaDYtuGYMXq0?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(70, 12, '', 'Tập 4', 4, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipML9Ztcpzr7RVUwUpwDulLqrJT2R0pwoPgiIUUs?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(71, 12, '', 'Tập 5', 5, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipPYYbH2QlJDRktqRU6Dr8t_AeghZ5wukQVsp4jW?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', '', '', '', 0, '2018-07-31'),
(72, 12, '', 'Tập 6', 6, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipO1TCVcJPthwv6M6DazLcUz6TzlCvtJIRyi24yK?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'uvrC9YliPFk', '', '', 0, '2018-07-31'),
(73, 12, '', 'Tập 7', 7, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipMIT2dOvZSascm1TUP7JZwKHwisE_Gjxnv1IzK2?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'GQVpPH5cQ8U', '', '', 0, '2018-07-31'),
(74, 12, '', 'Tập 8', 8, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOhR2LKup_cDKOBN9OPoVbn7nV5lAmSlrR7egCw?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'r0XwZIJjBCw', '', '', 0, '2018-07-31'),
(75, 12, '', 'Tập 9', 9, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipP7WaSkysdnNZUN_YTZpCddwZsy4U6XoD7eBb4_?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'K31lTK8KrSk', '', '', 0, '2018-07-31'),
(76, 12, '', 'Tập 10', 10, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNYWK4Ouo9dyB2T3qTGGcpRWYXZ-jxB9R_EzbzN?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'UifTOkSwQLg', '', '', 0, '2018-07-31'),
(77, 12, '', 'Tập 11', 11, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipNnQ-LrdIni-tFZAhQoSNyuTmHv8iayhvXqmEQL?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'A56Y7N73Rsc', '', '', 0, '2018-07-31'),
(78, 12, '', 'Tập 12', 12, 'https://photos.google.com/u/1/share/AF1QipNMUPI6iDSA0PjbIo3mLRlsWZT5PhJkpxs3KFNQpIJERPyLKI5UkpCShOa8z9onlQ/photo/AF1QipOa0d-5rX_oTra0iDCH7RPjJqfq1Bu29SMGj997?key=RUJnNEdDSFd0NWkwY0Y1Yy16UzN2dExsU1M1bTdR', 'QM8V1sKZ-5w', '', '', 0, '2018-07-31'),
(79, 8, '', 'Tập 6', 6, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipPGF6LIi5khPzlr7Xusqn-BIadyeollUcuHlNqY?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'q-OG8mezssk', '', '', 0, '2018-07-31'),
(80, 8, '', 'Tập 7', 7, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipPLpUP5PpTIATm3RsEHjyfrG3v8cYcHxOCYEqrR?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'tx-dCCne2FY', '', '', 0, '2018-07-31'),
(81, 8, '', 'Tập 8', 8, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipNcgGTqv-2XGL_bYAKidR1h11O930PFvBDbrWeG?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'GThKGrm6uaM', '', '', 0, '2018-07-31'),
(82, 8, '', 'Tập 9', 9, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipPO6erlbhBWD7hLSFwGejH7iac-YzGf_vb28Ha5?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', '-R7IS_VC5Uk', '', '', 0, '2018-07-31'),
(83, 8, '', 'Tập 10', 10, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipNQ8mjTeUbY_D869oig4Uj13PiliuAC8T6CI0on?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'apH2DlCx-i8', '', '', 0, '2018-07-31'),
(84, 8, '', 'Tập 11', 11, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipMjEcM9lJXsA7XKDCxrfHT2mVmeJ4OCUlIY5qfD?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'lQAH1nzOCEg', '', '', 0, '2018-07-31'),
(85, 8, '', 'Tập 12', 12, 'https://photos.google.com/u/1/share/AF1QipPOW1BxZb6WFL6rA1YjSDa5DjlPpP3CJzCbrLwd5Rm0Rro7cR7Mc-lBbnIg7GyQ7g/photo/AF1QipNorldQ8EyxOQZdzZz5Um2eE3iRQUGjCeoEscjM?key=RmN3MzdleFdkUnZZNEtodlFfN3VHam1iT2hBSTln', 'yZ2QN4U4SVU', '', '', 0, '2018-07-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theloai`
--

CREATE TABLE `theloai` (
  `theloai_id` int(11) NOT NULL,
  `theloai_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `theloai`
--

INSERT INTO `theloai` (`theloai_id`, `theloai_ten`) VALUES
(11, 'Hành động'),
(12, 'Học đường'),
(13, 'Thể thao'),
(14, 'Hài hước'),
(16, 'Kinh dị'),
(17, 'Vampire'),
(18, 'Game');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public/upload/avatar/user.png',
  `active` int(1) NOT NULL DEFAULT '1',
  `reason` text COLLATE utf8_unicode_ci,
  `locked_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `active`, `reason`, `locked_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'npvucusc@gmail.com', '$2y$10$G0a8qwRKX5eluvUsybjmIOFscYrmfMEtE2WkkuUA82M6Xojlq.e9K', 'public/upload/avatar/1532703250_Music-Anime-Naruto-Hd-572602.jpg', 1, NULL, NULL, 'Ru78LxvivjZYhARoJXG0Iqyu9X8Ff48kO7FC8YIciQBYRspRAnJzRb7A1wxE', '2018-07-07 23:06:42', '2018-07-27 08:12:07'),
(2, 'Administrator', 'nphivu104@gmail.com', '$2y$10$YQ8fo7pzVBmnjNe/owLhCe.dbpo8feJObkCmINvJsrxsPppsFHr5O', 'public/upload/avatar/user.png', 1, 'Phá hoại website', '2018-07-28 20:01:29', 'oRbkZPsHY9OXxZdnto9bqfr6TNNxFcuOzdZzW0tvtKI0e0WcTjhYcM9qlT87', '2018-07-26 00:03:23', '2018-07-26 00:03:23'),
(3, '!@#', 'nphivu105@gmail.com', '$2y$10$jkbJmq2LY7x756HPg3imE.GBk98JJmv/0I7PbPRVHajj2arlWZh1e', 'public/upload/avatar/user.png', 0, NULL, NULL, 'vDbJPUaqMhTJYEBmVF6kKs3wl637n0Kg2cOlGRkFvLqv8XRi7KfTrfOzQSqN', '2018-07-26 23:37:34', '2018-07-26 23:37:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_roles`
--

CREATE TABLE `users_roles` (
  `role_code` int(3) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users_roles`
--

INSERT INTO `users_roles` (`role_code`, `user_id`) VALUES
(100, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`user_id`,`phim_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `phim`
--
ALTER TABLE `phim`
  ADD PRIMARY KEY (`phim_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `tap`
--
ALTER TABLE `tap`
  ADD PRIMARY KEY (`tap_id`);

--
-- Chỉ mục cho bảng `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`theloai_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`role_code`,`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `phim`
--
ALTER TABLE `phim`
  MODIFY `phim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tap`
--
ALTER TABLE `tap`
  MODIFY `tap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT cho bảng `theloai`
--
ALTER TABLE `theloai`
  MODIFY `theloai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
