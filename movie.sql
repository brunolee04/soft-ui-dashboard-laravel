-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Jan-2023 às 15:27
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `movie`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `actor`
--

CREATE TABLE `actor` (
  `actor_id` int(11) NOT NULL,
  `actor_name` varchar(45) NOT NULL,
  `actor_image_url` varchar(45) NOT NULL,
  `actor_image_source` varchar(45) DEFAULT NULL,
  `actor_source_url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `actor_description`
--

CREATE TABLE `actor_description` (
  `actor_description_id` int(11) NOT NULL,
  `actor_description_description` text DEFAULT NULL,
  `actor_actor_id` int(11) NOT NULL,
  `language_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `actor_to_movie`
--

CREATE TABLE `actor_to_movie` (
  `actor_to_movie_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `actor_actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `challenge`
--

CREATE TABLE `challenge` (
  `challenge_id` int(11) NOT NULL,
  `challenge_image_url` varchar(45) DEFAULT NULL,
  `challenge_rule` text DEFAULT NULL COMMENT 'regra do desafio em formato json\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `challenge_description`
--

CREATE TABLE `challenge_description` (
  `challenge_description_id` int(11) NOT NULL,
  `challenge_description_name` varchar(45) NOT NULL,
  `challenge_description_description` text NOT NULL,
  `challenge_challenge_id` int(11) NOT NULL,
  `language_language_id` int(11) NOT NULL,
  `challenge_description_prize` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `customer_firstname` varchar(25) NOT NULL,
  `customer_lastname` varchar(45) NOT NULL,
  `customer_mail` varchar(45) DEFAULT NULL,
  `customer_pass` varchar(25) DEFAULT NULL,
  `customer_status` smallint(6) DEFAULT NULL,
  `customer_date_birth` date DEFAULT NULL,
  `customer_user_id` varchar(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer_list`
--

CREATE TABLE `customer_list` (
  `customer_list_id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `customer_list_name` varchar(45) NOT NULL,
  `customer_list_date_added` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer_movie_comment`
--

CREATE TABLE `customer_movie_comment` (
  `customer_movie_comment_id` int(11) NOT NULL,
  `customer_movie_comment_comment` varchar(300) NOT NULL,
  `customer_movie_comment_language_code` varchar(10) DEFAULT NULL,
  `customer_movie_comment_date_added` datetime DEFAULT NULL,
  `customer_customer_id` int(11) NOT NULL,
  `movie_season_movie_season_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer_rates_movie`
--

CREATE TABLE `customer_rates_movie` (
  `customer_rates_movie_id` int(11) NOT NULL,
  `customer_rates_movie_rate` float DEFAULT NULL COMMENT 'pode ser nulo, no caso do cliente apenas marcar o filme como ''visto'', sem ter o ter avaliado. Em caso de uma avaliação, a linha será editada.',
  `customer_rates_movie_date_added` datetime NOT NULL,
  `customer_customer_id` int(11) NOT NULL,
  `movie_season_movie_season_id` int(11) NOT NULL COMMENT 'Cada filme ou série deverá ter obrigatóriamente ao menos 1 temporada. Inclusive, no caso dos filmes, 1 temporada será vinculada a ele.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estrutura da tabela `streaming`
--

CREATE TABLE `streaming` (
  `streaming_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `streaming_name` varchar(25) NOT NULL,
  `streaming_image` varchar(150),
  `streaming_image_url` varchar(200),
  `streaming_status` smallint
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer streaming`
--

CREATE TABLE `customer_streaming` (
  `customer_streaming_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `streaming_id` int NOT NULL,
  `customer_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------



--
-- Estrutura da tabela `director`
--

CREATE TABLE `director` (
  `director_id` int(11) NOT NULL,
  `director_name` varchar(45) DEFAULT NULL,
  `director_image_source` varchar(45) DEFAULT NULL,
  `director_source_url` varchar(45) DEFAULT NULL,
  `director_image_url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `director_description`
--

CREATE TABLE `director_description` (
  `director_description_id` int(11) NOT NULL,
  `director_description_description` text DEFAULT NULL,
  `director_director_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `director_to_movie`
--

CREATE TABLE `director_to_movie` (
  `director_to_movie_id` int(11) NOT NULL,
  `director_director_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `language`
--

CREATE TABLE `language` (
  `language_id` int(11) NOT NULL,
  `language_name` varchar(15) NOT NULL,
  `language_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `language`
--

INSERT INTO `language` (`language_id`, `language_name`, `language_code`) VALUES
(1, 'Português - BR', 'pt-br'),
(2, 'English', 'en-us');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie`
--

CREATE TABLE `movie` (
  `movie_id` int(11) NOT NULL,
  `movie_duration` smallint(6) DEFAULT NULL,
  `movie_year_launch` smallint(6) DEFAULT NULL,
  `movie_date_launch` date DEFAULT NULL,
  `movie_rating` smallint(6) DEFAULT NULL COMMENT 'nota geral do filme baseado no calculo temporário da média das notas dadas.',
  `movie_parental_rating` varchar(3) DEFAULT NULL COMMENT 'classificação indicativa do filme',
  `movie_date_added` date DEFAULT NULL,
  `movie_feed_url` varchar(120) DEFAULT NULL,
  `movie_image_1` varchar(120) DEFAULT NULL,
  `movie_image_2` varchar(120) DEFAULT NULL,
  `movie_type_movie_type_id` int(11) NOT NULL COMMENT '0 - filme, 1 - série',
  `movie_imdb_id` varchar(15) DEFAULT NULL,
  `local_url_movie_image1` varchar(120) DEFAULT NULL,
  `local_url_movie_image2` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movie`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_description`
--

CREATE TABLE `movie_description` (
  `movie_description_id` int(11) NOT NULL,
  `movie_description_name` varchar(100) NOT NULL,
  `movie_description_description` text DEFAULT NULL,
  `language_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `movie_description_tagline` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movie_description`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_image`
--

CREATE TABLE `movie_image` (
  `movie_image_id` int(11) NOT NULL,
  `movie_image_source` varchar(45) DEFAULT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_season`
--

CREATE TABLE `movie_season` (
  `movie_season_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_to_customer_list`
--

CREATE TABLE `movie_to_customer_list` (
  `movie_to_customer_list_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `customer_list_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_type`
--

CREATE TABLE `movie_type` (
  `movie_type_id` int(11) NOT NULL,
  `movie_type_name` varchar(45) DEFAULT NULL COMMENT 'identificar se é FILME,SÉRIE ou ANIME\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_video`
--

CREATE TABLE `movie_video` (
  `movie_video_id` int(11) NOT NULL,
  `movie_video_engine` varchar(15) NOT NULL COMMENT 'origem do módulo do vídeo: YOUTUBE, VIMEO... etc.',
  `movie_video_url_source` varchar(45) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `movie_video_description` text DEFAULT NULL,
  `movie_videocol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `movie_gender`(
  `movie_gender_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `language_id` int,
  `movie_gender_name` varchar(50),
  `api_gender_id` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

CREATE TABLE `movie_to_movie_gender`(
  `movie_to_movie_gender_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `movie_id` int(11),
  `movie_gender_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estrutura da tabela `password_resets`
--


CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_list`
--

CREATE TABLE `system_list` (
  `system_list_id` int(11) NOT NULL,
  `system_list_date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_list_description`
--

CREATE TABLE `system_list_description` (
  `system_list_description_id` int(11) NOT NULL,
  `system_list_description_name` varchar(45) NOT NULL,
  `system_list_description` text DEFAULT NULL,
  `system_list_system_list_id` int(11) NOT NULL,
  `language_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `trophy`
--

CREATE TABLE `trophy` (
  `trophy_id` int(11) NOT NULL,
  `trophy_image` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `trophy_description`
--

CREATE TABLE `trophy_description` (
  `trophy_description_id` int(11) NOT NULL,
  `trophy_description_name` varchar(45) NOT NULL,
  `trophy_description_description` varchar(45) DEFAULT NULL,
  `trophy_trophy_id` int(11) NOT NULL,
  `language_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `trophy_to_customer`
--

CREATE TABLE `trophy_to_customer` (
  `trophy_to_customer_id` int(11) NOT NULL,
  `trophy_to_customer_date_added` date DEFAULT NULL,
  `trophy_trophy_id` int(11) NOT NULL,
  `customer_customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(30) NOT NULL,
  `user_lastname` varchar(45) NOT NULL,
  `user_mail` varchar(30) NOT NULL,
  `user_pass` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `about_me`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@softui.com', '$2y$10$3jLGThtCATsaQC.YeoHLgO8AJMXUxmU3O24Fm9vnD5unDgwRk48IW', NULL, NULL, NULL, NULL, '2023-01-05 22:18:58', '2023-01-05 22:18:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `writer`
--

CREATE TABLE `writer` (
  `writer_id` int(11) NOT NULL,
  `writer_name` varchar(45) DEFAULT NULL,
  `writer_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `writer_description`
--

CREATE TABLE `writer_description` (
  `writer_description_id` int(11) NOT NULL,
  `writer_description_description` text DEFAULT NULL,
  `language_language_id` int(11) NOT NULL,
  `writer_writer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `writer_to_movie`
--

CREATE TABLE `writer_to_movie` (
  `writer_to_movie_id` int(11) NOT NULL,
  `writer_writer_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`actor_id`);

--
-- Índices para tabela `actor_description`
--
ALTER TABLE `actor_description`
  ADD PRIMARY KEY (`actor_description_id`);

--
-- Índices para tabela `actor_to_movie`
--
ALTER TABLE `actor_to_movie`
  ADD PRIMARY KEY (`actor_to_movie_id`);

--
-- Índices para tabela `challenge`
--
ALTER TABLE `challenge`
  ADD PRIMARY KEY (`challenge_id`);

--
-- Índices para tabela `challenge_description`
--
ALTER TABLE `challenge_description`
  ADD PRIMARY KEY (`challenge_description_id`);

--
-- Índices para tabela `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Índices para tabela `customer_list`
--
ALTER TABLE `customer_list`
  ADD PRIMARY KEY (`customer_list_id`);

--
-- Índices para tabela `customer_movie_comment`
--
ALTER TABLE `customer_movie_comment`
  ADD PRIMARY KEY (`customer_movie_comment_id`);

--
-- Índices para tabela `customer_rates_movie`
--
ALTER TABLE `customer_rates_movie`
  ADD PRIMARY KEY (`customer_rates_movie_id`);

--
-- Índices para tabela `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`director_id`);

--
-- Índices para tabela `director_description`
--
ALTER TABLE `director_description`
  ADD PRIMARY KEY (`director_description_id`);

--
-- Índices para tabela `director_to_movie`
--
ALTER TABLE `director_to_movie`
  ADD PRIMARY KEY (`director_to_movie_id`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Índices para tabela `movie_description`
--
ALTER TABLE `movie_description`
  ADD PRIMARY KEY (`movie_description_id`);

--
-- Índices para tabela `movie_image`
--
ALTER TABLE `movie_image`
  ADD PRIMARY KEY (`movie_image_id`);

--
-- Índices para tabela `movie_season`
--
ALTER TABLE `movie_season`
  ADD PRIMARY KEY (`movie_season_id`);

--
-- Índices para tabela `movie_to_customer_list`
--
ALTER TABLE `movie_to_customer_list`
  ADD PRIMARY KEY (`movie_to_customer_list_id`);

--
-- Índices para tabela `movie_type`
--
ALTER TABLE `movie_type`
  ADD PRIMARY KEY (`movie_type_id`);

--
-- Índices para tabela `movie_video`
--
ALTER TABLE `movie_video`
  ADD PRIMARY KEY (`movie_video_id`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `system_list`
--
ALTER TABLE `system_list`
  ADD PRIMARY KEY (`system_list_id`);

--
-- Índices para tabela `system_list_description`
--
ALTER TABLE `system_list_description`
  ADD PRIMARY KEY (`system_list_description_id`);

--
-- Índices para tabela `trophy`
--
ALTER TABLE `trophy`
  ADD PRIMARY KEY (`trophy_id`);

--
-- Índices para tabela `trophy_description`
--
ALTER TABLE `trophy_description`
  ADD PRIMARY KEY (`trophy_description_id`);

--
-- Índices para tabela `trophy_to_customer`
--
ALTER TABLE `trophy_to_customer`
  ADD PRIMARY KEY (`trophy_to_customer_id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Índices para tabela `writer`
--
ALTER TABLE `writer`
  ADD PRIMARY KEY (`writer_id`);

--
-- Índices para tabela `writer_description`
--
ALTER TABLE `writer_description`
  ADD PRIMARY KEY (`writer_description_id`);

--
-- Índices para tabela `writer_to_movie`
--
ALTER TABLE `writer_to_movie`
  ADD PRIMARY KEY (`writer_to_movie_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `actor`
--
ALTER TABLE `actor`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `actor_description`
--
ALTER TABLE `actor_description`
  MODIFY `actor_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `actor_to_movie`
--
ALTER TABLE `actor_to_movie`
  MODIFY `actor_to_movie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `challenge`
--
ALTER TABLE `challenge`
  MODIFY `challenge_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `challenge_description`
--
ALTER TABLE `challenge_description`
  MODIFY `challenge_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `customer_list`
--
ALTER TABLE `customer_list`
  MODIFY `customer_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `customer_movie_comment`
--
ALTER TABLE `customer_movie_comment`
  MODIFY `customer_movie_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `customer_rates_movie`
--
ALTER TABLE `customer_rates_movie`
  MODIFY `customer_rates_movie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `director`
--
ALTER TABLE `director`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `director_description`
--
ALTER TABLE `director_description`
  MODIFY `director_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `director_to_movie`
--
ALTER TABLE `director_to_movie`
  MODIFY `director_to_movie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `language`
--
ALTER TABLE `language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `movie_description`
--
ALTER TABLE `movie_description`
  MODIFY `movie_description_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `movie_image`
--
ALTER TABLE `movie_image`
  MODIFY `movie_image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movie_season`
--
ALTER TABLE `movie_season`
  MODIFY `movie_season_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movie_to_customer_list`
--
ALTER TABLE `movie_to_customer_list`
  MODIFY `movie_to_customer_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movie_type`
--
ALTER TABLE `movie_type`
  MODIFY `movie_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movie_video`
--
ALTER TABLE `movie_video`
  MODIFY `movie_video_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `system_list`
--
ALTER TABLE `system_list`
  MODIFY `system_list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `system_list_description`
--
ALTER TABLE `system_list_description`
  MODIFY `system_list_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trophy`
--
ALTER TABLE `trophy`
  MODIFY `trophy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trophy_description`
--
ALTER TABLE `trophy_description`
  MODIFY `trophy_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trophy_to_customer`
--
ALTER TABLE `trophy_to_customer`
  MODIFY `trophy_to_customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `writer`
--
ALTER TABLE `writer`
  MODIFY `writer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `writer_description`
--
ALTER TABLE `writer_description`
  MODIFY `writer_description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `writer_to_movie`
--
ALTER TABLE `writer_to_movie`
  MODIFY `writer_to_movie_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `watch_provider`(
  watch_provider_id int not null AUTO_INCREMENT PRIMARY KEY,
  watch_provider_name varchar(60),
  watch_provider_image_link varchar(150),
  watch_provider_image_local varchar(150),
  watch_provider_display_priority int,
  watch_provider_site_id int
);


CREATE TABLE `movie_to_watch_provider`(
  movie_to_watch_provider_id int not null AUTO_INCREMENT PRIMARY KEY,
  movie_id int,
  watch_provider_id int
);