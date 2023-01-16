-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Jan-2023 às 20:44
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

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
  `movie_movie_id` int(11) NOT NULL,
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

CREATE TABLE `production_company`(
    `production_company_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `production_company_name` varchar(40),
    `production_companies_logo_url` varchar(150),
    `api_production_company_id` int(11)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `movie_to_production_company`(
    `movie_to_production_company_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `movie_id` int(11),
    `production_company_id` int(11)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `customer_id` int(11) NOT NULL,
  `customer_firstname` varchar(25) NOT NULL,
  `customer_lastname` varchar(45) NOT NULL,
  `customer_mail` varchar(45) DEFAULT NULL,
  `customer_pass` varchar(25) DEFAULT NULL,
  `customer_status` smallint(6) DEFAULT NULL,
  `customer_date_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer_list`
--

CREATE TABLE `customer_list` (
  `customer_list_id` int(11) NOT NULL,
  `customer_list_name` varchar(45) NOT NULL,
  `customer_list_date_added` date DEFAULT NULL,
  `customer_customer_id` int(11) NOT NULL
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
  `movie_movie_id` int(11) NOT NULL
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

INSERT INTO `movie` (`movie_id`, `movie_duration`, `movie_year_launch`, `movie_date_launch`, `movie_rating`, `movie_parental_rating`, `movie_date_added`, `movie_feed_url`, `movie_image_1`, `movie_image_2`, `movie_type_movie_type_id`, `movie_imdb_id`, `local_url_movie_image1`, `local_url_movie_image2`) VALUES
(1, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(2, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(3, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(4, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(5, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(6, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(7, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(8, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(9, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(10, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(11, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(12, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(13, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(14, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(15, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(16, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(17, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(18, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(19, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(20, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(21, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(22, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg'),
(23, 192, 2022, '2022-12-14', NULL, 'L', '2023-01-16', 'https://api.themoviedb.org/3/movie/76600?api_key=dad5a9de706bc0fc9219b3b42cb9c530&language=pt-BR', 'https://image.tmdb.org/t/p/original/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg', 0, 'tt1630029', 'http://127.0.0.1:8000/storage/app/public/movie/mbYQLLluS651W89jO7MOZcLSCUw.jpg', 'http://127.0.0.1:8000/storage/app/public/movie/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg');

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

INSERT INTO `movie_description` (`movie_description_id`, `movie_description_name`, `movie_description_description`, `language_id`, `movie_id`, `movie_description_tagline`) VALUES
(1, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 2, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(2, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 3, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(3, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 4, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(4, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 5, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(5, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 6, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(6, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 7, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(7, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 8, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(8, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 9, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(9, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 10, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(10, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 11, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(11, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 12, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(12, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 13, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(13, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 14, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(14, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 15, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(15, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 16, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(16, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 17, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(17, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 18, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(18, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 19, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(19, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 20, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(20, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 21, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(21, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 22, 'Aonde nós formos, esta família é a nossa fortaleza.'),
(22, 'Avatar: O Caminho da Água', '12 anos depois de explorar Pandora e se juntar aos Na\'vi, Jake Sully formou uma família com Neytiri e se estabeleceu entre os clãs do novo mundo. Porém, a paz não durará para sempre.', 1, 23, 'Aonde nós formos, esta família é a nossa fortaleza.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_gender`
--

CREATE TABLE `movie_gender` (
  `movie_gender_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `movie_gender_name` varchar(50) DEFAULT NULL,
  `api_gender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movie_gender`
--

INSERT INTO `movie_gender` (`movie_gender_id`, `language_id`, `movie_gender_name`, `api_gender_id`) VALUES
(11, 1, 'Ficção científica', 878),
(12, 1, 'Aventura', 12),
(13, 1, 'Ação', 28);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_image`
--

CREATE TABLE `movie_image` (
  `movie_image_id` int(11) NOT NULL,
  `movie_image_source` varchar(45) DEFAULT NULL,
  `movie_movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_season`
--

CREATE TABLE `movie_season` (
  `movie_season_id` int(11) NOT NULL,
  `movie_movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_to_customer_list`
--

CREATE TABLE `movie_to_customer_list` (
  `movie_to_customer_list_id` int(11) NOT NULL,
  `customer_list_customer_list_id` int(11) NOT NULL,
  `movie_movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movie_to_movie_gender`
--

CREATE TABLE `movie_to_movie_gender` (
  `movie_to_movie_gender_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `movie_gender_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movie_to_movie_gender`
--

INSERT INTO `movie_to_movie_gender` (`movie_to_movie_gender_id`, `movie_id`, `movie_gender_id`) VALUES
(32, 23, 11),
(33, 23, 12),
(34, 23, 13);

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
  `movie_movie_id` int(11) NOT NULL,
  `movie_video_description` text DEFAULT NULL,
  `movie_videocol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

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
(1, 'admin', 'admin@softui.com', '$2y$10$rGC/cZWkkawZAe5wWA/sru43drc8Wyng5Gh9xOFaW0I7whjJank6m', NULL, NULL, NULL, NULL, '2023-01-12 23:21:51', '2023-01-12 23:21:51');

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
  `movie_movie_id` int(11) NOT NULL
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
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Índices para tabela `movie_gender`
--
ALTER TABLE `movie_gender`
  ADD PRIMARY KEY (`movie_gender_id`);

--
-- Índices para tabela `movie_to_movie_gender`
--
ALTER TABLE `movie_to_movie_gender`
  ADD PRIMARY KEY (`movie_to_movie_gender_id`);

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
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `movie_description`
--
ALTER TABLE `movie_description`
  MODIFY `movie_description_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `movie_gender`
--
ALTER TABLE `movie_gender`
  MODIFY `movie_gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `movie_to_movie_gender`
--
ALTER TABLE `movie_to_movie_gender`
  MODIFY `movie_to_movie_gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
