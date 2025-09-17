-- Este arquivo SQL cria o banco de dados e as tabelas necessárias
-- para o sistema de login e registro.

--
-- Desabilitar a verificação de chaves estrangeiras para evitar erros durante a criação das tabelas
--
SET foreign_key_checks = 0;

--
-- Estrutura da tabela `usuarios`
--
-- Esta tabela armazena as informações dos usuários que se registram no site.
--
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `data_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Ativar a verificação de chaves estrangeiras novamente
--
SET foreign_key_checks = 1;

--
-- Estrutura da tabela `sessoes`
-- (Opcional, dependendo da sua abordagem de autenticação)
--
-- Esta tabela pode ser usada para gerenciar sessões de login,
-- permitindo que os usuários permaneçam logados.
--
CREATE TABLE IF NOT EXISTS `sessoes` (
  `id` VARCHAR(255) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  `data_expiracao` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
