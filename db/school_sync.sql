-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/04/2024 às 18:42
-- Versão do servidor: 10.4.27-MariaDB
-- Versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `school_sync`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cargo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `usuario_id`, `cargo`) VALUES
(2, 28, 'Material de Apoio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `responsavel_id` int(11) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `escolaridade` int(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `classe_id` int(11) NOT NULL,
  `status_aluno` tinyint(1) DEFAULT 1,
  `escola` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `usuario_id`, `responsavel_id`, `genero`, `escolaridade`, `data_nascimento`, `classe_id`, `status_aluno`, `escola`) VALUES
(1, 2, 1, 'Feminino', 5, '2016-04-07', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `classe`
--

CREATE TABLE `classe` (
  `id` int(11) NOT NULL,
  `nome` varchar(10) NOT NULL,
  `serie` varchar(2) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `classe`
--

INSERT INTO `classe` (`id`, `nome`, `serie`, `professor_id`, `created_at`) VALUES
(1, '5 A', '5', 1, '2024-04-25 09:01:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `classe_materia`
--

CREATE TABLE `classe_materia` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `conquista`
--

CREATE TABLE `conquista` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `data_conquista` date NOT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `inicio` datetime NOT NULL,
  `termino` datetime NOT NULL,
  `status_evento` enum('Em andamento','Relizado','Em breve') DEFAULT 'Em breve',
  `professor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `falta`
--

CREATE TABLE `falta` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `data_falta` date NOT NULL,
  `motivo` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `corpo` text NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_bimestral`
--

CREATE TABLE `historico_bimestral` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `media` float DEFAULT NULL,
  `falta` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `disciplina` varchar(50) NOT NULL,
  `quantidade_aula` int(11) NOT NULL,
  `serie` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota`
--

CREATE TABLE `nota` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `data_avaliacao` date NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  `observacoes` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cpf` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id`, `usuario_id`, `cpf`) VALUES
(1, 26, '123.456.789-10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_materia`
--

CREATE TABLE `professor_materia` (
  `id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recurso_educacional`
--

CREATE TABLE `recurso_educacional` (
  `id` int(11) NOT NULL,
  `administrador_id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `url` varchar(500) NOT NULL,
  `escolaridade` int(11) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `responsavel`
--

CREATE TABLE `responsavel` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `quantidade_filho` int(11) NOT NULL,
  `status_responsavel` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `responsavel`
--

INSERT INTO `responsavel` (`id`, `usuario_id`, `cpf`, `telefone`, `quantidade_filho`, `status_responsavel`) VALUES
(1, 29, '123.321.112-89', '1999990021', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(12) NOT NULL,
  `categoria` varchar(16) NOT NULL,
  `imagem_perfil` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `imagem_perfil`, `created_at`) VALUES
(2, 'Maria eduarda', 'duda@gmail.com', '123456789', 'aluna', NULL, NULL),
(26, 'lucass d', 'lucas@d.com', '123456789', 'Professor', NULL, '2024-04-25 08:47:08'),
(27, 'Vitor Santos', 'vitor@gmail.com.br', '12345678', 'Aluno', NULL, '2024-04-25 08:49:56'),
(28, 'Cleiton Silva', 'silva@admin.com', '123456789', 'Administrador', NULL, '2024-04-25 08:49:56'),
(29, 'Ramiris da Silva Souza', 'ram@.com', '123', 'Responsável', '', '2024-04-25 08:53:49'),
(30, 'Vitor H. P. dos Santos', 'pireshugo737@gmail.com', 'VitorSantos2', 'Administrador', NULL, '2024-04-16 12:43:58'),
(31, 'Maria Natalia', 'cardim.natalia@gmail.com', 'marianatalia', 'Administrador', NULL, '2024-04-27 13:30:13'),
(32, 'Gabriel Luccareli', 'gabriellucc02@gmail.com', 'gabriellucc', 'Administrador', NULL, '2024-04-27 13:32:36'),
(33, 'Henrique de Oliveira', 'henrique.s.oliveira1998@gmail.com', 'henriqueoliv', 'Administrador', NULL, '2024-04-27 13:34:15'),
(34, 'Emanuel Maximiano', 'maximianoe989@gmail.com', 'maximianoe', 'Administrador', NULL, '2024-04-27 13:35:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_evento`
--

CREATE TABLE `usuario_evento` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `data_participacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_recurso_educacional`
--

CREATE TABLE `usuario_recurso_educacional` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `recurso_educacional_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `responsavel_id` (`responsavel_id`),
  ADD KEY `id_fk_classe` (`classe_id`);

--
-- Índices de tabela `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices de tabela `classe_materia`
--
ALTER TABLE `classe_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `conquista`
--
ALTER TABLE `conquista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices de tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices de tabela `falta`
--
ALTER TABLE `falta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `historico_bimestral`
--
ALTER TABLE `historico_bimestral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `recurso_educacional`
--
ALTER TABLE `recurso_educacional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrador_id` (`administrador_id`);

--
-- Índices de tabela `responsavel`
--
ALTER TABLE `responsavel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuario_evento`
--
ALTER TABLE `usuario_evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Índices de tabela `usuario_recurso_educacional`
--
ALTER TABLE `usuario_recurso_educacional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `recurso_educacional_id` (`recurso_educacional_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `classe`
--
ALTER TABLE `classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `classe_materia`
--
ALTER TABLE `classe_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conquista`
--
ALTER TABLE `conquista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `falta`
--
ALTER TABLE `falta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_bimestral`
--
ALTER TABLE `historico_bimestral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recurso_educacional`
--
ALTER TABLE `recurso_educacional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `responsavel`
--
ALTER TABLE `responsavel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `usuario_evento`
--
ALTER TABLE `usuario_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_recurso_educacional`
--
ALTER TABLE `usuario_recurso_educacional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `aluno_ibfk_3` FOREIGN KEY (`responsavel_id`) REFERENCES `responsavel` (`id`),
  ADD CONSTRAINT `id_fk_classe` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`);

--
-- Restrições para tabelas `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`);

--
-- Restrições para tabelas `classe_materia`
--
ALTER TABLE `classe_materia`
  ADD CONSTRAINT `classe_materia_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`),
  ADD CONSTRAINT `classe_materia_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Restrições para tabelas `conquista`
--
ALTER TABLE `conquista`
  ADD CONSTRAINT `conquista_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `conquista_ibfk_2` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`);

--
-- Restrições para tabelas `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`);

--
-- Restrições para tabelas `falta`
--
ALTER TABLE `falta`
  ADD CONSTRAINT `falta_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `falta_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Restrições para tabelas `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `historico_bimestral`
--
ALTER TABLE `historico_bimestral`
  ADD CONSTRAINT `historico_bimestral_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `historico_bimestral_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Restrições para tabelas `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Restrições para tabelas `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `professor_materia`
--
ALTER TABLE `professor_materia`
  ADD CONSTRAINT `professor_materia_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `professor_materia_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Restrições para tabelas `recurso_educacional`
--
ALTER TABLE `recurso_educacional`
  ADD CONSTRAINT `recurso_educacional_ibfk_1` FOREIGN KEY (`administrador_id`) REFERENCES `administrador` (`id`);

--
-- Restrições para tabelas `responsavel`
--
ALTER TABLE `responsavel`
  ADD CONSTRAINT `responsavel_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `usuario_evento`
--
ALTER TABLE `usuario_evento`
  ADD CONSTRAINT `usuario_evento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuario_evento_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`);

--
-- Restrições para tabelas `usuario_recurso_educacional`
--
ALTER TABLE `usuario_recurso_educacional`
  ADD CONSTRAINT `usuario_recurso_educacional_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuario_recurso_educacional_ibfk_2` FOREIGN KEY (`recurso_educacional_id`) REFERENCES `recurso_educacional` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
