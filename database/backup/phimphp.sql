-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 30, 2018 lúc 10:18 AM
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
(8, '[\"11\"]', 'Claymore', 'Phù thủy mắt bạc', 'Yoma! Quái vật ăn phủ tạng con người. Chúng sống dưới lốt nạn nhân trà trộn vào thế giới loài người. Không ai hay cũng ko ai biết duy chỉ có Claymore - Những thiếu nữ mang trong mình máu thịt của loài quái vật sở hữu đôi mắt làm thành danh tiếng của họ. Phù Thủy Mắt Bạc! Những thiếu nữ mất đi hạnh phúc, mất đi tương lai và liệu Clare - Teresa có bảo vệ họ trước loài Awakened Beings hay với cái tên là loài Thức Tỉnh ...', 26, 2007, 'claymore', 'http://localhost/phimphp/public/upload/image/1532850716_claymore_folder_icon_by_euterpemusa-d4ie3mr.png', 'http://localhost/phimphp/public/upload/image/1532850718_204023.jpg', 0, '2018-07-29', 0, 'youtube'),
(9, '[\"11\"]', 'Tokyo Ghoul Phần 1', 'Ngạ quỷ Phần 1', NULL, 12, 2014, 'tokyo ghoul, ngạ quỷ', 'https://orig00.deviantart.net/5618/f/2014/270/9/e/tokyo_ghoul_folder_icon_by_adrianecchi-d80qf3y.png', 'https://i.pinimg.com/originals/72/51/6a/72516a470c0cb4c2610742e181a2a074.jpg', 0, '2018-07-29', 0, 'phimmoi'),
(10, '[\"11\",\"16\"]', 'Attack on Titan Phần 1', 'Shingeki no Kyojin Phần 1', NULL, 25, 2013, 'attack on titan, titan', 'https://orig00.deviantart.net/8e7b/f/2014/266/0/1/shingeki_no_kyojin___icon_folder_by_ubagutobr-d80bkqw.png', 'https://i2.wp.com/attackongeek.com/wp-content/uploads/2017/08/attack-on-titan-ss2-wallpaper-backgrounds-hd-08.jpg', 0, '2018-07-30', 0, 'phimmoi, youtube');

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
(5, 8, '', 'Tập 1', 1, '', '', 'https://www.youtube.com/embed/XNu1jLd4JdA?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(6, 8, '', 'Tập 2', 2, '', '', 'https://www.youtube.com/embed/ZkTTAmkL0r0?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(7, 8, '', 'Tập 3', 3, '', '', 'https://www.youtube.com/embed/qg8cSdp55vQ?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(8, 8, '', 'Tập 4', 4, '', '', 'https://www.youtube.com/embed/xjFkfFg4u-Y?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(9, 8, '', 'Tập 5', 5, 'https://photos.google.com/u/3/share/AF1QipNBR4FhwlXAleQmuT0qf6y0UXF4UtdSbL7jJAv7GJu8qxFVPL2bg5WEW30HX89MbQ/photo/AF1QipMMldPoVTFVXoEg85BPPQZF7QmRXcluP3-Xr9ym?key=bWM3Ums0SkJiVHVSTHNKME1NZmM4Z0w2ZXVmWmFR', '', 'https://www.youtube.com/embed/ZlOIdJBiH7g?rel=0&amp;showinfo=0', '', 0, '2018-07-29'),
(10, 9, '', 'Tập 1', 1, '', '', '', '', 0, '2018-07-29'),
(11, 10, '', 'Tập 1', 1, '', '', 'https://www.youtube.com/embed/Da4hSNinQl4?rel=0&amp;showinfo=0', '', 0, '2018-07-30');

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
  MODIFY `phim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tap`
--
ALTER TABLE `tap`
  MODIFY `tap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
