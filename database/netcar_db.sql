-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2023 às 05:10
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
-- Banco de dados: `netcar`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `access`
--

INSERT INTO `access` (`id`, `code`, `description`) VALUES
(1, 'admin', 'Administrador do sistema'),
(2, 'client', 'Cliente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `id_model` int(11) DEFAULT NULL,
  `price` float NOT NULL,
  `fuel` varchar(30) NOT NULL,
  `year` varchar(10) NOT NULL,
  `kilometers` float NOT NULL,
  `color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `car_itens`
--

CREATE TABLE `car_itens` (
  `id` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `receipt` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_car` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_access` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `birthDate` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `addressNumber` int(11) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `complement` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `id_access`, `name`, `surname`, `birthDate`, `email`, `password`, `cpf`, `phone`, `cep`, `addressNumber`, `street`, `complement`) VALUES
(1, 1, 'dev', 'test', '2001-01-01', 'dev@test.com', 'dGVzdEB0ZXN0', '11111111111', '11111111111', NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `brand`
--
ALTER TABLE `brand`
  ADD UNIQUE KEY `code`(`code`),
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_model` (`id_model`);

--
-- Índices para tabela `car_itens`
--
ALTER TABLE `car_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_car` (`id_car`),
  ADD KEY `id_item` (`id_item`);

--
-- Índices para tabela `item`
--
ALTER TABLE `item`
  ADD UNIQUE KEY `code`(`code`),
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code`(`code`),
  ADD KEY `id_brand` (`id_brand`);

--
-- Índices para tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_car` (`id_car`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `id_access` (`id_access`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_2` FOREIGN KEY (`id_model`) REFERENCES `model` (`id`);

--
ALTER TABLE `model`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id`);

--
-- Limitadores para a tabela `car_itens`
--
ALTER TABLE `car_itens`
  ADD CONSTRAINT `car_itens_ibfk_1` FOREIGN KEY (`id_car`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `car_itens_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`);

--
-- Limitadores para a tabela `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `car` (`id`);

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_access`) REFERENCES `access` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
