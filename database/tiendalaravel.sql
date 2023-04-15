-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:33065
-- Tiempo de generación: 15-04-2023 a las 23:43:14
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendalaravel`
--
CREATE DATABASE IF NOT EXISTS `tiendalaravel` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `tiendalaravel`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catNombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `catNombre`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Electrodomestico', NULL, '2023-04-15 21:45:37', '2023-04-15 21:45:37'),
(2, 'Calzado', NULL, '2023-04-15 21:45:37', '2023-04-15 21:45:37'),
(3, 'Alimento', NULL, '2023-04-16 00:10:38', '2023-04-16 00:10:38'),
(4, 'Juguete', '2023-04-16 00:13:34', '2023-04-16 00:11:02', '2023-04-16 00:13:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_04_14_212236_create_categories_table', 1),
(3, '2023_04_14_212258_create_products_table', 1),
(4, '2023_04_14_212644_create_roles_table', 1),
(5, '2023_04_15_161920_create_users_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'fa63c87aa537119128376fe3a4f89a139b53933ec68a95945dba8b4598d5d5d5', '[\"*\"]', '2023-04-16 02:35:54', NULL, '2023-04-16 01:20:48', '2023-04-16 02:35:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proCodigo` int(11) NOT NULL,
  `proNombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proPrecio` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proDescripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `proImagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `proCodigo`, `proNombre`, `proPrecio`, `category_id`, `proDescripcion`, `proImagen`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 8585, 'TV Smart', 2500000, 1, 'El mejor TV', 'FR84VR4V48R48V', NULL, '2023-04-15 16:46:21', '2023-04-15 16:46:21'),
(2, 1242, 'Nike Jordan', 190000, 2, 'La mejor calidad', '14rv4r8vr4v', NULL, '2023-04-15 16:46:21', '2023-04-15 16:46:21'),
(3, 645, 'Nevera 500 litros', 2300000, 1, 'La mejor nevera con mayor capacidad', 'ced5e84f4efefe', NULL, '2023-04-15 22:50:54', '2023-04-15 23:47:50'),
(4, 423, 'Adidas predator', 320000, 2, 'Adidas tu mejor eleccion', '4tg4t5gtgt5', '2023-04-15 23:50:51', '2023-04-15 23:50:19', '2023-04-15 23:50:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rolNombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rolNombre`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Usuario', NULL, '2023-04-15 21:45:37', '2023-04-15 21:45:37'),
(2, 'Administrador', NULL, '2023-04-15 21:45:37', '2023-04-15 21:45:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `useNombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `useCorreo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usePassword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `useNombre`, `role_id`, `useCorreo`, `usePassword`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Santiago Cuellar', 2, 'santiago@gmail.com', '$2y$10$y5HJefVq62vcJRMTwqe5j.r7nbZbirM2rVPsRVdhVrd3BtswPzf2W', NULL, '2023-04-16 00:33:33', '2023-04-16 00:42:40'),
(2, 'Javier Bermeo', 2, 'usuario4@gmail.com', '$2y$10$v5dpyIwE3.XjvkDGSZBQPurEeElh1siVXdWTCavoHcFYhRs6RlZYG', '2023-04-16 00:38:03', '2023-04-16 00:35:49', '2023-04-16 00:38:03'),
(3, 'Marcela Cuellar', 2, 'marcela@gmail.com', '$2y$10$.SuOyFpgHUWcVjhCZ9JYUud76bz11nlLLXiKWtoiSTmgA1Cx88nlW', NULL, '2023-04-16 00:36:03', '2023-04-16 00:42:57'),
(4, 'Ronald Perdomo', 1, 'ronald@gmail.com', '$2y$10$OnLcUgiOFqKapxmhIeK8PeGBHTh5jAtn.8Qx16//M8j6ggf2CiaMu', NULL, '2023-04-16 00:36:23', '2023-04-16 00:44:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
