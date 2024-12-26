-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/12/2024 às 01:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `social`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `following_id`, `created_at`) VALUES
(2, 3, 2, '2024-12-25 22:12:08'),
(3, 4, 2, '2024-12-25 22:13:52'),
(4, 4, 3, '2024-12-25 22:14:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(1, 3, 3, '2024-12-25 22:07:15'),
(2, 3, 4, '2024-12-25 22:07:18'),
(3, 4, 4, '2024-12-25 22:13:10'),
(10, 3, 6, '2024-12-25 22:24:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`) VALUES
(3, 2, 'Hoje o almoço estava muito bom', '2024-12-25 22:04:35'),
(4, 2, 'Quando vai sair o próximo filme', '2024-12-25 22:05:18'),
(5, 3, 'Dia lindo para andar de bicicleta', '2024-12-25 22:05:55'),
(6, 4, 'Que fome hoje', '2024-12-25 22:14:38'),
(11, 3, 'Que dia bonito', '2024-12-25 22:24:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `profile_visits`
--

CREATE TABLE `profile_visits` (
  `id` int(11) NOT NULL,
  `visitor_user_id` int(11) NOT NULL,
  `visited_user_id` int(11) NOT NULL,
  `visit_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `profile_visits`
--

INSERT INTO `profile_visits` (`id`, `visitor_user_id`, `visited_user_id`, `visit_time`) VALUES
(15, 2, 2, '2024-12-25 19:04:38'),
(16, 2, 2, '2024-12-25 19:04:55'),
(17, 3, 3, '2024-12-25 19:07:24'),
(18, 3, 3, '2024-12-25 19:07:40'),
(19, 3, 3, '2024-12-25 19:07:52'),
(20, 3, 2, '2024-12-25 19:07:57'),
(21, 3, 2, '2024-12-25 23:10:01'),
(22, 3, 2, '2024-12-25 23:11:02'),
(23, 3, 2, '2024-12-25 23:11:06'),
(24, 3, 2, '2024-12-25 23:11:08'),
(25, 3, 2, '2024-12-25 23:12:02'),
(26, 3, 2, '2024-12-25 23:12:04'),
(27, 3, 2, '2024-12-25 23:12:06'),
(28, 3, 2, '2024-12-25 23:12:08'),
(29, 3, 2, '2024-12-25 23:12:13'),
(30, 3, 3, '2024-12-25 23:12:22'),
(31, 4, 4, '2024-12-25 23:13:40'),
(32, 4, 2, '2024-12-25 23:13:50'),
(33, 4, 2, '2024-12-25 23:13:52'),
(34, 4, 3, '2024-12-25 23:14:46'),
(35, 4, 3, '2024-12-25 23:14:49'),
(36, 4, 4, '2024-12-25 23:16:16'),
(42, 3, 2, '2024-12-25 23:23:46'),
(43, 3, 3, '2024-12-25 23:24:11'),
(44, 3, 3, '2024-12-25 23:24:29'),
(45, 3, 3, '2024-12-25 23:34:45'),
(46, 3, 3, '2024-12-26 00:08:53'),
(47, 3, 4, '2024-12-26 00:08:57'),
(48, 3, 2, '2024-12-26 00:09:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `bio`) VALUES
(2, 'Leonardo', 'leonardo@leonardo', '$2y$10$xuDaht8QsHlwSdIZGuxLI.rYXxv.swG9GCoXToHVLM41Nq.eDf53C', '2024-12-25 22:04:24', 'Tenho 17 e moro no Brasil'),
(3, 'Lucas', 'lucas@lucas', '$2y$10$msjqstjo7ILdmV4Kf7mkou12DTcWFMqhED4IvsuNftIKj1/6FNBvK', '2024-12-25 22:05:42', 'Gosto de sair para festas\r\nE curtir a vida'),
(4, 'Vitor', 'vitor@vitor', '$2y$10$cKBcgJFXhgwAjWnySzBwIeuW8xA7u.JFuT7qcS68FDHW1UFKy3Mny', '2024-12-25 22:12:56', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Índices de tabela `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `profile_visits`
--
ALTER TABLE `profile_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_user_id` (`visitor_user_id`),
  ADD KEY `visited_user_id` (`visited_user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `profile_visits`
--
ALTER TABLE `profile_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `profile_visits`
--
ALTER TABLE `profile_visits`
  ADD CONSTRAINT `profile_visits_ibfk_1` FOREIGN KEY (`visitor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `profile_visits_ibfk_2` FOREIGN KEY (`visited_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
