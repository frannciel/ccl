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

-- Copiando estrutura do banco de dados para ccl
CREATE DATABASE IF NOT EXISTS `ccl` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ccl`;

-- Copiando dados para a tabela ccl.informacoes: ~64 rows (aproximadamente)
/*!40000 ALTER TABLE `informacoes` DISABLE KEYS */;
INSERT INTO `informacoes` (`id`, `dado`, `valor`, `tipo`) VALUES
	(1, 'Concorrência', '0', 'modalidade'),
	(2, 'Tomada de Preço', '1', 'modalidade'),
	(3, 'Convite', '2', 'modalidade'),
	(4, 'Concurso', '3', 'modalidade'),
	(5, 'Leilão', '4', 'modalidade'),
	(6, 'Dispensa', '5', 'modalidade'),
	(7, 'Inexigibilidade', '6', 'modalidade'),
	(8, 'Obra ou Serviço de Engenharia', '0', 'classificacao'),
	(9, 'Serviço', '1', 'classificacao'),
	(10, 'Compra', '2', 'classificacao'),
	(11, 'Alienação', '3', 'classificacao'),
	(12, 'Obras, serviços e compras de grande vulto', '4', 'classificacao'),
	(13, 'Concessão de Uso', '5', 'classificacao'),
	(14, 'Serviço com fornecimento de materiais', '6', 'classificacao'),
	(15, 'Lei 8666/93 - Licitações', '0', 'normativa'),
	(16, 'Lei 11.947/09 - Alimentação Escolar', '1', 'normativa'),
	(17, 'Lei 10.520/02 - Pregão', '2', 'normativa'),
	(21, 'I', '0', '866624'),
	(22, 'II', '1', '866624'),
	(23, 'III', '2', '866624'),
	(24, 'IV', '3', '866624'),
	(25, 'V', '4', '866624'),
	(26, 'VI', '5', '866624'),
	(27, 'VII', '6', '866624'),
	(28, 'VIII', '7', '866624'),
	(29, 'IX', '8', '866624'),
	(30, 'X', '9', '866624'),
	(31, 'XI', '10', '866624'),
	(32, 'XII', '11', '866624'),
	(33, 'XIII', '12', '866624'),
	(34, 'XIV', '13', '866624'),
	(35, 'XV', '14', '866624'),
	(36, 'XVI', '15', '866624'),
	(37, 'XVII', '16', '866624'),
	(38, 'XVIII', '17', '866624'),
	(39, 'XIX', '18', '866624'),
	(40, 'XX', '19', '866624'),
	(41, 'XXI', '20', '866624'),
	(42, 'XXII', '21', '866624'),
	(43, 'XXIII', '22', '866624'),
	(44, 'XXIV', '23', '866624'),
	(45, 'XXV', '24', '866624'),
	(46, 'XXVI', '25', '866624'),
	(47, 'XXVII', '26', '866624'),
	(48, 'XXVIII', '27', '866624'),
	(49, 'XXIX', '28', '866624'),
	(50, 'XXX', '29', '866624'),
	(51, 'XXXI', '30', '866624'),
	(52, 'XXXII', '31', '866624'),
	(53, 'XXXIII', '32', '866624'),
	(54, 'XXXIV', '33', '866624'),
	(55, 'XXXV', '34', '866624'),
	(56, 'Caput', '0', '866625'),
	(57, 'I', '1', '866625'),
	(58, 'II', '2', '866625'),
	(59, 'III', '3', '866625'),
	(60, 'Presencial', '0', 'forma'),
	(61, 'Eletrônico', '1', 'forma'),
	(62, 'Eletrônico - Registro de Preços', '2', 'forma'),
	(63, 'Presencial  - Registro de Preços', '3', 'forma'),
	(64, 'Menor Preço', '0', 'tipo'),
	(65, 'Melhor Técnica', '1', 'tipo'),
	(66, 'Técnica e Preço', '2', 'tipo'),
	(67, 'Maior Lance ou Oferta', '3', 'tipo');
/*!40000 ALTER TABLE `informacoes` ENABLE KEYS */;

-- Copiando dados para a tabela ccl.requisitantes: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `requisitantes` DISABLE KEYS */;
INSERT INTO `requisitantes` (`id`, `nome`, `sigla`, `ramal`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'Direção Geral', 'DG', NULL, NULL, NULL, NULL),
	(2, 'Coordenação de Segurança do Trabalho', 'SEGTRAB', NULL, NULL, NULL, NULL),
	(3, 'Diretoria de Administração e Planejamento', 'DAP', NULL, NULL, NULL, NULL),
	(4, 'Diretoria Acadêmica', 'DA', NULL, NULL, NULL, NULL),
	(5, 'Departamento de Administração e Patrimônio', 'DEPAD', NULL, NULL, NULL, NULL),
	(6, 'Coordenação do Curso de Matemática', 'COMAT', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `requisitantes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
