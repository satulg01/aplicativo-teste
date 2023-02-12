-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Fev-2023 às 14:02
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aplicativo_teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `blocked_ips`
--

CREATE TABLE `blocked_ips` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `block_date` datetime NOT NULL DEFAULT current_timestamp(),
  `block_expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `collaborators`
--

CREATE TABLE `collaborators` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `document` varchar(14) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(80) NOT NULL,
  `access` varchar(2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attemps`
--

CREATE TABLE `login_attemps` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `user` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `brand`, `status`) VALUES
(1, 'Batata doce doce como mel\'', 'Bem gostosa', 'Yoki', 1),
(2, 'Arroz com feijão \'', 'Arroz com feijão \'gostoso e grande', 'Namoradoss', 1),
(3, '', '', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recebimentos`
--

CREATE TABLE `recebimentos` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `identificador` varchar(100) COLLATE utf8_bin NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `id_collaborator` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `document` varchar(14) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `access` varchar(4) NOT NULL,
  `token` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `id_collaborator`, `user`, `document`, `pass`, `access`, `token`, `status`) VALUES
(1, 'Roger', 0, 'roger', '999.999.999-99', 'ac7ac098c005624121c2c94a4e5fb52124a8ddd8', 'A', '', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `blocked_ips`
--
ALTER TABLE `blocked_ips`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `login_attemps`
--
ALTER TABLE `login_attemps`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recebimentos`
--
ALTER TABLE `recebimentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `blocked_ips`
--
ALTER TABLE `blocked_ips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login_attemps`
--
ALTER TABLE `login_attemps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `recebimentos`
--
ALTER TABLE `recebimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
