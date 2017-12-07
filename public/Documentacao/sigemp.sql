-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2017 at 01:00 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `descricao`) VALUES
(1, 'Analista T.I'),
(2, 'Professor'),
(3, 'Desenvolvedor'),
(4, 'Programador'),
(5, 'Banco de dados'),
(6, 'Redes'),
(7, 'Limpeza'),
(8, 'Gerente'),
(9, 'Analista de Redes'),
(10, 'Atendente'),
(11, 'SecretÃ¡ria'),
(12, 'Analista de AplicaÃ§Ã£o'),
(13, 'Auxiliar JurÃ­dico'),
(14, 'Gerente Comercial'),
(15, 'Consultor TÃ©cnico'),
(16, 'Engenheiro Qumico'),
(17, 'Engenheiro ProduÃ§Ã£o'),
(18, 'Funileiro'),
(19, 'Tester de Software'),
(20, 'Programador');

-- --------------------------------------------------------

--
-- Table structure for table `conhecimento`
--

CREATE TABLE `conhecimento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `conhecimento`
--

INSERT INTO `conhecimento` (`id`, `titulo`) VALUES
(2, 'PHP'),
(3, 'Java'),
(4, 'Redes'),
(5, 'Contabilidade Fiscal'),
(6, 'Porteiro'),
(7, 'SeguranÃ§a'),
(8, 'Banco de Dados'),
(9, 'Cabeamento');

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `curso_tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `curso`
--

INSERT INTO `curso` (`id`, `descricao`, `carga_horaria`, `curso_tipo`) VALUES
(1, 'PHP', 23, 'Doutorado'),
(2, 'Java', 110, 'Mestrado'),
(4, 'C++', 235, 'Mestrado'),
(5, 'Porteiro', 20, 'TÃ©cnico');

-- --------------------------------------------------------

--
-- Table structure for table `empregado`
--

CREATE TABLE `empregado` (
  `matricula` int(11) NOT NULL,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data_admissao` date NOT NULL,
  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `gerente` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cargo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `empregado`
--

INSERT INTO `empregado` (`matricula`, `nome`, `data_admissao`, `telefone`, `salario`, `cpf`, `gerente`, `cargo_id`) VALUES
(2, 'Juraci Barbosa', '1998-10-11', '43978637291', '7572.93', '4449299590', 'ativo', 1),
(3, 'Thais Narumi Tanizaki', '2017-12-22', '43998026581', '50000.00', '10432169954', 'ativo', 9),
(4, 'Isabelle Gomes', '2017-11-30', '32345453453', '1900.00', '83141414025', 'ativo', 11),
(5, 'William Gerenutti', '2017-12-06', '83748738479', '4000.00', '84116918610', 'ativo', 9),
(6, 'Daniela Soares', '2018-01-17', '45678965432', '980.00', '61781482160', 'inativo', 14),
(7, 'Daniel Henrique', '2017-12-01', '4565656561', '5000.00', '58397047760', 'inativo', 5),
(8, 'Henrique Camargo', '2017-12-02', '4654646532', '2000.00', '25522312092', 'inativo', 10),
(9, 'Pablo Vittar', '2017-12-01', '34343434334', '1000.00', '25298061443', 'ativo', 18),
(10, 'Selena Gomez', '2017-12-01', '929892929', '800.00', '94561772979', 'inativo', 4),
(11, 'Demi Lovato', '2017-12-13', '4545353535', '2308.00', '93874284514', 'inativo', 11);

-- --------------------------------------------------------

--
-- Table structure for table `empregado_conhecimento`
--

CREATE TABLE `empregado_conhecimento` (
  `empregado_matricula` int(11) NOT NULL,
  `conhecimento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empregado_conhecimento`
--

INSERT INTO `empregado_conhecimento` (`empregado_matricula`, `conhecimento_id`) VALUES
(11, 2),
(2, 3),
(3, 3),
(8, 3),
(9, 3),
(9, 4),
(2, 5),
(8, 5),
(5, 6),
(2, 7),
(11, 7),
(4, 8),
(5, 8),
(6, 8),
(10, 8),
(11, 8);

-- --------------------------------------------------------

--
-- Table structure for table `empregado_setor`
--

CREATE TABLE `empregado_setor` (
  `empregado_matricula` int(11) NOT NULL,
  `setor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empregado_turma`
--

CREATE TABLE `empregado_turma` (
  `empregado_matricula` int(11) DEFAULT NULL,
  `turma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `empregado_turma`
--

INSERT INTO `empregado_turma` (`empregado_matricula`, `turma_id`) VALUES
(2, 4),
(9, 4),
(10, 4),
(11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `instituicao`
--

CREATE TABLE `instituicao` (
  `id` int(11) NOT NULL,
  `cnpj` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `razao_social` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cep` int(11) NOT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `localizacao` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `instituicao`
--

INSERT INTO `instituicao` (`id`, `cnpj`, `razao_social`, `email`, `endereco`, `cep`, `bairro`, `telefone`, `localizacao`) VALUES
(1, '74657422000170', 'Unopar', '', 'Rua Sao Luis 255', 86828000, 'ShangrilÃ¡', '2873826332', 'Londrina'),
(2, '53609184000', 'Pitagoras', '', 'Porto Alegre 34', 73736382, 'Shimabokuro', '34354353534', 'Londrina - PR'),
(3, '49789663000', 'UTFPR', '', 'Rua Porto Alegre', 34454455, 'Bairro 2', '3544345454', 'SÃ£o Paulo - SP'),
(4, '22819808000', 'UFAC - Universidade Federal do Acre', '', 'Rua 2', 93847393, 'Porto Alegre', '2434342234', 'Acre - AC'),
(5, '98641485000', 'Universidade Estadual de Alagoas', '', 'Rua 3', 34324243, 'Branco', '2345544332', 'Porto - AL'),
(6, '15979636000', 'UFAL', '', 'Rua 7', 35343231, 'Bela Vista', '23234324234', 'Londrina - PR');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `nome`, `telefone`, `email`) VALUES
(1, 'Paulo', '35435345454', 'paulo@gmail.com'),
(2, 'Amanda', '39874389743', 'amanda@gmail.com'),
(3, 'Pedro', '8777666665', 'pedro@gmail.com'),
(4, 'Isabelle', '4983787842', 'isabelle@gmail.com'),
(5, 'Bicalho', '2343434242', 'bicalho@gmail.com'),
(7, 'Marcelo', '34534534534', 'marcelo@gmail.com'),
(8, 'Airtom', '35534543543', 'airtom@gmail.com'),
(9, 'Sandro', '44656456546', 'sandro@gmail.com'),
(10, 'Monica', '4534353534', 'monica@gmail.com'),
(11, 'Magali', '53453534543', 'magali@gmail.com'),
(12, 'Sirio', '11111111111', 'sirio@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `gerente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setor`
--

INSERT INTO `setor` (`id`, `nome`, `gerente_id`) VALUES
(5, 'Administrativo', 2),
(7, 'Redes', 9),
(8, 'Contabilidade', 4),
(9, 'Recursos Humanos', 4);

-- --------------------------------------------------------

--
-- Table structure for table `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `aplicacao` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `instituicao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `turma`
--

INSERT INTO `turma` (`id`, `nome`, `valor`, `aplicacao`, `curso_id`, `instituicao_id`) VALUES
(4, 'Turma de porteiros', '1000.00', 1, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `turma_professor`
--

CREATE TABLE `turma_professor` (
  `turma_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `turma_professor`
--

INSERT INTO `turma_professor` (`turma_id`, `professor_id`) VALUES
(4, 7),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `turma_programacao`
--

CREATE TABLE `turma_programacao` (
  `id` int(11) NOT NULL,
  `data_realizacao` date NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  `local` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `turma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `turma_programacao`
--

INSERT INTO `turma_programacao` (`id`, `data_realizacao`, `hora_inicial`, `hora_final`, `local`, `turma_id`) VALUES
(7, '2017-12-04', '12:00:00', '17:00:00', 'LaboratÃ³rio 1', 4),
(8, '2017-12-18', '15:00:00', '17:00:00', 'laboratÃ³rio 1', 4),
(9, '2017-12-06', '15:00:00', '17:00:00', 'Computador', 4);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `autorizacao` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome_completo`, `login`, `senha`, `autorizacao`) VALUES
(1, 'WIlliam Gerenutti', 'wgerenutti', 'teste123', 'admin'),
(2, 'Thais Narumi', 'narumi', 'teste123', 'admin'),
(3, 'Isabelle Soares', 'isasoares', 'teste123', 'admin'),
(4, 'usuario teste', 'teste', 'teste123', 'comum');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conhecimento`
--
ALTER TABLE `conhecimento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empregado`
--
ALTER TABLE `empregado`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `empregado_conhecimento`
--
ALTER TABLE `empregado_conhecimento`
  ADD KEY `empregado_matriula3` (`empregado_matricula`),
  ADD KEY `conhecimento_id2` (`conhecimento_id`);

--
-- Indexes for table `empregado_setor`
--
ALTER TABLE `empregado_setor`
  ADD KEY `empregado_matricula` (`empregado_matricula`),
  ADD KEY `setor_id` (`setor_id`);

--
-- Indexes for table `empregado_turma`
--
ALTER TABLE `empregado_turma`
  ADD KEY `empregado_matricula` (`empregado_matricula`),
  ADD KEY `turma_codigo` (`turma_id`);

--
-- Indexes for table `instituicao`
--
ALTER TABLE `instituicao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerente_id` (`gerente_id`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instituicao_id` (`instituicao_id`);

--
-- Indexes for table `turma_professor`
--
ALTER TABLE `turma_professor`
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `turma_programacao`
--
ALTER TABLE `turma_programacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turma_id_2` (`turma_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `conhecimento`
--
ALTER TABLE `conhecimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `empregado`
--
ALTER TABLE `empregado`
  MODIFY `matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `instituicao`
--
ALTER TABLE `instituicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `turma_programacao`
--
ALTER TABLE `turma_programacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `empregado`
--
ALTER TABLE `empregado`
  ADD CONSTRAINT `cargo_id1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `empregado_conhecimento`
--
ALTER TABLE `empregado_conhecimento`
  ADD CONSTRAINT `conhecimento_id2` FOREIGN KEY (`conhecimento_id`) REFERENCES `conhecimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `empregado_matriula3` FOREIGN KEY (`empregado_matricula`) REFERENCES `empregado` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `empregado_setor`
--
ALTER TABLE `empregado_setor`
  ADD CONSTRAINT `empregado_matricula6` FOREIGN KEY (`empregado_matricula`) REFERENCES `empregado` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `setor_id2` FOREIGN KEY (`setor_id`) REFERENCES `setor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `empregado_turma`
--
ALTER TABLE `empregado_turma`
  ADD CONSTRAINT `empregado_matricula5` FOREIGN KEY (`empregado_matricula`) REFERENCES `empregado` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `turma_id3` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`);

--
-- Constraints for table `setor`
--
ALTER TABLE `setor`
  ADD CONSTRAINT `gerente_id` FOREIGN KEY (`gerente_id`) REFERENCES `empregado` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `turma_professor`
--
ALTER TABLE `turma_professor`
  ADD CONSTRAINT `professor_id` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `turma_id` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `turma_programacao`
--
ALTER TABLE `turma_programacao`
  ADD CONSTRAINT `turma_id2` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
