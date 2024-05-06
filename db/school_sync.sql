-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/05/2024 às 03:11
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
(1, '5 A', '5', 1, '2024-04-25 09:01:45'),
(2, '6A', '6', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `classe_materia`
--

CREATE TABLE `classe_materia` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `classe_materia`
--

INSERT INTO `classe_materia` (`id`, `classe_id`, `materia_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8);

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
(11, 1, 1, 'Medalha de Honra ao Mérito', 'Medalha de Honra ao Mérito por ajudar os colegas', '2024-05-02', 'Medalha de Honra ao Mérito por ajudar os colegas'),
(12, 1, 1, 'Certificado de Participação em Competições Acadêmi', 'Certificado de Participação em Competições Acadêmicas - OBMEP', '2024-05-18', 'Certificado de Participação em Competições Acadêmicas - OBMEP');

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
  `classe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `evento`
--

INSERT INTO `evento` (`id`, `titulo`, `descricao`, `inicio`, `termino`, `status_evento`, `professor_id`, `classe_id`) VALUES
(23, 'Conferência de Tecnologia', 'Conferência de Tecnologia da escola', '2024-05-02 00:00:00', '2024-05-03 00:00:00', 'Em breve', 1, 1),
(24, 'Feira de Ciências', 'Feira de Ciências do colégio', '2024-05-06 00:00:00', '2024-05-10 00:00:00', 'Em breve', 1, 1),
(25, 'Mostra Cultural', 'Mostra Cultural de arte', '2024-04-11 00:00:00', '2024-04-11 00:00:00', 'Em breve', 1, 1),
(26, 'Hackathon', 'Hackathon com os alunos da escola.', '2024-05-01 22:06:58', '2024-05-31 22:06:58', 'Em breve', 1, 1);

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
(1, 1, 1, '2024-05-02', 'Doença', '2024-05-02 21:57:24'),
(2, 1, 1, '2024-05-05', 'Família', '2024-05-02 21:57:24'),
(3, 1, 1, '2024-05-09', 'Problema de transporte', '2024-05-02 21:57:24'),
(4, 1, 1, '2024-05-12', 'Doença', '2024-05-02 21:57:24'),
(7, 1, 1, '2024-05-23', 'Outro motivo', '2024-05-02 21:57:24'),
(8, 1, 2, '2024-05-03', 'Doença', '2024-05-02 21:57:24'),
(11, 1, 2, '2024-05-13', 'Doença', '2024-05-02 21:57:24'),
(12, 1, 2, '2024-05-17', 'Família', '2024-05-02 21:57:24'),
(13, 1, 2, '2024-05-20', 'Problema de transporte', '2024-05-02 21:57:24'),
(14, 1, 2, '2024-05-24', 'Outro motivo', '2024-05-02 21:57:24'),
(15, 1, 3, '2024-05-04', 'Doença', '2024-05-02 21:57:24'),
(16, 1, 3, '2024-05-07', 'Família', '2024-05-02 21:57:24'),
(17, 1, 3, '2024-05-11', 'Problema de transporte', '2024-05-02 21:57:24'),
(21, 1, 3, '2024-05-25', 'Outro motivo', '2024-05-02 21:57:24'),
(22, 1, 4, '2024-05-05', 'Doença', '2024-05-02 21:57:24'),
(23, 1, 4, '2024-05-08', 'Família', '2024-05-02 21:57:24'),
(24, 1, 4, '2024-05-12', 'Problema de transporte', '2024-05-02 21:57:24'),
(25, 1, 4, '2024-05-15', 'Doença', '2024-05-02 21:57:24'),
(26, 1, 4, '2024-05-19', 'Família', '2024-05-02 21:57:24'),
(27, 1, 4, '2024-05-22', 'Problema de transporte', '2024-05-02 21:57:24'),
(28, 1, 4, '2024-05-26', 'Outro motivo', '2024-05-02 21:57:24'),
(29, 1, 5, '2024-05-06', 'Doença', '2024-05-02 21:57:24'),
(31, 1, 5, '2024-05-13', 'Problema de transporte', '2024-05-02 21:57:24'),
(32, 1, 5, '2024-05-16', 'Doença', '2024-05-02 21:57:24'),
(33, 1, 5, '2024-05-20', 'Família', '2024-05-02 21:57:24'),
(34, 1, 5, '2024-05-23', 'Problema de transporte', '2024-05-02 21:57:24'),
(35, 1, 5, '2024-05-27', 'Outro motivo', '2024-05-02 21:57:24'),
(41, 1, 6, '2024-05-24', 'Problema de transporte', '2024-05-02 21:57:24'),
(42, 1, 6, '2024-05-28', 'Outro motivo', '2024-05-02 21:57:24'),
(43, 1, 7, '2024-05-08', 'Doença', '2024-05-02 21:57:24'),
(44, 1, 7, '2024-05-11', 'Família', '2024-05-02 21:57:24'),
(45, 1, 7, '2024-05-15', 'Problema de transporte', '2024-05-02 21:57:24'),
(50, 1, 8, '2024-05-09', 'Doença', '2024-05-02 21:57:24'),
(51, 1, 8, '2024-05-12', 'Família', '2024-05-02 21:57:24'),
(52, 1, 8, '2024-05-16', 'Problema de transporte', '2024-05-02 21:57:24'),
(53, 1, 8, '2024-05-19', 'Doença', '2024-05-02 21:57:24'),
(54, 1, 8, '2024-05-23', 'Família', '2024-05-02 21:57:24'),
(55, 1, 8, '2024-05-26', 'Problema de transporte', '2024-05-02 21:57:24'),
(56, 1, 8, '2024-05-30', 'Outro motivo', '2024-05-02 21:57:24');

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
(1, 'Língua Portuguesa', 30, '5'),
(2, 'Matemática', 30, '5'),
(3, 'Ciências Naturais', 30, '5'),
(4, 'Geografia', 30, '5'),
(5, 'História', 30, '5'),
(6, 'Educação Artística', 30, '5'),
(7, 'Educação Física', 30, '5'),
(8, 'Inglês', 30, '5');

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
(1, 1, 1, 'Prova 1', '2024-05-01', 8.00, 'Boa participação', '2024-05-02 21:56:17'),
(3, 1, 1, 'Trabalho em Grupo', '2024-05-29', 9.00, 'Excelente trabalho em equipe', '2024-05-02 21:56:17'),
(5, 1, 1, 'Atividade Extra', '2024-06-26', 7.00, 'Esforço reconhecido', '2024-05-02 21:56:17'),
(6, 1, 1, 'Prova 4', '2024-07-10', 9.00, 'Demonstrou melhora significativa', '2024-05-02 21:56:17'),
(7, 1, 1, 'Apresentação Oral', '2024-07-24', 8.00, 'Boa expressão oral', '2024-05-02 21:56:17'),
(8, 1, 2, 'Prova 1', '2024-05-02', 9.00, 'Excelente desempenho', '2024-05-02 21:56:17'),
(9, 1, 2, 'Prova 2', '2024-05-16', 8.00, 'Bom trabalho', '2024-05-02 21:56:17'),
(13, 1, 2, 'Atividade em Grupo', '2024-07-11', 9.00, 'Participação ativa e colaborativa', '2024-05-02 21:56:17'),
(14, 1, 2, 'Prova 5', '2024-07-25', 8.00, 'Demonstrou domínio dos conceitos', '2024-05-02 21:56:17'),
(15, 1, 3, 'Prova 1', '2024-05-03', 8.00, 'Demonstra bom entendimento dos conceitos', '2024-05-02 21:56:17'),
(18, 1, 3, 'Prova 3', '2024-06-14', 7.00, 'Desempenho dentro da média', '2024-05-02 21:56:17'),
(19, 1, 3, 'Prova 4', '2024-06-28', 8.00, 'Bom entendimento dos conteúdos', '2024-05-02 21:56:17'),
(21, 1, 3, 'Trabalho Escrito', '2024-07-26', 9.00, 'Apresentou informações relevantes', '2024-05-02 21:56:17'),
(24, 1, 4, 'Apresentação Oral', '2024-06-01', 9.00, 'Excelente oratória', '2024-05-02 21:56:17'),
(25, 1, 4, 'Prova 2', '2024-06-15', 7.00, 'Desempenho satisfatório', '2024-05-02 21:56:17'),
(26, 1, 4, 'Trabalho Individual', '2024-06-29', 8.00, 'Demonstrou esforço', '2024-05-02 21:56:17'),
(27, 1, 4, 'Debate em Grupo', '2024-07-13', 8.00, 'Participação ativa', '2024-05-02 21:56:17'),
(28, 1, 4, 'Trabalho de Campo', '2024-07-27', 9.00, 'Apresentou resultados interessantes', '2024-05-02 21:56:17'),
(29, 1, 5, 'Prova 1', '2024-05-05', 9.00, 'Bom conhecimento dos fatos históricos', '2024-05-02 21:56:17'),
(32, 1, 5, 'Prova 3', '2024-06-16', 8.00, 'Bom desempenho', '2024-05-02 21:56:17'),
(33, 1, 5, 'Projeto de História', '2024-06-30', 7.00, 'Ideias interessantes, mas precisa desenvolver mais', '2024-05-02 21:56:17'),
(34, 1, 5, 'Apresentação Oral', '2024-07-14', 9.00, 'Excelente apresentação', '2024-05-02 21:56:17'),
(38, 1, 6, 'Apresentação de Música', '2024-06-03', 9.00, 'Talentoso musicalmente', '2024-05-02 21:56:17'),
(40, 1, 6, 'Trabalho em Grupo', '2024-07-01', 8.00, 'Colaboração eficaz', '2024-05-02 21:56:17'),
(41, 1, 6, 'Exibição de Arte', '2024-07-15', 8.00, 'Boa apresentação', '2024-05-02 21:56:17'),
(42, 1, 6, 'Apresentação de Dança', '2024-07-29', 9.00, 'Excelente desempenho', '2024-05-02 21:56:17'),
(43, 1, 7, 'Teste de Corrida', '2024-05-07', 8.00, 'Bom condicionamento físico', '2024-05-02 21:56:17'),
(44, 1, 7, 'Avaliação de Flexibilidade', '2024-05-21', 7.00, 'Pode melhorar na flexibilidade', '2024-05-02 21:56:17'),
(45, 1, 7, 'Jogos em Equipe', '2024-06-04', 9.00, 'Liderança eficaz', '2024-05-02 21:56:17'),
(47, 1, 7, 'Participação em Torneio', '2024-07-02', 8.00, 'Boa participação', '2024-05-02 21:56:17'),
(48, 1, 7, 'Avaliação de Habilidades', '2024-07-16', 8.00, 'Demonstrou habilidades variadas', '2024-05-02 21:56:17'),
(49, 1, 7, 'Competição de Atletismo', '2024-07-30', 9.00, 'Destaque em várias modalidades', '2024-05-02 21:56:17'),
(50, 1, 8, 'Teste de Vocabulário', '2024-05-08', 8.00, 'Bom domínio do vocabulário', '2024-05-02 21:56:17'),
(52, 1, 8, 'Apresentação em Inglês', '2024-06-05', 9.00, 'Boa pronúncia', '2024-05-02 21:56:17'),
(53, 1, 8, 'Prova de Gramática', '2024-06-19', 7.00, 'Conhecimento gramatical satisfatório', '2024-05-02 21:56:17'),
(54, 1, 8, 'Leitura em Grupo', '2024-07-03', 8.00, 'Boa compreensão de texto', '2024-05-02 21:56:17'),
(57, 1, 1, 'Teste português', '2024-04-02', 0.00, 'Nota 0', '2024-05-03 02:59:20');

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
(1, 26, '123.456.789-10'),
(2, 27, '34945058024');

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
(1, 2, 'Recurso', 'b', 'c', 1, 'pdf', '2024-04-27 16:01:05'),
(2, 2, 'v', 'w', 'x', 2, 'site', '2024-04-27 16:04:57'),
(3, 2, 'g', 'h', 'i', 2, 'site', '2024-04-27 16:06:19'),
(4, 2, 'h', 'i', 'k', 3, 'site', '2024-04-27 16:06:42'),
(5, 2, 'a', 'a', 'a', 1, 'pdf', '2024-04-27 16:20:41'),
(6, 2, 'Números Inteiros', 'Os números inteiros blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá blá.', 'https://numerosinteiros.com.br', 3, 'site', '2024-04-27 16:21:51'),
(7, 2, 'a', 'b', 'c', 1, 'pdf', '2024-04-29 21:56:19'),
(8, 2, 'Introdução à Programação em Python', 'Este recurso oferece uma introdução abrangente à linguagem de programação Python, abordando desde os conceitos básicos até tópicos mais avançados, como estruturas de dados e funções.', 'https://www.example.com/introducao-python', 4, 'pdf', '2024-04-29 21:58:24'),
(9, 2, 'teste', 'teste', 'https://www.example.com/introducao-python', 3, 'pdf', '2024-04-29 22:08:13'),
(12, 2, 'Números Naturais', 'Os Números Naturais N = {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12...} são números inteiros positivos (não-negativos) que se agrupam num conjunto chamado de N, composto de um número ilimitado de elementos. Se um número é inteiro e positivo, podemos dizer que é um número natural.', 'https://www.todamateria.com.br/numeros-naturais/', 5, 'site', '2024-05-02 21:45:08'),
(13, 2, 'Programação de computadores', 'Programação é o processo de escrita, teste e manutenção de um programa de computador. O programa é escrito em uma linguagem de programação, embora seja possível, com alguma dificuldade, o escrever diretamente em linguagem de máquina. Diferentes partes de um programa podem ser escritas em diferentes linguagens.', 'https://pt.wikipedia.org/wiki/Programa%C3%A7%C3%A3o_de_computadores', 5, 'site', '2024-05-02 21:45:43'),
(14, 2, 'Aprendendo python', 'Material para aprendizado de python', 'https://www.facom.ufu.br/~william/Disciplinas%202019-1/BIOTCH-GBT017-IntoducaoInformatica/285173966-aprendendo-python-pdf.pdf', 5, 'pdf', '2024-05-02 21:46:25');

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
(2, 'Maria eduarda', 'duda@gmail.com', '123456789', 'Aluno', NULL, '2024-04-30 16:38:21'),
(26, 'lucass d', 'lucas@d.com', '123456789', 'Professor', NULL, '2024-04-25 08:47:08'),
(27, 'Vitor Santos', 'vitor@gmail.com.br', '12345678', 'Professor', NULL, '2024-04-25 08:49:56'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `classe_materia`
--
ALTER TABLE `classe_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `conquista`
--
ALTER TABLE `conquista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `falta`
--
ALTER TABLE `falta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recurso_educacional`
--
ALTER TABLE `recurso_educacional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
