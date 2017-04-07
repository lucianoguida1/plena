-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 31-Mar-2017 às 16:09
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plena`
--
CREATE DATABASE IF NOT EXISTS `plena` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `plena`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamentos`
--

CREATE TABLE `equipamentos` (
  `id` int(11) NOT NULL,
  `tag` varchar(45) NOT NULL,
  `descricao` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id`, `tag`, `descricao`) VALUES
(2, '#guida', 'Teste'),
(8, 'Motor', 'Motor'),
(9, 'Furadeira', 'Furedeira de preção'),
(10, 'Caldeira', 'Caldas quente'),
(11, 'Asperção', 'Joga agua'),
(17, 'Bomba d\'gua', 'Bomba da represa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `IP` varchar(20) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lost_passwords`
--

CREATE TABLE `lost_passwords` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `IP` varchar(20) NOT NULL,
  `token` char(128) NOT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mecanicos`
--

CREATE TABLE `mecanicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `inscricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `mecanicos`
--

INSERT INTO `mecanicos` (`id`, `nome`, `inscricao`) VALUES
(1, 'Joazinho Lima', '111'),
(2, 'Darciel Coutinho', '12345');

-- --------------------------------------------------------

--
-- Estrutura da tabela `operantes`
--

CREATE TABLE `operantes` (
  `id` int(10) NOT NULL,
  `mecanico_id` int(11) NOT NULL,
  `registro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `operantes`
--

INSERT INTO `operantes` (`id`, `mecanico_id`, `registro_id`) VALUES
(1, 1, 15),
(2, 1, 16),
(3, 1, 17),
(4, 2, 18),
(5, 1, 19),
(6, 2, 19),
(7, 1, 21),
(8, 1, 22),
(9, 2, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pecas`
--

CREATE TABLE `pecas` (
  `id` int(11) NOT NULL,
  `peca` varchar(45) CHARACTER SET latin1 NOT NULL,
  `quantidade` int(11) NOT NULL,
  `registro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pecas`
--

INSERT INTO `pecas` (`id`, `peca`, `quantidade`, `registro_id`) VALUES
(38832, 'qwe', 123, 15),
(38833, 'qwe', 12, 15),
(38834, 'qwe', 123, 16),
(38835, 'qwe', 12, 16),
(38836, 'Rodo', 2, 17),
(38837, 'Parafuso', 4, 17),
(38838, 'Limpa Contato', 2, 18),
(38839, 'Limpa Contato', 1, 19),
(38842, 'qwe', 12, 21),
(38843, '312', 333, 21),
(38844, 'Limpa Contato', 5, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `tipo_servico` varchar(45) NOT NULL,
  `descricao_servico` longtext NOT NULL,
  `data_inicio` varchar(45) NOT NULL,
  `hora_inicio` varchar(45) NOT NULL,
  `data_termino` varchar(45) NOT NULL,
  `hora_termino` varchar(45) NOT NULL,
  `soma_dias` varchar(45) NOT NULL,
  `soma_horas` varchar(45) NOT NULL,
  `parada` varchar(45) NOT NULL,
  `causas` varchar(45) DEFAULT NULL,
  `horas_parada` varchar(45) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL,
  `equipamento_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `registros`
--

INSERT INTO `registros` (`id`, `tipo_servico`, `descricao_servico`, `data_inicio`, `hora_inicio`, `data_termino`, `hora_termino`, `soma_dias`, `soma_horas`, `parada`, `causas`, `horas_parada`, `data`, `status`, `equipamento_id`, `user_id`) VALUES
(15, 'Corretiva', '123', '0123-03-12', '12:23', '0123-03-12', '12:03', '0', '0', '', NULL, NULL, '2017-03-25 18:24:06', 1, 2, 8),
(16, 'Corretiva', '123', '0123-03-12', '12:23', '0123-03-12', '12:03', '0', '0', '', NULL, NULL, '2017-03-05 18:27:23', 1, 2, 8),
(17, 'Melhoria', 'Fizemos update na estrutura do equipamento para que o colaborador trabalhe com mais eficiÃªncia.', '2017-03-24', '14:00', '2017-03-25', '08:00', '2', '18', '', NULL, NULL, '2017-03-25 18:32:02', 1, 9, 8),
(18, 'Corretiva', 'O darciel fez a limpeza na tubulaÃ§Ã£o de energia do equiapamento', '2017-03-23', '09:00', '2017-03-23', '18:00', '0', '9', 'parada', NULL, NULL, '2017-03-31 18:33:48', 1, 11, 8),
(19, 'Corretiva', 'asd', '2222-02-22', '22:22', '2222-02-22', '22:22', '0', '0', '', NULL, NULL, '2017-01-23 17:34:10', 1, 2, 8),
(21, 'Predial', 'asd', '2017-11-08', '11:01', '2017-03-23', '12:33', '229', '22', '', NULL, NULL, '2017-03-31 01:41:46', 1, 17, 8),
(22, 'Corretiva', 'Foi realizado a manutenção. ', '2017-03-31', '08:00', '2017-03-31', '12:00', '0', '4', 'parada', NULL, NULL, '2017-03-31 15:57:37', 1, 8, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `role` varchar(45) NOT NULL,
  `status` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `salt`, `role`, `status`) VALUES
(7, '123', '123', '59def925aaec61474a670aa01e64403e5ac2b8ec96af13b075129a6346dc7312dc3bf5f24f791216279f0fccc7b7862f30e4ec0e1428b2b7707c0996407f7d2a', '3f8958e35efbcfeaedd8ac2d546bda9aba88371c9e5cbbf6de5613ea1a02868cd20936c11c9375b6d3d4f3dd84707fa6d66940054198e7524726a0a8131bbe50', 'user', 1),
(8, 'Luciano Guida', '1213', '6e34f1f7fa6dea6c4e790b0598ba7d7b7b20a178d35db5ca59410073af100a968c74b2c35dbc9b9cd0e894eef293312a1ac41f0f297d858e7e3ad72c96c1bf15', 'e5a9ff1e16892909beb8c38b55eb2f6358f7140d8bb146724c0c6a391d6899eaa8d2d45975bfe561a02b21b7e1275ebfc5ac2aa3945e6db0ed32a18c9a10fb86', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_attempts_user_id` (`user_id`);

--
-- Indexes for table `lost_passwords`
--
ALTER TABLE `lost_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lost_password_user_id_idx` (`user_id`);

--
-- Indexes for table `mecanicos`
--
ALTER TABLE `mecanicos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operantes`
--
ALTER TABLE `operantes`
  ADD PRIMARY KEY (`id`,`mecanico_id`,`registro_id`),
  ADD KEY `fk_mecanicos_has_registros_registros1_idx` (`registro_id`),
  ADD KEY `fk_mecanicos_has_registros_mecanicos1_idx` (`mecanico_id`);

--
-- Indexes for table `pecas`
--
ALTER TABLE `pecas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pecas_fk_registro_idx` (`registro_id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_registros_equipamentos1_idx` (`equipamento_id`),
  ADD KEY `fk_registros_users1_idx` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lost_passwords`
--
ALTER TABLE `lost_passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mecanicos`
--
ALTER TABLE `mecanicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `operantes`
--
ALTER TABLE `operantes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pecas`
--
ALTER TABLE `pecas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38845;
--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `operantes`
--
ALTER TABLE `operantes`
  ADD CONSTRAINT `fk_mecanicos_has_registros_mecanicos1` FOREIGN KEY (`mecanico_id`) REFERENCES `mecanicos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mecanicos_has_registros_registros1` FOREIGN KEY (`registro_id`) REFERENCES `registros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pecas`
--
ALTER TABLE `pecas`
  ADD CONSTRAINT `pecas_fk_registro` FOREIGN KEY (`registro_id`) REFERENCES `registros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `fk_registros_equipamentos1` FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registros_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
