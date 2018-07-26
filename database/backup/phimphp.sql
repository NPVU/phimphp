-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 26, 2018 lúc 10:17 AM
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
  `phim_hinhanh` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `phim_luotxem` int(11) NOT NULL DEFAULT '0',
  `phim_ngaycapnhat` date NOT NULL,
  `phim_hoanthanh` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phim`
--

INSERT INTO `phim` (`phim_id`, `theloai_id`, `phim_ten`, `phim_tenkhac`, `phim_gioithieu`, `phim_sotap`, `phim_nam`, `phim_tag`, `phim_hinhanh`, `phim_luotxem`, `phim_ngaycapnhat`, `phim_hoanthanh`) VALUES
(4, '[\"12\",\"13\",\"14\"]', 'Haikyuu', 'High Kyuu (2014)', 'hrhr', 25, 2014, 'Haikyuu', 'http://localhost/phimphp/public/upload/image/1532097377_haikyuu_____icon_2_by_elios96-d9eh5l0.png', 0, '2018-07-20', 0);

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
(1, 4, '1', '1', 1, 'https://photos.google.com/u/3/share/AF1QipNBR4FhwlXAleQmuT0qf6y0UXF4UtdSbL7jJAv7GJu8qxFVPL2bg5WEW30HX89MbQ/photo/AF1QipMMldPoVTFVXoEg85BPPQZF7QmRXcluP3-Xr9ym?key=bWM3Ums0SkJiVHVSTHNKME1NZmM4Z0w2ZXVmWmFR', 'openload', 'youtube', 'lcaohost', 1, '2018-07-23'),
(2, 4, '', '2', 2, '', '', '', '', 0, '2018-07-23');

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
(15, 'Robot');

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
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'npvucusc@gmail.com', '$2y$10$BQnYM36AToONWuGqp3RmE.3o3i3u1wps2xdzl5we0wE1uh0VjBjme', 'public/upload/avatar/1531551709_Music-Anime-Naruto-Hd-572602.jpg', 'sRenO9WBj8rjmJ6Y0ltf9dwGBh35KuP041L7iiqXT7ZzwlEZ2nl86oR9Smbs', '2018-07-07 23:06:42', '2018-07-22 03:20:44'),
(2, 'Administrator', 'nphivu104@gmail.com', '$2y$10$YQ8fo7pzVBmnjNe/owLhCe.dbpo8feJObkCmINvJsrxsPppsFHr5O', 'public/upload/avatar/user.png', 'ElNCwheC0bhW8T0dKHWL2TDYlb558bU2nZV3xruR4GTrcWFNRnsC7K8TrcaF', '2018-07-26 00:03:23', '2018-07-26 00:03:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_roles`
--

CREATE TABLE `users_roles` (
  `role_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users_roles`
--

INSERT INTO `users_roles` (`role_id`, `user_id`) VALUES
(100, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

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
  ADD PRIMARY KEY (`role_id`,`user_id`);

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
  MODIFY `phim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tap`
--
ALTER TABLE `tap`
  MODIFY `tap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `theloai`
--
ALTER TABLE `theloai`
  MODIFY `theloai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
