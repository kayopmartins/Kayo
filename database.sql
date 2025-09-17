-- Cria o banco de dados
CREATE DATABASE clinicas_db;

-- Seleciona o banco de dados para uso
USE clinicas_db;

-- Cria a tabela para armazenar os usuários
CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_completo` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `data_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
