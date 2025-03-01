USE `healthdataeasase`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: healthdataeasase
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_trails`
--

DROP TABLE IF EXISTS `audit_trails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `audit_trails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `reference_id` int NOT NULL DEFAULT '0',
  `reference_table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci COMMENT 'new data/first data',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trails`
--

LOCK TABLES `audit_trails` WRITE;
/*!40000 ALTER TABLE `audit_trails` DISABLE KEYS */;
INSERT INTO `audit_trails` VALUES (1,1,1,'users','forgotPassword','success','Password changed successfully','{\"id\":1,\"username\":\"admin\",\"hint\":\"admin\",\"password\":\"admin\",\"confirmPassword\":\"admin\"}','2024-10-26 03:47:38','2024-10-26 03:47:38'),(2,1,1,'users','login','success','Logged in successfully','','2024-10-26 03:47:41','2024-10-26 03:47:41'),(3,1,8,'users','updateUser','success','Updated successfully','{\"id\":8,\"username\":\"111111111111111\",\"lastname\":\"11111111\",\"firstname\":\"1111111111111\",\"middlename\":\"1111111111\",\"suffix\":\"1111111111\",\"hint\":\"111111111111111111111111\",\"role\":2,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 03:55:35','2024-10-26 03:55:35'),(4,1,2,'users','updateUser','success','Updated successfully','{\"id\":2,\"username\":\"sdf\",\"lastname\":\"sdfs\",\"firstname\":\"dfsd\",\"middlename\":\"dfs\",\"suffix\":\"dfs\",\"hint\":\"sdfsdf\",\"role\":1,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 04:00:03','2024-10-26 04:00:03'),(5,1,3,'users','updateUser','success','Updated successfully','{\"id\":3,\"username\":\"sdfsfsdfsdf\",\"lastname\":\"dfsd\",\"firstname\":\"fsdsdf\",\"middlename\":\"sdfsdf\",\"suffix\":\"sdf\",\"hint\":\"dfsdf\",\"role\":1,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 04:04:11','2024-10-26 04:04:11'),(6,1,1,'users','updateUser','success','Updated successfully','{\"id\":1,\"username\":\"admin\",\"lastname\":\"admin\",\"firstname\":\"admin\",\"middlename\":null,\"suffix\":null,\"hint\":\"admin\",\"role\":0,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 04:04:44','2024-10-26 04:04:44'),(7,1,3,'users','updateUser','success','Updated successfully','{\"id\":3,\"username\":\"sdfsfsdfsdf\",\"lastname\":\"dfsd\",\"firstname\":\"fsdsdf\",\"middlename\":\"sdfsdf\",\"suffix\":\"sdf\",\"hint\":\"dfsdf\",\"role\":1,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 04:05:14','2024-10-26 04:05:14'),(8,1,3,'purok','addPurok','success','Purok has been added successfull','{\"id\":null,\"name\":\"dfg\"}','2024-10-26 04:25:14','2024-10-26 04:25:14'),(9,1,3,'purok','update purok','success','Updated successfully','{\"id\":3,\"name\":\"dfgertert\"}','2024-10-26 04:25:32','2024-10-26 04:25:32'),(10,1,1,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:28:52','2024-10-26 04:28:52'),(11,1,3,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:28:55','2024-10-26 04:28:55'),(12,1,0,'vaccine','add vaccine','error','An error has occured','{\"id\":null,\"name\":null}','2024-10-26 04:29:58','2024-10-26 04:29:58'),(13,1,0,'vaccine','add vaccine','error','An error has occured','{\"id\":null,\"name\":\"sdfsdf\"}','2024-10-26 04:30:31','2024-10-26 04:30:31'),(14,1,0,'vaccine','add vaccine','error','An error has occured','{\"id\":null,\"name\":\"sdfsdf\"}','2024-10-26 04:30:33','2024-10-26 04:30:33'),(15,1,1,'vaccine','add vaccine','success','Vaccine has been added successfully','{\"id\":null,\"name\":\"asd\"}','2024-10-26 04:31:08','2024-10-26 04:31:08'),(16,1,0,'vaccine','update vaccine','success','Updated successfully','{\"id\":null,\"name\":null}','2024-10-26 04:31:13','2024-10-26 04:31:13'),(17,1,0,'vaccine','update vaccine','success','Updated successfully','{\"id\":null,\"name\":null}','2024-10-26 04:31:37','2024-10-26 04:31:37'),(18,1,1,'vaccine','update vaccine','success','Updated successfully','{\"id\":1,\"name\":\"asd11111111\"}','2024-10-26 04:31:57','2024-10-26 04:31:57'),(19,1,2,'purok','update purok','success','Updated successfully','{\"id\":2,\"name\":\"222\"}','2024-10-26 04:32:01','2024-10-26 04:32:01'),(20,1,2,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:35:32','2024-10-26 04:35:32'),(21,1,1,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:36:59','2024-10-26 04:36:59'),(22,1,4,'purok','addPurok','success','Purok has been added successfully','{\"id\":null,\"name\":\"sdf\"}','2024-10-26 04:37:09','2024-10-26 04:37:09'),(23,1,2,'vaccine','add vaccine','success','Vaccine has been added successfully','{\"id\":null,\"name\":\"sdfsdfs\"}','2024-10-26 04:37:12','2024-10-26 04:37:12'),(24,1,4,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:37:18','2024-10-26 04:37:18'),(25,1,2,'household_profiles','archiveHouseholdProfile','success','Successful','[]','2024-10-26 04:37:20','2024-10-26 04:37:20'),(26,1,5,'purok','addPurok','success','Purok has been added successfully','{\"id\":null,\"name\":\"sdfsdf\"}','2024-10-26 04:52:09','2024-10-26 04:52:09'),(27,1,5,'purok','update purok','success','Updated successfully','{\"id\":5,\"name\":\"Purok 1\"}','2024-10-26 04:52:15','2024-10-26 04:52:15'),(28,1,1,'household_profiles','insertHousehold','success','Registration successful','{\"household_profile_id\":null,\"lastname\":\"2342\",\"firstname\":\"3423\",\"middlename\":\"4234\",\"suffix\":\"23423\",\"birthdate\":\"2024-10-01\",\"age\":\"25 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Spouse\",\"phone_number\":\"34343434343\",\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-158853-5575-56\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"None\",\"water_supply\":\"Other(specify)\",\"toilet\":\"Close Pit\",\"bhw_user_id\":3,\"purok_id\":5,\"philhealth_number\":\"34\",\"blood_type\":\"AB\",\"maintenance\":\"Diabetic\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"Cancer\"}','2024-10-26 04:54:22','2024-10-26 04:54:22'),(29,1,2,'users','updateUser','success','Updated successfully','{\"id\":2,\"username\":\"sdf\",\"lastname\":\"sdfs\",\"firstname\":\"dfsd\",\"middlename\":\"dfs\",\"suffix\":\"dfs\",\"hint\":\"sdfsdf\",\"role\":2,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 05:00:03','2024-10-26 05:00:03'),(30,1,3,'vaccine','add vaccine','success','Vaccine has been added successfully','{\"id\":null,\"name\":\"Anti Polio\"}','2024-10-26 05:01:51','2024-10-26 05:01:51'),(31,1,1,'vaccinations','saveVaccination','success','Registration successful','{\"id\":0,\"personal_profile_id\":1,\"vaccine\":3,\"vaccinator\":2,\"dose\":3,\"vaccination_datetime\":\"2024-10-07 13:03:48\",\"remarks\":\"34\"}','2024-10-26 05:03:57','2024-10-26 05:03:57'),(32,1,1,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":1,\"philhealth_number\":\"34\",\"blood_type\":\"AB\",\"maintenance\":\"Diabetic\",\"height\":167,\"weight\":40,\"bmi\":14.34,\"health_status\":\"Cancer\"}','2024-10-26 06:59:49','2024-10-26 06:59:49'),(33,1,1,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"pregnancy_id\":null,\"personal_profile_id\":1,\"post_partum\":343,\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-10-02\",\"edc\":\"2025-07-09\",\"gp\":0,\"status\":\"Active\"}','2024-10-26 07:36:50','2024-10-26 07:36:50'),(34,1,0,'household_profiles','insertHousehold','error','An error has occured','{\"household_profile_id\":null,\"lastname\":\"2342342\",\"firstname\":\"34\",\"middlename\":\"324234\",\"suffix\":\"234\",\"birthdate\":\"2024-10-07\",\"age\":\"19 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Graduate\",\"work\":\"Fisherman\",\"relation_ship_to_head\":\"Daughter-in-law\",\"phone_number\":null,\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-679032-4069-83\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"None\",\"water_supply\":\"Deep Well\",\"toilet\":\"Flash Type\",\"bhw_user_id\":3,\"purok_id\":5,\"philhealth_number\":null,\"blood_type\":null,\"maintenance\":null,\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":null}','2024-10-26 07:43:31','2024-10-26 07:43:31'),(35,1,0,'household_profiles','insertHousehold','error','An error has occured','{\"household_profile_id\":null,\"lastname\":\"2342342\",\"firstname\":\"34\",\"middlename\":\"324234\",\"suffix\":\"234\",\"birthdate\":\"2024-10-07\",\"age\":\"19 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Graduate\",\"work\":\"Fisherman\",\"relation_ship_to_head\":\"Daughter-in-law\",\"phone_number\":null,\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-679032-4069-83\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"None\",\"water_supply\":\"Deep Well\",\"toilet\":\"Flash Type\",\"bhw_user_id\":3,\"purok_id\":5,\"philhealth_number\":null,\"blood_type\":null,\"maintenance\":null,\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":null}','2024-10-26 07:43:39','2024-10-26 07:43:39'),(36,1,4,'household_profiles','insertHousehold','success','Registration successful','{\"household_profile_id\":null,\"lastname\":\"2342342\",\"firstname\":\"34\",\"middlename\":\"324234\",\"suffix\":\"234\",\"birthdate\":\"2024-10-07\",\"age\":\"19 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Graduate\",\"work\":\"Fisherman\",\"relation_ship_to_head\":\"Daughter-in-law\",\"phone_number\":null,\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-679032-4069-83\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"None\",\"water_supply\":\"Deep Well\",\"toilet\":\"Flash Type\",\"bhw_user_id\":3,\"purok_id\":5,\"philhealth_number\":null,\"blood_type\":null,\"maintenance\":null,\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":null}','2024-10-26 07:44:20','2024-10-26 07:44:20'),(37,1,5,'personal_profiles','insertPersonalProfile','success','Registration successful','{\"household_profile_id\":4,\"lastname\":\"asd\",\"firstname\":\"sdfsdf\",\"middlename\":\"sdfsdf\",\"suffix\":null,\"birthdate\":\"2024-10-01\",\"age\":\"25 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Graduate\",\"work\":\"Laborer\",\"relation_ship_to_head\":\"Spouse\",\"phone_number\":null,\"philhealth_number\":null,\"blood_type\":null,\"maintenance\":null,\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":null}','2024-10-26 07:46:26','2024-10-26 07:46:26'),(38,1,1,'users','login','success','Logged in successfully','','2024-10-26 07:48:39','2024-10-26 07:48:39'),(39,1,2,'vaccinations','saveVaccination','success','Registration successful','{\"id\":0,\"personal_profile_id\":2,\"vaccine_id\":3,\"vaccinator_id\":2,\"dose\":3,\"vaccination_datetime\":\"2024-10-08 15:53:27\",\"remarks\":null}','2024-10-26 07:54:19','2024-10-26 07:54:19'),(40,1,9,'users','updateUser','success','Updated successfully','{\"id\":9,\"username\":\"asd\",\"lastname\":\"asd\",\"firstname\":\"asd\",\"middlename\":null,\"suffix\":\"asd\",\"hint\":\"asdasd\",\"role\":2,\"old_password\":null,\"password\":null,\"retype_password\":null}','2024-10-26 07:57:05','2024-10-26 07:57:05'),(41,1,1,'users','login','success','Logged in successfully','','2024-10-28 12:46:58','2024-10-28 12:46:58'),(42,1,6,'purok','addPurok','success','Purok has been added successfully','{\"id\":null,\"name\":\"alkshdkjahsdkjasd\"}','2024-10-28 12:48:26','2024-10-28 12:48:26'),(43,1,4,'vaccine','add vaccine','success','Vaccine has been added successfully','{\"id\":null,\"name\":\"qljwhekqjew\"}','2024-10-28 12:49:17','2024-10-28 12:49:17'),(44,1,6,'purok','update purok','success','Updated successfully','{\"id\":6,\"name\":\"Purok 2\"}','2024-10-28 12:52:13','2024-10-28 12:52:13');
/*!40000 ALTER TABLE `audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `health_profiles`
--

DROP TABLE IF EXISTS `health_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `health_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint unsigned NOT NULL,
  `philhealth_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` smallint NOT NULL,
  `weight` smallint NOT NULL,
  `bmi` double NOT NULL,
  `health_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `health_profiles_personal_profile_id_foreign` (`personal_profile_id`),
  CONSTRAINT `health_profiles_personal_profile_id_foreign` FOREIGN KEY (`personal_profile_id`) REFERENCES `personal_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health_profiles`
--

LOCK TABLES `health_profiles` WRITE;
/*!40000 ALTER TABLE `health_profiles` DISABLE KEYS */;
INSERT INTO `health_profiles` VALUES (1,1,'34','AB','Diabetic',167,40,14,'Cancer',0,'2024-10-26 04:54:22','2024-10-26 06:59:49'),(2,4,NULL,NULL,NULL,0,0,0,NULL,0,'2024-10-26 07:44:20','2024-10-26 07:44:20'),(3,5,NULL,NULL,NULL,0,0,0,NULL,0,'2024-10-26 07:46:26','2024-10-26 07:46:26');
/*!40000 ALTER TABLE `health_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `household_profiles`
--

DROP TABLE IF EXISTS `household_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `household_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint NOT NULL,
  `household_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bhw_user_id` bigint unsigned NOT NULL,
  `purok_id` bigint unsigned NOT NULL,
  `nhts` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `electricity` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `water_supply` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toilet` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `household_profiles_bhw_user_id_foreign` (`bhw_user_id`),
  KEY `household_profiles_purok_id_foreign` (`purok_id`),
  CONSTRAINT `household_profiles_bhw_user_id_foreign` FOREIGN KEY (`bhw_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `household_profiles_purok_id_foreign` FOREIGN KEY (`purok_id`) REFERENCES `puroks` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `household_profiles`
--

LOCK TABLES `household_profiles` WRITE;
/*!40000 ALTER TABLE `household_profiles` DISABLE KEYS */;
INSERT INTO `household_profiles` VALUES (1,1,'HN-158853-5575-56',3,5,'MCCT (Modified Conditional Cash Transfer)','None','Other(specify)','Close Pit',0,'2024-10-26 04:54:22','2024-10-26 04:54:22'),(2,0,'HN-679032-4069-83',3,5,'MCCT (Modified Conditional Cash Transfer)','None','Deep Well','Flash Type',0,'2024-10-26 07:43:31','2024-10-26 07:43:31'),(3,0,'HN-679032-4069-83',3,5,'MCCT (Modified Conditional Cash Transfer)','None','Deep Well','Flash Type',0,'2024-10-26 07:43:39','2024-10-26 07:43:39'),(4,4,'HN-679032-4069-83',3,5,'MCCT (Modified Conditional Cash Transfer)','None','Deep Well','Flash Type',0,'2024-10-26 07:44:20','2024-10-26 07:44:20');
/*!40000 ALTER TABLE `household_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_08_03_131511_create_personal_access_tokens_table',1),(5,'2024_08_04_025432_create_household_profiles_table',1),(6,'2024_08_04_025554_personal_profiles',1),(7,'2024_08_04_025630_create_health_profiles_table',1),(8,'2024_08_04_025810_create_pregnancy_form_profiles_table',1),(9,'2024_08_10_151249_vaccination',1),(10,'2024_08_10_154231_audit_trails',1),(11,'2024_08_17_120426_vitals',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_profiles`
--

DROP TABLE IF EXISTS `personal_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `personal_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date NOT NULL,
  `sex` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `educational_attainment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `household_profile_id` bigint unsigned NOT NULL,
  `relation_ship_to_head` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Active' COMMENT 'eg. Active, Died, Move to another place, Others',
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_profiles_household_profile_id_foreign` (`household_profile_id`),
  CONSTRAINT `personal_profiles_household_profile_id_foreign` FOREIGN KEY (`household_profile_id`) REFERENCES `household_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_profiles`
--

LOCK TABLES `personal_profiles` WRITE;
/*!40000 ALTER TABLE `personal_profiles` DISABLE KEYS */;
INSERT INTO `personal_profiles` VALUES (1,'2342','3423','4234','23423','1950-10-01','Female','Single','Elementary Level','Farmer',1,'Spouse','34343434343','Active',0,'2024-10-26 04:54:22','2024-10-26 04:54:22'),(2,'2342342','34','324234','234','2024-10-07','Female','Married','Elementary Graduate','Fisherman',2,'Daughter-in-law',NULL,'Active',0,'2024-10-26 07:43:31','2024-10-26 07:43:31'),(3,'2342342','34','324234','234','2024-10-07','Female','Married','Elementary Graduate','Fisherman',3,'Daughter-in-law',NULL,'Active',0,'2024-10-26 07:43:39','2024-10-26 07:43:39'),(4,'2342342','34','324234','234','2024-10-07','Female','Married','Elementary Graduate','Fisherman',4,'Daughter-in-law',NULL,'Active',0,'2024-10-26 07:44:20','2024-10-26 07:44:20'),(5,'asd','sdfsdf','sdfsdf',NULL,'2024-10-01','Female','Married','Elementary Graduate','Laborer',4,'Spouse',NULL,'Active',0,'2024-10-26 07:46:26','2024-10-26 07:46:26');
/*!40000 ALTER TABLE `personal_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregnancy_form_profiles`
--

DROP TABLE IF EXISTS `pregnancy_form_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `pregnancy_form_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint unsigned NOT NULL,
  `post_partum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_planning` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_delivery` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lmp` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edc` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gp` smallint NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Active' COMMENT 'eg. Active, Delivered, Abort, Others',
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pregnancy_form_profiles_personal_profile_id_foreign` (`personal_profile_id`),
  CONSTRAINT `pregnancy_form_profiles_personal_profile_id_foreign` FOREIGN KEY (`personal_profile_id`) REFERENCES `personal_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregnancy_form_profiles`
--

LOCK TABLES `pregnancy_form_profiles` WRITE;
/*!40000 ALTER TABLE `pregnancy_form_profiles` DISABLE KEYS */;
INSERT INTO `pregnancy_form_profiles` VALUES (1,1,'343','IUD (Intrauterine Device)','Normal Spontaneous','2024-10-02','2025-07-09',0,'Active',0,'2024-10-26 07:36:50','2024-10-26 07:36:50');
/*!40000 ALTER TABLE `pregnancy_form_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puroks`
--

DROP TABLE IF EXISTS `puroks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `puroks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puroks`
--

LOCK TABLES `puroks` WRITE;
/*!40000 ALTER TABLE `puroks` DISABLE KEYS */;
INSERT INTO `puroks` VALUES (1,'dfggdfg',1,'2024-10-26 04:05:27','2024-10-26 04:28:52'),(2,'222',1,'2024-10-26 04:06:31','2024-10-26 04:35:32'),(3,'dfgertert',1,'2024-10-26 04:25:14','2024-10-26 04:28:55'),(4,'sdf',1,'2024-10-26 04:37:09','2024-10-26 04:37:18'),(5,'Purok 1',0,'2024-10-26 04:52:09','2024-10-26 04:52:15'),(6,'Purok 2',0,'2024-10-28 12:48:26','2024-10-28 12:52:13');
/*!40000 ALTER TABLE `puroks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('qNZ6v46mXkaXAatSpZIqCGMk5rCccGUUHxoHhboY',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFdmc3I0Wng1TkFhUFNVWWtMOWFqdzVFOTBnZ2RXcEtTc09wTzV2NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvaGVhbHRoZGF0YWVhc2UvcHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1730119616),('tLAJj7LHgHPRiawYXEJjEJIhAdFyZqfTiA5BFdFX',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFg3MHFCcFdlYlhCT2xSdFlCV0FCTDk3NFFFNVdXRXNMbWRsTFZwbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9sb2NhbGhvc3QvaGVhbHRoZGF0YWVhc2UvcHVibGljL3Byb2ZpbGUvaG91c2Vob2xkIjt9fQ==',1730120324);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` smallint NOT NULL DEFAULT '1' COMMENT '0 => Admin, 1 => BHW',
  `archive` smallint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin',NULL,NULL,'$2y$12$CCZnzoHYwU97t7GbK57zteFuwkBgy8g4IHhUOtORHMjS2a7x/CuMi','admin',0,0,NULL,NULL,'2024-10-26 04:04:44'),(2,'sdf','dfsd','sdfs','dfs','dfs','$2y$12$Kyo7hCfgSV2srOYRuaS2veVyKCCmNQ/Sii442Q0GJdbMFZyl4O6F2','sdfsdf',2,0,NULL,'2024-10-26 03:50:38','2024-10-26 05:00:03'),(3,'sdfsfsdfsdf','fsdsdf','dfsd','sdfsdf','sdf','$2y$12$Y8L0cRmKIP35u0OfmPegUOkcqvy3HONnSV3cqFmPgKvMuGKslYIfm','dfsdf',1,0,NULL,'2024-10-26 03:51:23','2024-10-26 04:05:14'),(4,'dfg','dfg','dfg','dfgd','fgdf','$2y$12$kYlcT54f9u6jLw4uyKi25etbQU2T1Xwf5qkFdavjOc8HNBCvLN27e','gdfg',1,1,NULL,'2024-10-26 03:52:52','2024-10-26 03:56:50'),(5,'d','gdfg','fgdf','dfg','dfg','$2y$12$RgK7z3uPJO2EhQojA/7/g.gCSGQS9Ewgb1J/rwcIEatQWouHkAJr2','gdfg',1,1,NULL,'2024-10-26 03:53:31','2024-10-26 03:56:40'),(6,'1','1111111111111111','11111111111','11111111111','1111111111','$2y$12$PD9cMMVVsKnpkB85OmatjOuj59LGCwSWQAMmg0.Wwq0K662CW6Zpa','11111111111111',1,1,NULL,'2024-10-26 03:53:52','2024-10-26 03:55:17'),(7,'111','111111111111111','11111111111111','111111111','111111111','$2y$12$3bSt8EaHpjQZLHe8Jt7EV.ZjMEWFtsneCTWXpQPzkvhIfoOzxg2cm','1111111111',1,1,NULL,'2024-10-26 03:54:23','2024-10-26 03:55:13'),(8,'111111111111111','1111111111111','11111111','1111111111','1111111111','$2y$12$H8RRGTbBPfgNg3Cc4vNdd.l6jeoYlMNwUEgoq.3Q7BxE6i.eWWd82','111111111111111111111111',2,1,NULL,'2024-10-26 03:55:23','2024-10-26 03:56:38'),(9,'asd','asd','asd',NULL,'asd','$2y$12$oZBeSFEBCtWJhTFSBfBD/u9m/lbHYZpDwzUMJ.c272260OwCIVDKK','asdasd',2,0,NULL,'2024-10-26 07:55:12','2024-10-26 07:57:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccinations`
--

DROP TABLE IF EXISTS `vaccinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `vaccinations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint unsigned NOT NULL,
  `vaccine_id` bigint unsigned NOT NULL,
  `vaccinator_id` bigint unsigned NOT NULL,
  `dose` smallint NOT NULL DEFAULT '0',
  `vaccination_datetime` timestamp NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vaccinations_personal_profile_id_foreign` (`personal_profile_id`),
  KEY `vaccinations_vaccine_id_foreign` (`vaccine_id`),
  KEY `vaccinations_vaccinator_id_foreign` (`vaccinator_id`),
  CONSTRAINT `vaccinations_personal_profile_id_foreign` FOREIGN KEY (`personal_profile_id`) REFERENCES `personal_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `vaccinations_vaccinator_id_foreign` FOREIGN KEY (`vaccinator_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `vaccinations_vaccine_id_foreign` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccinations`
--

LOCK TABLES `vaccinations` WRITE;
/*!40000 ALTER TABLE `vaccinations` DISABLE KEYS */;
INSERT INTO `vaccinations` VALUES (1,1,3,2,3,'2024-10-07 05:03:48','34',0,'2024-10-26 05:03:57','2024-10-26 05:03:57'),(2,2,3,2,3,'2024-10-08 07:53:27',NULL,0,'2024-10-26 07:54:19','2024-10-26 07:54:19');
/*!40000 ALTER TABLE `vaccinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccines`
--

DROP TABLE IF EXISTS `vaccines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `vaccines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archive` smallint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccines`
--

LOCK TABLES `vaccines` WRITE;
/*!40000 ALTER TABLE `vaccines` DISABLE KEYS */;
INSERT INTO `vaccines` VALUES (1,'asd11111111',1,'2024-10-26 04:31:08','2024-10-26 04:36:59'),(2,'sdfsdfs',1,'2024-10-26 04:37:12','2024-10-26 04:37:20'),(3,'Anti Polio',0,'2024-10-26 05:01:51','2024-10-26 05:01:51'),(4,'qljwhekqjew',0,'2024-10-28 12:49:17','2024-10-28 12:49:17');
/*!40000 ALTER TABLE `vaccines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vitals`
--

DROP TABLE IF EXISTS `vitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8*/;
CREATE TABLE `vitals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `personal_profile_id` bigint unsigned NOT NULL,
  `blood_pressure` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` decimal(2,2) NOT NULL,
  `pulse` int NOT NULL,
  `respiration` int NOT NULL,
  `archive` smallint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vitals_user_id_foreign` (`user_id`),
  KEY `vitals_personal_profile_id_foreign` (`personal_profile_id`),
  CONSTRAINT `vitals_personal_profile_id_foreign` FOREIGN KEY (`personal_profile_id`) REFERENCES `personal_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `vitals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vitals`
--

LOCK TABLES `vitals` WRITE;
/*!40000 ALTER TABLE `vitals` DISABLE KEYS */;
/*!40000 ALTER TABLE `vitals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'healthdataeasase'
--

--
-- Dumping routines for database 'healthdataeasase'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-28 21:01:14
