-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/05/2024 às 23:11
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
-- Banco de dados: `school_sync`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `status_administrador` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `usuario_id`, `cargo`, `status_administrador`) VALUES
(2, 28, 'Material de Apoio', NULL),
(3, 31, 'Administradora geral', 1);

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

--
-- Despejando dados para a tabela `conquista`
--

INSERT INTO `conquista` (`id`, `aluno_id`, `professor_id`, `titulo`, `descricao`, `data_conquista`, `comentario`) VALUES
(1, 1, 1, 'Destaque em Projetos Criativos', 'Reconhecimento pelo excelente desempenho na apresentação de projetos criativos durante o semestre.', '2024-05-16', 'Reconhecimento pelo excelente desempenho na apresentação de projetos criativos durante o semestre.'),
(2, 1, 1, 'Excelência Acadêmica em Matemática', 'Reconhecimento pelo excelente desempenho em matemática, demonstrando habilidades excepcionais na resolução de problemas complexos.', '2024-04-30', 'Reconhecimento pelo excelente desempenho em matemática, demonstrando habilidades excepcionais na resolução de problemas complexos.'),
(3, 1, 1, 'Participação Destacada em Competição de Ciências', 'Reconhecimento pela brilhante participação e resultados excepcionais em uma competição de ciências a nível estadual.', '2024-09-11', 'Reconhecimento pela brilhante participação e resultados excepcionais em uma competição de ciências a nível estadual.');

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
  `professor_id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `evento`
--

INSERT INTO `evento` (`id`, `titulo`, `descricao`, `inicio`, `termino`, `status_evento`, `professor_id`, `classe_id`) VALUES
(1, 'Feira Cultural e Científica', 'Uma celebração anual de talentos e conhecimento, apresentando projetos criativos, experimentos científicos e performances culturais.', '2024-05-13 00:00:00', '2024-05-17 00:00:00', 'Em breve', 1, 1);

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

--
-- Despejando dados para a tabela `falta`
--

INSERT INTO `falta` (`id`, `aluno_id`, `materia_id`, `data_falta`, `motivo`, `created_at`) VALUES
(1, 1, 1, '2024-05-13', 'Falta não justificada', '2024-05-16 17:37:24'),
(2, 1, 2, '2024-05-12', 'Falta não justificada', '2024-05-16 17:37:24'),
(3, 1, 3, '2024-05-14', 'Falta não justificada', '2024-05-16 17:37:24'),
(4, 1, 4, '2024-05-09', 'Falta não justificada', '2024-05-16 17:37:24'),
(5, 1, 5, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:24'),
(6, 1, 6, '2024-05-13', 'Falta não justificada', '2024-05-16 17:37:24'),
(7, 1, 7, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:24'),
(8, 1, 1, '2024-05-08', 'Falta não justificada', '2024-05-16 17:37:52'),
(9, 1, 2, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:52'),
(10, 1, 3, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:52'),
(11, 1, 4, '2024-05-15', 'Falta não justificada', '2024-05-16 17:37:52'),
(12, 1, 5, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:52'),
(13, 1, 6, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:52'),
(14, 1, 7, '2024-05-07', 'Falta não justificada', '2024-05-16 17:37:52');

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

--
-- Despejando dados para a tabela `materia`
--

INSERT INTO `materia` (`id`, `disciplina`, `quantidade_aula`, `serie`) VALUES
(1, 'Matemática', 15, '5'),
(2, 'Português', 15, '5'),
(3, 'História', 15, '5'),
(4, 'Geografia', 15, '5'),
(5, 'Ciências', 15, '5'),
(6, 'Artes', 15, '5'),
(7, 'Inglês', 15, '5');

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

--
-- Despejando dados para a tabela `nota`
--

INSERT INTO `nota` (`id`, `aluno_id`, `materia_id`, `titulo`, `data_avaliacao`, `nota`, `observacoes`, `created_at`) VALUES
(1, 1, 1, 'Prova 1', '2024-05-01', 7.89, 'Sem observações', '2024-05-16 17:35:53'),
(2, 1, 2, 'Prova 1', '2024-05-01', 9.96, 'Sem observações', '2024-05-16 17:35:53'),
(3, 1, 3, 'Prova 1', '2024-05-01', 6.12, 'Sem observações', '2024-05-16 17:35:53'),
(4, 1, 4, 'Prova 1', '2024-05-01', 0.74, 'Sem observações', '2024-05-16 17:35:53'),
(5, 1, 5, 'Prova 1', '2024-05-01', 5.35, 'Sem observações', '2024-05-16 17:35:53'),
(6, 1, 6, 'Prova 1', '2024-05-01', 4.52, 'Sem observações', '2024-05-16 17:35:53'),
(7, 1, 7, 'Prova 1', '2024-05-01', 6.56, 'Sem observações', '2024-05-16 17:35:53'),
(8, 1, 1, 'Prova 2', '2024-05-08', 9.23, 'Sem observações', '2024-05-16 17:35:53'),
(9, 1, 2, 'Prova 2', '2024-05-08', 6.48, 'Sem observações', '2024-05-16 17:35:53'),
(10, 1, 3, 'Prova 2', '2024-05-08', 4.71, 'Sem observações', '2024-05-16 17:35:53'),
(11, 1, 4, 'Prova 2', '2024-05-08', 4.11, 'Sem observações', '2024-05-16 17:35:53'),
(12, 1, 5, 'Prova 2', '2024-05-08', 6.40, 'Sem observações', '2024-05-16 17:35:53'),
(13, 1, 6, 'Prova 2', '2024-05-08', 9.68, 'Sem observações', '2024-05-16 17:35:53'),
(14, 1, 7, 'Prova 2', '2024-05-08', 9.20, 'Sem observações', '2024-05-16 17:35:53'),
(15, 1, 1, 'Prova 3', '2024-05-15', 6.96, 'Sem observações', '2024-05-16 17:35:53'),
(16, 1, 2, 'Prova 3', '2024-05-15', 7.21, 'Sem observações', '2024-05-16 17:35:53'),
(17, 1, 3, 'Prova 3', '2024-05-15', 5.17, 'Sem observações', '2024-05-16 17:35:53'),
(18, 1, 4, 'Prova 3', '2024-05-15', 4.20, 'Sem observações', '2024-05-16 17:35:53'),
(19, 1, 5, 'Prova 3', '2024-05-15', 5.52, 'Sem observações', '2024-05-16 17:35:53'),
(20, 1, 6, 'Prova 3', '2024-05-15', 4.99, 'Sem observações', '2024-05-16 17:35:53'),
(21, 1, 7, 'Prova 3', '2024-05-15', 8.37, 'Sem observações', '2024-05-16 17:35:53'),
(22, 1, 1, 'Prova 4', '2024-05-22', 6.88, 'Sem observações', '2024-05-16 17:35:53'),
(23, 1, 2, 'Prova 4', '2024-05-22', 9.31, 'Sem observações', '2024-05-16 17:35:53'),
(24, 1, 3, 'Prova 4', '2024-05-22', 5.89, 'Sem observações', '2024-05-16 17:35:53'),
(25, 1, 4, 'Prova 4', '2024-05-22', 1.54, 'Sem observações', '2024-05-16 17:35:53'),
(26, 1, 5, 'Prova 4', '2024-05-22', 0.04, 'Sem observações', '2024-05-16 17:35:53'),
(27, 1, 6, 'Prova 4', '2024-05-22', 5.57, 'Sem observações', '2024-05-16 17:35:53'),
(28, 1, 7, 'Prova 4', '2024-05-22', 7.71, 'Sem observações', '2024-05-16 17:35:53'),
(29, 1, 1, 'Prova 5', '2024-05-29', 1.86, 'Sem observações', '2024-05-16 17:35:53'),
(30, 1, 2, 'Prova 5', '2024-05-29', 6.18, 'Sem observações', '2024-05-16 17:35:53'),
(31, 1, 3, 'Prova 5', '2024-05-29', 5.31, 'Sem observações', '2024-05-16 17:35:53'),
(32, 1, 4, 'Prova 5', '2024-05-29', 8.01, 'Sem observações', '2024-05-16 17:35:53'),
(33, 1, 5, 'Prova 5', '2024-05-29', 4.10, 'Sem observações', '2024-05-16 17:35:53'),
(34, 1, 6, 'Prova 5', '2024-05-29', 6.50, 'Sem observações', '2024-05-16 17:35:53'),
(35, 1, 7, 'Prova 5', '2024-05-29', 0.19, 'Sem observações', '2024-05-16 17:35:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `status_professor` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id`, `usuario_id`, `cpf`, `status_professor`) VALUES
(1, 26, '123.456.789-10', 1),
(2, 30, '137.792.398-33', 1),
(3, 33, '475.975.258-77', 1);

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

--
-- Despejando dados para a tabela `recurso_educacional`
--

INSERT INTO `recurso_educacional` (`id`, `administrador_id`, `titulo`, `descricao`, `url`, `escolaridade`, `tipo`, `created_at`) VALUES
(1, 2, 'Aprendendo python', 'Python é uma linguagem de programação de alto nível,[5] interpretada de script, imperativa, orientada a objetos, funcional, de tipagem dinâmica e forte. Foi lançada por Guido van Rossum em 1991.[1] Atualmente, possui um modelo de desenvolvimento comunitário, aberto e gerenciado pela organização sem fins lucrativos Python Software Foundation. Apesar de várias partes da linguagem possuírem padrões e especificações formais, a linguagem, como um todo, não é formalmente especificada. O padrão na pratica é a implementação CPython.', 'https://pt.wikipedia.org/wiki/Python', 5, 'site', '2024-05-16 17:55:25');

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
(1, 29, '123.321.112-89', '1999990021', 1, 1),
(2, 32, '567.345.098-54', '19546352854', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `categoria` varchar(16) NOT NULL,
  `imagem_perfil` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `imagem_perfil`, `created_at`) VALUES
(2, 'Maria eduarda', 'duda@gmail.com', '$2y$10$pgfTOKtY1x4Lgyl4ipmfSuyT0fiyxBtUHFBAO/OwPIRJyilm2wjQ2', 'Aluno', NULL, NULL),
(26, 'lucass d', 'lucas@d.com', '$2y$10$waY0RWuDq4J38Hi1kjvUo.TDiVwqFQAgVaUKLX3rrri0uujOFXZLy', 'Professor', NULL, '2024-04-25 08:47:08'),
(27, 'Vitor Santos', 'vitor@gmail.com.br', '12345678', 'Aluno', NULL, '2024-04-25 08:49:56'),
(28, 'Cleiton Silva', 'silva@admin.com', '$2y$10$D6TdwpClG6KJLgAR0fnxO.LyKjogk0DqGvLCjJo5JAHoJYaIj04ES', 'Administrador', NULL, '2024-04-25 08:49:56'),
(29, 'Ramiris da Silva Souza', 'ram@.com', '$2y$10$HFPMl8ELwvbEonmcBwHKb.U33u2Ba6uicypJV5JruYns.2g8Inxoy', 'Responsável', '', '2024-04-25 08:53:49'),
(30, 'teste', 'teste@gmail.com', '$2y$10$2GL8e', 'Professor', NULL, '2024-05-12 23:48:20'),
(31, 'Karina Souza', 'karinasouza@gmail.com', '$2y$10$OqL6caa/LhIAoy/GaA9q7.mIXeovP8KKmpxnF6nolsJZYs.0jQLsS', 'Administrador', NULL, '2024-05-16 08:28:09'),
(32, 'Jean Lucas', 'jeanlucas@gmail.com', '$2y$10$VU1Aeg8JiaTdzAJYd4lnvuYQyNQEWvq2ETTkRvlqxH0BB2zsjYEMe', 'Responsavel', NULL, '2024-05-16 08:49:10'),
(33, 'Henrique Oliveira', 'henrique@teste.com', '$2y$10$9cOfMJlXMGUk6Oc0jYHru.JtCIVAeji0QhkhLooyo32brXMAiao.q', 'Administrador', NULL, '2024-05-16 17:20:19'),
(34, 'TESTE01', 'TESTE01@gmail.com', 'TESTE01', 'Aluno', NULL, '2024-05-16 17:31:51');

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
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `classe_id` (`classe_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `falta`
--
ALTER TABLE `falta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recurso_educacional`
--
ALTER TABLE `recurso_educacional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `responsavel`
--
ALTER TABLE `responsavel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`);

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
