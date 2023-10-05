-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour symfonysessions
CREATE DATABASE IF NOT EXISTS `symfonysessions` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `symfonysessions`;

-- Listage de la structure de la table symfonysessions. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.category : ~0 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name_category`) VALUES
	(1, 'Bureautique Microsoft'),
	(2, 'Commerce Vente'),
	(3, 'Tertiaire'),
	(4, 'Informatique Numérique');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name_course` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_169E6FB912469DE2` (`category_id`),
  CONSTRAINT `FK_169E6FB912469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.course : ~0 rows (environ)
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`id`, `category_id`, `name_course`) VALUES
	(1, 1, 'Word 1'),
	(2, 1, 'Word 2'),
	(3, 1, 'PowerPoint bases'),
	(4, 4, 'PHP 1'),
	(5, 4, 'PHP 2'),
	(6, 4, 'JavaScript');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table symfonysessions.doctrine_migration_versions : ~1 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231001212745', '2023-10-05 07:22:50', 696);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.messenger_messages : ~0 rows (environ)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. programm
CREATE TABLE IF NOT EXISTS `programm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `nb_day` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B465826591CC992` (`course_id`),
  KEY `IDX_B465826613FECDF` (`session_id`),
  CONSTRAINT `FK_B465826591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `FK_B465826613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.programm : ~0 rows (environ)
/*!40000 ALTER TABLE `programm` DISABLE KEYS */;
INSERT INTO `programm` (`id`, `course_id`, `session_id`, `nb_day`) VALUES
	(1, 1, 1, 3),
	(3, 2, 1, 5),
	(4, 3, 1, 5),
	(5, 5, 2, 30),
	(6, 6, 2, 30),
	(7, 2, 3, 25),
	(9, 3, 3, 30);
/*!40000 ALTER TABLE `programm` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `date_begin_session` date NOT NULL,
  `date_end_session` date NOT NULL,
  `nb_max_session` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4BEFD98D1` (`training_id`),
  KEY `IDX_D044D5D4FB08EDF6` (`trainer_id`),
  CONSTRAINT `FK_D044D5D4BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`),
  CONSTRAINT `FK_D044D5D4FB08EDF6` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.session : ~0 rows (environ)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `training_id`, `trainer_id`, `date_begin_session`, `date_end_session`, `nb_max_session`) VALUES
	(1, 1, NULL, '2023-10-09', '2024-06-05', 10),
	(2, 4, NULL, '2023-10-02', '2024-02-12', 6),
	(3, 2, NULL, '2023-10-23', '2023-11-20', 5);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. trainee
CREATE TABLE IF NOT EXISTS `trainee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name_trainee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name_trainee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_trainee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_trainee` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_trainee` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_trainee` int(11) DEFAULT NULL,
  `birth_date_trainee` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.trainee : ~0 rows (environ)
/*!40000 ALTER TABLE `trainee` DISABLE KEYS */;
INSERT INTO `trainee` (`id`, `first_name_trainee`, `last_name_trainee`, `email_trainee`, `gender_trainee`, `city_trainee`, `phone_trainee`, `birth_date_trainee`) VALUES
	(1, 'Dupont', 'Maurice', 'dupont.maurice@elan.fr', NULL, NULL, NULL, '1989-06-15'),
	(2, 'Kevin', 'Melville', 'Kevin395@boyland.com', 'viril', NULL, NULL, '2000-10-03'),
	(3, 'Durant', 'Sylvie', 'sylvie.rose@laposte.net', NULL, NULL, NULL, '2004-11-05'),
	(4, 'Esmeralda', 'Carmen', 'Carmen.diva@opera.fr', 'F', NULL, NULL, '1974-08-18');
/*!40000 ALTER TABLE `trainee` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. trainee_session
CREATE TABLE IF NOT EXISTS `trainee_session` (
  `trainee_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`trainee_id`,`session_id`),
  KEY `IDX_D4DAC3A336C682D0` (`trainee_id`),
  KEY `IDX_D4DAC3A3613FECDF` (`session_id`),
  CONSTRAINT `FK_D4DAC3A336C682D0` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D4DAC3A3613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.trainee_session : ~0 rows (environ)
/*!40000 ALTER TABLE `trainee_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `trainee_session` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. trainer
CREATE TABLE IF NOT EXISTS `trainer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name_trainer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name_trainer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_trainer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.trainer : ~0 rows (environ)
/*!40000 ALTER TABLE `trainer` DISABLE KEYS */;
/*!40000 ALTER TABLE `trainer` ENABLE KEYS */;

-- Listage de la structure de la table symfonysessions. training
CREATE TABLE IF NOT EXISTS `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_training` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_training` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysessions.training : ~0 rows (environ)
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` (`id`, `name_training`, `description_training`) VALUES
	(1, 'Microsoft office niveau 1', 'Les bases de la suite bureautique de Microsoft Office 365'),
	(2, 'Microsoft office niveau 2', 'niveau intermédaire'),
	(3, 'Développeur Web et Web Mobile', 'T.P niveau 5'),
	(4, 'Concepteur Designer UI', NULL);
/*!40000 ALTER TABLE `training` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
