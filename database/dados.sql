-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.21-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para novo
CREATE DATABASE IF NOT EXISTS `novo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `novo`;


-- Copiando estrutura para tabela novo.cidades
CREATE TABLE IF NOT EXISTS `cidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cidades_estado_id_foreign` (`estado_id`),
  CONSTRAINT `cidades_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.cidades: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cidades` DISABLE KEYS */;
INSERT INTO `cidades` (`id`, `uuid`, `nome`, `estado_id`, `created_at`, `updated_at`) VALUES
	(1, '', 'Eunápolis', 1, '2019-09-25 00:18:28', '2019-09-25 00:18:27'),
	(3, '', 'Porto Seguro', 1, '2019-09-25 00:18:25', '2019-09-25 00:18:26'),
	(4, '', 'Itabela', 2, '2019-09-25 00:18:46', '2019-09-25 00:18:47');
/*!40000 ALTER TABLE `cidades` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.cidade_uasg
CREATE TABLE IF NOT EXISTS `cidade_uasg` (
  `quantidade` int(11) NOT NULL,
  `cidade_id` int(10) unsigned NOT NULL,
  `uasg_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  KEY `cidade_uasg_cidade_id_foreign` (`cidade_id`),
  KEY `cidade_uasg_item_id_foreign` (`item_id`),
  KEY `cidade_uasg_uasg_id_foreign` (`uasg_id`),
  CONSTRAINT `cidade_uasg_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`),
  CONSTRAINT `cidade_uasg_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`),
  CONSTRAINT `cidade_uasg_uasg_id_foreign` FOREIGN KEY (`uasg_id`) REFERENCES `uasgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.cidade_uasg: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cidade_uasg` DISABLE KEYS */;
INSERT INTO `cidade_uasg` (`quantidade`, `cidade_id`, `uasg_id`, `item_id`) VALUES
	(10, 1, 1, 1),
	(10, 3, 1, 1),
	(10, 1, 1, 2),
	(10, 3, 1, 2),
	(20, 1, 2, 1),
	(20, 4, 2, 1),
	(30, 3, 3, 3);
/*!40000 ALTER TABLE `cidade_uasg` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_ibge` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.estados: ~27 rows (aproximadamente)
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id`, `uuid`, `codigo_ibge`, `nome`, `sigla`, `created_at`, `updated_at`) VALUES
	(1, '', 12, 'Acre', 'AC', '2019-03-18 02:00:18', '0000-00-00 00:00:00'),
	(2, '', 27, 'Alagoas', 'AL', '2019-03-18 02:00:41', '0000-00-00 00:00:00'),
	(3, '', 13, 'Amazonas', 'AM', '2019-03-18 02:00:42', '0000-00-00 00:00:00'),
	(4, '', 16, 'Amapá', 'AP', '2019-03-18 02:00:33', '0000-00-00 00:00:00'),
	(5, '', 29, 'Bahia', 'BA', '2019-03-18 02:02:13', '0000-00-00 00:00:00'),
	(6, '', 23, 'Ceará', 'CE', '2019-03-18 02:00:54', '0000-00-00 00:00:00'),
	(7, '', 53, 'Distrito Federal', 'DF', '2019-03-18 02:00:56', '0000-00-00 00:00:00'),
	(8, '', 32, 'Espírito Santo', 'ES', '2019-03-18 02:00:55', '0000-00-00 00:00:00'),
	(9, '', 52, 'Goiás', 'GO', '2019-03-18 02:00:59', '0000-00-00 00:00:00'),
	(10, '', 21, 'Maranhão', 'MA', '2019-03-18 02:00:58', '0000-00-00 00:00:00'),
	(11, '', 31, 'Minas Gerais', 'MG', '2019-03-18 02:00:40', '0000-00-00 00:00:00'),
	(12, '', 50, 'Mato Grosso do Sul', 'MS', '2019-03-18 02:00:39', '0000-00-00 00:00:00'),
	(13, '', 51, 'Mato Grosso', 'MT', '2019-03-18 02:00:38', '0000-00-00 00:00:00'),
	(14, '', 15, 'Pará', 'PA', '2019-03-18 02:00:49', '0000-00-00 00:00:00'),
	(15, '', 25, 'Paraíba', 'PB', '2019-03-18 02:00:49', '0000-00-00 00:00:00'),
	(16, '', 26, 'Pernambuco', 'PE', '2019-03-18 02:00:15', '0000-00-00 00:00:00'),
	(17, '', 22, 'Piauí', 'PI', '2019-03-18 02:00:20', '0000-00-00 00:00:00'),
	(18, '', 41, 'Paraná', 'PR', '2019-03-18 02:00:19', '0000-00-00 00:00:00'),
	(19, '', 33, 'Rio de Janeiro', 'RJ', '2019-03-18 02:02:15', '0000-00-00 00:00:00'),
	(20, '', 24, 'Rio Grande do Norte', 'RN', '2019-03-18 02:00:48', '0000-00-00 00:00:00'),
	(21, '', 11, 'Rondônia', 'RO', '2019-03-18 02:00:46', '0000-00-00 00:00:00'),
	(22, '', 14, 'Roraima', 'RR', '2019-03-18 02:00:52', '0000-00-00 00:00:00'),
	(23, '', 43, 'Rio Grande do Sul', 'RS', '2019-03-18 02:00:45', '0000-00-00 00:00:00'),
	(24, '', 42, 'Santa Catarina', 'SC', '2019-03-18 02:00:44', '0000-00-00 00:00:00'),
	(25, '', 28, 'Sergipe', 'SE', '2019-03-18 02:00:44', '0000-00-00 00:00:00'),
	(26, '', 35, 'São Paulo', 'SP', '2019-03-18 02:00:37', '0000-00-00 00:00:00'),
	(27, '', 17, 'Tocantins', 'TO', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.itens
CREATE TABLE IF NOT EXISTS `itens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` smallint(6) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `codigo` int(11) DEFAULT NULL,
  `objeto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requisicao_id` int(10) unsigned DEFAULT NULL,
  `unidade_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itens_unidade_id_foreign` (`unidade_id`),
  KEY `itens_requisicao_id_foreign` (`requisicao_id`),
  CONSTRAINT `itens_requisicao_id_foreign` FOREIGN KEY (`requisicao_id`) REFERENCES `requisicoes` (`id`),
  CONSTRAINT `itens_unidade_id_foreign` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.itens: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `itens` DISABLE KEYS */;
INSERT INTO `itens` (`id`, `uuid`, `numero`, `quantidade`, `codigo`, `objeto`, `descricao`, `requisicao_id`, `unidade_id`, `created_at`, `updated_at`) VALUES
	(1, '73110309-f443-4d77-8c37-ec9cfd7f53c7', 1, 10, 1215, 'Agua', 'Agua mineral', 7, 47, '2019-09-19 02:22:05', '2019-09-19 02:22:05'),
	(2, '9578f453-8f89-44e5-b796-432eef4993fd', 2, 10, 1216, 'Café', 'Café torrado e muído', 7, 18, '2019-09-19 02:22:39', '2019-09-19 02:22:39'),
	(3, 'b3fcbc6c-deb5-485d-9171-a4b54dbeda93', 1, 10, 1213, 'Alvejante', 'Alvejante a base de cloro', 13, 24, '2019-09-19 02:23:25', '2019-09-19 02:23:25'),
	(4, '70c62e80-b329-4cf5-aec3-5174f2fcb741', 2, 10, 1211, 'Sabão', 'Sabão em barra', 13, 20, '2019-09-19 02:23:47', '2019-09-19 02:23:47'),
	(5, '3061a8fd-1641-4697-8762-876b6edfcae8', 1, 10, 1214, 'Carro', 'Carro popular', 14, 2, '2019-09-19 02:24:29', '2019-09-19 02:24:29'),
	(6, 'db6ed62a-417e-4985-84b7-aa0150651f22', 2, 10, 1218, 'Caminhão Caminhão Caminhão Caminhão Caminhão Caminhão Caminhão Caminhão Caminhão', 'Caminhão báu de duas compartimentos', 14, 2, '2019-09-21 23:28:41', '2019-09-21 23:28:41'),
	(7, '857f9036-00fd-44aa-a551-4d756965181d', 3, 10, 1219, 'Caminhonete', 'Caminhonete cabine dupla', 14, 2, '2019-09-21 23:29:22', '2019-09-21 23:29:22'),
	(8, 'edaab594-0428-4779-9667-340435f07d55', 4, 10, 1220, 'Vazilhames de Agua', 'Vazilhames de Agua 20 litros', 14, 2, '2019-09-22 17:58:17', '2019-09-22 17:58:17'),
	(28, 'c38a6c02-87b9-462c-b643-807054c254da', 10000, 20, 1215, 'Agua', 'Agua mineral', NULL, 47, '2019-09-22 23:42:17', '2019-09-22 23:42:17'),
	(29, '568010ae-6a7a-4efc-85c8-9309f6f525c4', 10000, 20, 1216, 'Café', 'Café torrado e muído', NULL, 18, '2019-09-22 23:45:59', '2019-09-22 23:45:59');
/*!40000 ALTER TABLE `itens` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.licitacoes
CREATE TABLE IF NOT EXISTS `licitacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` smallint(6) NOT NULL,
  `ano` smallint(6) NOT NULL,
  `objeto` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `licitacaoable_id` int(10) unsigned NOT NULL,
  `licitacaoable_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.licitacoes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `licitacoes` DISABLE KEYS */;
INSERT INTO `licitacoes` (`id`, `uuid`, `numero`, `ano`, `objeto`, `processo`, `licitacaoable_id`, `licitacaoable_type`, `created_at`, `updated_at`) VALUES
	(1, '29e5d36c-b5f4-42a1-9adb-804d58e81b3c', 1, 2019, 'Primeira Licitação', '23291.000012/2018-49', 1, 'App\\Pregao', '2019-09-18 23:34:54', '2019-09-18 23:34:54');
/*!40000 ALTER TABLE `licitacoes` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.mesclados
CREATE TABLE IF NOT EXISTS `mesclados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mesclado_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `licitacao_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mesclados_item_id_foreign` (`item_id`),
  KEY `mesclados_licitacao_id_foreign` (`licitacao_id`),
  KEY `mesclados_mesclado_id_foreign` (`mesclado_id`),
  CONSTRAINT `mesclados_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`),
  CONSTRAINT `mesclados_licitacao_id_foreign` FOREIGN KEY (`licitacao_id`) REFERENCES `licitacoes` (`id`),
  CONSTRAINT `mesclados_mescaldo_id_foreign` FOREIGN KEY (`mesclado_id`) REFERENCES `itens` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.mesclados: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `mesclados` DISABLE KEYS */;
INSERT INTO `mesclados` (`id`, `mesclado_id`, `item_id`, `licitacao_id`, `created_at`, `updated_at`) VALUES
	(26, 28, 1, 1, '2019-09-22 23:42:17', '2019-09-22 23:42:17'),
	(27, 28, 3, 1, '2019-09-22 23:42:17', '2019-09-22 23:42:17'),
	(28, 29, 2, 1, '2019-09-22 23:46:00', '2019-09-22 23:46:00'),
	(29, 29, 4, 1, '2019-09-22 23:46:00', '2019-09-22 23:46:00');
/*!40000 ALTER TABLE `mesclados` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.requisicoes
CREATE TABLE IF NOT EXISTS `requisicoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` smallint(6) NOT NULL,
  `ano` smallint(6) NOT NULL,
  `descricao` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `justificativa` text COLLATE utf8mb4_unicode_ci,
  `requisitante_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `requisicoes_numero_ano_unique` (`numero`,`ano`),
  KEY `requisicoes_requisitante_id_foreign` (`requisitante_id`),
  CONSTRAINT `requisicoes_requisitante_id_foreign` FOREIGN KEY (`requisitante_id`) REFERENCES `requisitantes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.requisicoes: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `requisicoes` DISABLE KEYS */;
INSERT INTO `requisicoes` (`id`, `uuid`, `numero`, `ano`, `descricao`, `justificativa`, `requisitante_id`, `created_at`, `updated_at`) VALUES
	(7, '7c379f94-29bf-47e5-859c-c55d26dc0bee', 7, 2019, 'Novo teste de requisições', NULL, 1, '2019-09-19 00:24:27', '2019-09-19 00:24:27'),
	(13, '67fa0894-1000-4842-aa63-a7d68c5cfd2c', 13, 2019, 'Nova mais baestagem', NULL, 2, '2019-09-19 00:40:16', '2019-09-19 00:40:16'),
	(14, '34a16b5b-c268-4dec-9d1a-bb8985511419', 14, 2019, 'Solicitação de compra do diretor', NULL, 1, '2019-09-19 02:07:52', '2019-09-19 02:07:53');
/*!40000 ALTER TABLE `requisicoes` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.requisitantes
CREATE TABLE IF NOT EXISTS `requisitantes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ramal` int(11) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.requisitantes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `requisitantes` DISABLE KEYS */;
INSERT INTO `requisitantes` (`id`, `uuid`, `nome`, `sigla`, `ramal`, `email`, `created_at`, `updated_at`) VALUES
	(1, '', 'Diretoria Acadêmica', 'DA', 318, NULL, '2019-09-18 21:03:03', '2019-09-18 21:03:03'),
	(2, '', 'Diretoria Administrativa', 'DAP', 300, NULL, '2019-09-18 21:03:00', '2019-09-18 21:03:02');
/*!40000 ALTER TABLE `requisitantes` ENABLE KEYS */;


-- Copiando estrutura para tabela novo.uasgs
CREATE TABLE IF NOT EXISTS `uasgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela novo.uasgs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `uasgs` DISABLE KEYS */;
INSERT INTO `uasgs` (`id`, `uuid`, `nome`, `codigo`, `created_at`, `updated_at`) VALUES
	(1, '', 'IFBA', 121314, '2019-09-25 00:16:53', '2019-09-25 00:16:36'),
	(2, '', 'UFSB', 121516, '2019-09-25 00:16:50', '2019-09-25 00:16:51'),
	(3, '', 'UFBA', 121413, '2019-09-25 00:17:19', '2019-09-25 00:17:20');
/*!40000 ALTER TABLE `uasgs` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
