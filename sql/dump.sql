CREATE DATABASE IF NOT EXISTS `star_warss` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `star_warss`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_session_id` varchar(255) NOT NULL,
  `film_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `film_poster`
--

CREATE TABLE `film_poster` (
  `id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `cover_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `film_poster`
--

INSERT INTO `film_poster` (`id`, `episode_id`, `cover_path`) VALUES
(1, 1, 'episode_1.jpg'),
(2, 2, 'episode_2.jpg'),
(3, 3, 'episode_3.jpg'),
(4, 4, 'episode_4.jpg'),
(5, 5, 'episode_5.jpg'),
(6, 6, 'episode_6.jpg'),
(7, 7, 'episode_7.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `film_trailers`
--

CREATE TABLE `film_trailers` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `trailer_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `film_trailers`
--

INSERT INTO `film_trailers` (`id`, `film_id`, `trailer_url`, `created_at`) VALUES
(8, 1, 'https://www.youtube.com/embed/bD7bpG-zDJQ', '2025-01-18 23:02:58'),
(9, 2, 'https://www.youtube.com/embed/gYbW1F_c9eM', '2025-01-18 23:02:58'),
(10, 3, 'https://www.youtube.com/embed/5UnjrG_N8hU', '2025-01-18 23:02:58'),
(11, 4, 'https://www.youtube.com/embed/vZ734NWnAHA', '2025-01-18 23:02:58'),
(12, 5, 'https://www.youtube.com/embed/JNwNXF9Y6kY', '2025-01-18 23:02:58'),
(13, 6, 'https://www.youtube.com/embed/5UfA_aKBGMc', '2025-01-18 23:02:58'),
(14, 7, 'https://www.youtube.com/embed/sGbxmsDFVnE', '2025-01-18 23:02:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `request_type` varchar(10) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `film_poster`
--
ALTER TABLE `film_poster`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `episode_id` (`episode_id`);

--
-- Índices para tabela `film_trailers`
--
ALTER TABLE `film_trailers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `film_poster`
--
ALTER TABLE `film_poster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `film_trailers`
--
ALTER TABLE `film_trailers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

