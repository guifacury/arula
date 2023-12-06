-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/11/2023 às 10:46
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cicero`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `type` tinyint(1) NOT NULL,
  `difficulty` tinyint(1) NOT NULL,
  `videos` text NOT NULL,
  `duracao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `descricao`, `type`, `difficulty`, `videos`, `duracao`) VALUES
(2, 'Python: Entendendo a Orientação a Objetos', 'Na Formação Python e orientação a objetos, você vai aprender a versão 3 dessa linguagem na prática, aplicando orientação a objetos em seu código e boas práticas de programação. Você também vai entender como tratamos erros e conhecer diversas funcionalidades para tratar os diferentes tipos de coleções. Veremos também como ler e escrever diferentes formatos de arquivos usando Python.', 1, 1, '', '1:30 h'),
(3, 'PHP: Crie aplicações web em PHP', 'PHP é uma linguagem de script popular especialmente adequada para desenvolvimento web, que também pode ser utilizada para programar de forma geral.  Rápida, flexível e pragmática, a linguagem PHP pode ser usada em tudo na Web, desde blogs até os sites mais populares do mundo.  Aumente seu repertório de dev e aprenda, nesta formação, como criar uma aplicação Web com PHP. Bora começar?', 2, 2, '', '2 h'),
(4, ' JavaScript: Foco no back-end', 'Esta formação é indicada para quem está começando agora em programação e escolheu o JavaScript como primeira linguagem para se aprofundar e o back-end como ramo do desenvolvimento web para trabalhar. Vamos começar abordando as partes fundamentais de qualquer linguagem de programação (tipos de dados, funções, arrays e objetos) e como trabalhá-las com JavaScript.', 3, 2, '', '1 h'),
(5, 'React Native: Desenvolva seu primeiro app', 'O React Native, é um framework JavaScript que combina as melhores partes do desenvolvimento com React, trazendo a possibilidade de criar aplicações mobile híbridas, isto é, aplicações mobile tanto para Android quanto para iOS.\r\n\r\nEntre as grandes vantagens de se utilizar o React Native para desenvolver seus apps, é que com uma única tecnologia você poderá desenvolver aplicativos multiplataforma, otimizando o processo de desenvolvimento.', 4, 3, '', '4 h'),
(6, 'Full Stack: Formação Performe sua aplicação React com Next.js ', 'Caso tenha experiência prática em projetos com os temas acima, aproveite a nova formação Next Full Stack para criar aplicações web de alta performance e escaláveis, com menos tempo de desenvolvimento e melhor experiência de usuário.', 5, 2, '', '12 h'),
(7, 'Lógica de Programação: Desenvolva um jogo e pratique.', '- Dê seus primeiros passos de maneira prática!\n- Inicie na programação com JavaScript no seu Navegador\n- Entenda variáveis e seu uso\n- Repita tarefas com laços, loops, fors e whiles', 6, 1, '', '3 h');

-- --------------------------------------------------------

--
-- Estrutura para tabela `history`
--

CREATE TABLE `history` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `c_id` int(10) NOT NULL,
  `video_id` int(10) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `history`
--

INSERT INTO `history` (`id`, `username`, `c_id`, `video_id`, `created`) VALUES
(9, 'guilhermefacury', 2, 1, '2023-11-18 15:35:06'),
(10, 'guilhermefacury', 6, 24, '2023-11-18 15:37:54'),
(11, 'guilhermefacury', 6, 25, '2023-11-18 15:37:58'),
(12, 'guilhermefacury', 4, 12, '2023-11-18 15:38:10'),
(13, 'guilhermefacury', 4, 13, '2023-11-18 15:38:13'),
(14, 'guilhermefacury', 4, 14, '2023-11-18 15:38:16'),
(15, 'guilhermefacury', 4, 15, '2023-11-18 15:38:22'),
(16, 'guilhermefacury', 6, 26, '2023-11-18 15:43:36'),
(17, 'guilhermefacury', 5, 16, '2023-11-18 16:11:52'),
(18, 'cicero', 6, 24, '2023-11-18 19:38:24'),
(19, 'cicero', 6, 31, '2023-11-18 19:39:03'),
(20, 'cassia', 2, 1, '2023-11-18 23:10:22'),
(21, 'cassia', 2, 2, '2023-11-18 23:12:53'),
(22, 'cassia', 2, 3, '2023-11-18 23:26:16'),
(23, 'cassia', 2, 4, '2023-11-18 23:26:23'),
(24, 'cassia', 2, 5, '2023-11-18 23:26:40'),
(25, 'cassia', 3, 6, '2023-11-18 23:39:59'),
(26, 'cassia', 3, 7, '2023-11-18 23:40:02'),
(27, 'cassia', 3, 8, '2023-11-18 23:40:04'),
(28, 'cassia', 3, 9, '2023-11-18 23:40:05'),
(29, 'cassia', 3, 10, '2023-11-18 23:40:06'),
(30, 'cassia', 3, 11, '2023-11-18 23:40:08'),
(31, 'cicero', 7, 27, '2023-11-18 23:52:26'),
(32, 'cicero', 7, 28, '2023-11-18 23:52:27'),
(33, 'guilhermefacury', 7, 27, '2023-11-18 23:54:56'),
(34, 'guilhermefacury', 7, 29, '2023-11-18 23:54:57'),
(35, 'guilhermefacury', 7, 30, '2023-11-18 23:54:58'),
(36, 'guilhermefacury', 7, 28, '2023-11-18 23:55:07'),
(37, 'guilhermef', 5, 16, '2023-11-19 00:14:30'),
(38, 'givaldo', 3, 6, '2023-11-19 00:29:16'),
(39, 'givaldo', 3, 7, '2023-11-19 08:51:50');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) NOT NULL,
  `video_id` int(10) NOT NULL,
  `user` varchar(100) NOT NULL,
  `rate` tinyint(1) NOT NULL,
  `obs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ratings`
--

INSERT INTO `ratings` (`id`, `video_id`, `user`, `rate`, `obs`) VALUES
(1, 2, 'gfacury', 4, 'Professor muito bacana!'),
(4, 5, 'gfacury', 5, 'Muito thopi, quero aprender mais!');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT 1,
  `plano` tinyint(1) NOT NULL DEFAULT 1,
  `access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `plano`, `access`) VALUES
(2, 'futvidal2', '$2y$10$8zDlxe.moV77kUlqKDG6WOKVwvSsds9P1jnw4EVjxs0zJElWg.eFO', 1, 1, ''),
(3, 'gfacury', '$2y$10$DSfWwApLx27VtM/1qpGB0.2j2j1wtMG4PPhBE83Gaq59t7vAVhbXC', 1, 1, ''),
(4, 'futvidal69', '$2y$10$NdjjVQrxJwAZhWGFZHKiGOhVL8BrwuPzNUgQpSiWl0gW4/308M0im', 1, 1, ''),
(5, 'giovannalara', '$2y$10$naeRglaNNG6qkDkaafGXhu6Kjo/BT1XaEg3.gKbL2L9e0f8J2m/J.', 1, 1, ''),
(6, 'cicero', '$2y$10$/0I/.SYHEwIn7KImaJ1PLO8doCXHHTwiPsz18OkdTSs/pD717S/fm', 2, 1, ''),
(7, 'guilhermefacury', '$2y$10$bkQqJnSEvvVXg/zyhQnfrOGizU7Xqw5I6E9Yl4dBr7EO7KOQuXvVO', 1, 3, ''),
(8, 'fabinho', '$2y$10$DbHug.Jy87mEtXAFha8VY.R3nXJ.PvBB71XUt1x3wIe5UxmTEhXoq', 1, 2, '[3,2]'),
(9, 'convidado', '$2y$10$zbUxUpAORgjpuOds92q/keaxbMNHOt8lA6btKUnc84/e99NI5Yivu', 1, 1, ''),
(10, 'testando', '$2y$10$W3NTt6Mp9mOgiIbsmW6I3OcMtQC.R5gLKFjkoR7.3D33ZdPdkw43S', 1, 2, '[2]'),
(11, 'juliano', '$2y$10$ZLvm8siG4c1vE//xs0S3CO1s4If9XX74iWiJ4TGwk/b1HFinTKkBi', 1, 3, ''),
(12, 'cassia', '$2y$10$KpTXQ0odJfECjMHdkJVXn.S7QwNn12Zo1IFXxVkqOkwiTTkr2L8J6', 1, 2, '[2,3]'),
(13, 'givaldo', '$2y$10$1lkapwcLVz6SZklM/bGWu.wJA6.pMfnaZZ9WXNaBxCR4d/0rGJZ0S', 1, 2, '[3]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `videos`
--

CREATE TABLE `videos` (
  `id` int(10) NOT NULL,
  `yt_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `curso_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `videos`
--

INSERT INTO `videos` (`id`, `yt_id`, `title`, `thumb`, `curso_id`) VALUES
(1, 'WP5p4QEqLLQ', 'Introdução a Python', 'aaa_1.jpg', '2'),
(2, 'CtSX3dWqWBQ', 'Classes e elementos', 'aaa_2.jpg', '2'),
(3, 'RJWucpLGBng', 'Encapsulamento', 'aaa_3.jpg', '2'),
(4, 'rHSQ8oam8bQ', 'Getters e Estados', 'aaa_4.jpg', '2'),
(5, 'CM-JPix8hcI', 'SOLID (S)', 'aaa_5.jpg', '2'),
(6, 'TfsO0BGvGn0', 'Começa aqui seu curso de PHP Moderno ', 'bbb_1.jpg', '3'),
(7, 'dLHlHTsFqvk', 'Esse curso de PHP serve pra mim?', 'bbb_2.jpg', '3'),
(8, 'fvbOFIduMoI', 'Lista TOP 6 livros de PHP', 'bbb_3.jpg', '3'),
(9, 'TwNmvk-F7E8', 'A evolução do PHP', 'bbb_4.jpg', '3'),
(10, '4kSJOJEi0aQ', 'Por que um elefante é o mascote do PHP?', 'bbb_5.jpg', '3'),
(11, 'cGiB7D9mCAM', 'As versões do PHP e seus recursos', 'bbb_6.jpg', '3'),
(12, 'LLqq6FemMNQ', 'Curso de Node.JS - O que é Node.JS ', 'ccc_1.jpg', '4'),
(13, '522HiDiAf0w', 'Curso de Node.js - Como Instalar o Node.js', 'ccc_2.jpg', '4'),
(14, '5fuoA7pGH_Y', 'Curso de Node.JS - Node na prática', 'ccc_3.jpg', '4'),
(15, 'bWSkUscBeZc', 'Curso de Node.js - Módulos ', 'ccc_4.jpg', '4'),
(16, 'Y8tP1jbRYHY', 'Primeiros passos no React Native', 'ddd_1.jpg', '5'),
(17, '_N6-kScr-Ig', 'Principais Components do React Native - P1', 'ddd_2.jpg', '5'),
(18, 'u_qccnftxXQ', 'Principais Components do React Native - P2', 'ddd_3.jpg', '5'),
(19, '8X63GfvxbE8', 'Principais Components do React Native - P3', 'ddd_4.jpg', '5'),
(20, 'JusFvRHWDyU', 'Design do App OneBitHealth - P1', 'ddd_5.jpg', '5'),
(21, 'BCulqg8qUdU', 'Design do App OneBitHealth - P2', 'ddd_6.jpg', '5'),
(22, 'uLoMoPC6Ics', 'Design do App OneBitHealth - P3', 'ddd_7.jpg', '5'),
(23, 'wl0h3fMaIWc', 'Conhecendo sobre APIs React Native', 'ddd_8.jpg', '5'),
(24, 'FcxjCPeicvU', 'Complete MERN Beginner Course ', 'eee_1.jpg', '6'),
(25, 'fqfer6xMp2A', 'The Most Efficient Next.JS 14 Beginner Tutorial', 'eee_2.jpg', '6'),
(26, 'ffdtaIMCuE0', 'Get My Full-Stack NextJS ', 'eee_3.jpg', '6'),
(27, '8mei6uVttho', 'Introdução a Algoritmos', 'fff_1.jpg', '7'),
(28, 'M2Af7gkbbro', 'Primeiro Algoritmo', 'fff_2.jpg', '7'),
(29, 'RDrfZ-7WE8c', 'Comando de Entrada e Operadores', 'fff_3.jpg', '7'),
(30, 'U_A2kwUfmlw', 'Seja APOIADOR e receba RECOMPENSAS', 'fff_4.jpg', '7');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
