CREATE DATABASE  IF NOT EXISTS `healthdataeasase` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
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
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trails`
--

LOCK TABLES `audit_trails` WRITE;
/*!40000 ALTER TABLE `audit_trails` DISABLE KEYS */;
INSERT INTO `audit_trails` VALUES (1,1,1,'users','login','success','Success','','2024-08-13 13:38:48','2024-08-13 13:38:48'),(2,1,0,'household_profiles','insertHousehold','success','Registration successful','{\"household_profile_id\":null,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-04\",\"age\":\"9 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-630172-1604-22\",\"nhts\":\"4P\\u2019S (Pantawid Pamilyang Pilipino Program)\",\"electricity\":\"Shared\",\"water_supply\":\"Deep Well\",\"toilet\":\"Flash Type\",\"philhealth_number\":null,\"blood_type\":\"A\",\"maintenance\":\"Diabetic\",\"height\":2,\"weight\":3,\"bmi\":7500,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-13 13:39:15','2024-08-13 13:39:15'),(3,1,0,'vaccinations','saveVaccination','success','Registration successful','{\"id\":0,\"personal_profile_id\":1,\"vaccine\":\"23\",\"vaccinator\":\"23\",\"dose\":0,\"vaccination_datetime\":\"2024-08-04 21:39:18\",\"remarks\":\"df\"}','2024-08-13 13:39:25','2024-08-13 13:39:25'),(4,1,0,'vaccinations','saveVaccination','success','Registration successful','{\"id\":0,\"personal_profile_id\":1,\"vaccine\":\"xd\",\"vaccinator\":\"gdfg\",\"dose\":2,\"vaccination_datetime\":\"2024-08-04 21:39:18\",\"remarks\":\"gfg\"}','2024-08-13 13:39:47','2024-08-13 13:39:47'),(5,1,2,'vaccinations','archiveVaccination','success','Successful','[]','2024-08-13 13:44:12','2024-08-13 13:44:12'),(6,1,1,'vaccinations','updateVaccination','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"vaccine\":\"23\",\"vaccinator\":\"23\",\"dose\":0,\"vaccination_datetime\":\"2024-08-12 21:46:40\",\"remarks\":\"df\"}','2024-08-13 13:46:43','2024-08-13 13:46:43'),(7,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-04\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\"}','2024-08-13 13:50:16','2024-08-13 13:50:16'),(8,1,1,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"id\":null,\"personal_profile_id\":1,\"post_partum\":0,\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4}','2024-08-13 13:50:28','2024-08-13 13:50:28'),(9,1,2,'household_profiles','insertHousehold','success','Registration successful','{\"household_profile_id\":null,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-04\",\"age\":\"9 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"id\":null,\"personal_profile_id\":null,\"household_number\":\"HN-438600-5094-64\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"Shared\",\"water_supply\":\"None\",\"toilet\":\"Close Pit\",\"philhealth_number\":null,\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"PWD (Person with Disability)\"}','2024-08-13 13:51:00','2024-08-13 13:51:00'),(10,1,3,'personal_profiles','insertPersonalProfile','success','Registration successful','{\"household_profile_id\":2,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-05\",\"age\":\"8 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"philhealth_number\":null,\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-13 13:51:30','2024-08-13 13:51:30'),(11,1,1,'vaccinations','updateVaccination','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"vaccine\":\"23\",\"vaccinator\":\"23\",\"dose\":0,\"vaccination_datetime\":\"2024-08-04 21:51:48\",\"remarks\":\"df\"}','2024-08-13 13:51:51','2024-08-13 13:51:51'),(12,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-05\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\"}','2024-08-13 13:58:04','2024-08-13 13:58:04'),(13,1,2,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":2,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-04\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\"}','2024-08-13 13:58:10','2024-08-13 13:58:10'),(14,1,2,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":2,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-07-01\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\"}','2024-08-13 13:58:16','2024-08-13 13:58:16'),(15,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Delivered\"}','2024-08-13 14:14:37','2024-08-13 14:14:37'),(16,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Delivered\"}','2024-08-13 14:14:45','2024-08-13 14:14:45'),(17,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Abort\"}','2024-08-13 14:15:49','2024-08-13 14:15:49'),(18,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Others\"}','2024-08-13 14:20:34','2024-08-13 14:20:34'),(19,1,2,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"id\":null,\"personal_profile_id\":1,\"post_partum\":2,\"family_planning\":\"Depo (Depo-Provera)\",\"type_of_delivery\":\"Vaginal Delivery (NSVD)\",\"lmp\":\"2024-08-06\",\"edc\":\"2025-05-13\",\"gp\":2,\"status\":\"Active\"}','2024-08-13 14:20:58','2024-08-13 14:20:58'),(20,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-05\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-13 14:29:43','2024-08-13 14:29:43'),(21,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-04\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Others\"}','2024-08-13 14:29:49','2024-08-13 14:29:49'),(22,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"IUD (Intrauterine Device)\",\"type_of_delivery\":\"Normal Spontaneous\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Delivered\"}','2024-08-13 14:31:26','2024-08-13 14:31:26'),(23,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"2\",\"family_planning\":\"Depo (Depo-Provera)\",\"type_of_delivery\":\"Vaginal Delivery (NSVD)\",\"lmp\":\"2024-08-06\",\"edc\":\"2025-05-13\",\"gp\":2,\"status\":\"Delivered\"}','2024-08-13 14:31:29','2024-08-13 14:31:29'),(24,1,3,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"id\":null,\"personal_profile_id\":1,\"post_partum\":0,\"family_planning\":\"None\",\"type_of_delivery\":\"None\",\"lmp\":\"2024-08-08\",\"edc\":\"2025-05-15\",\"gp\":0,\"status\":\"Abort\"}','2024-08-13 14:40:10','2024-08-13 14:40:10'),(25,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"None\",\"type_of_delivery\":\"None\",\"lmp\":\"2024-08-08\",\"edc\":\"2025-05-15\",\"gp\":0,\"status\":\"Abort\"}','2024-08-13 14:40:16','2024-08-13 14:40:16'),(26,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"2\",\"family_planning\":\"Depo (Depo-Provera)\",\"type_of_delivery\":\"Vaginal Delivery (NSVD)\",\"lmp\":\"2024-08-06\",\"edc\":\"2025-05-13\",\"gp\":2,\"status\":\"Delivered\"}','2024-08-13 14:40:25','2024-08-13 14:40:25'),(27,1,1,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"None\",\"type_of_delivery\":\"None\",\"lmp\":\"2024-08-08\",\"edc\":\"2025-05-15\",\"gp\":0,\"status\":\"Abort\"}','2024-08-13 14:41:09','2024-08-13 14:41:09'),(28,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-05\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-13 14:43:14','2024-08-13 14:43:14'),(29,1,3,'vaccinations','saveVaccination','success','Registration successful','{\"id\":0,\"personal_profile_id\":1,\"vaccine\":\"3434\",\"vaccinator\":\"3434\",\"dose\":0,\"vaccination_datetime\":\"2024-08-04 22:45:14\",\"remarks\":\"34\"}','2024-08-13 14:45:20','2024-08-13 14:45:20'),(30,1,1,'vaccinations','updateVaccination','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"vaccine\":\"111\",\"vaccinator\":\"222\",\"dose\":0,\"vaccination_datetime\":\"2024-08-04 22:45:14\",\"remarks\":\"df\"}','2024-08-13 14:45:25','2024-08-13 14:45:25'),(31,1,0,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"pregnancy_id\":1,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"None\",\"type_of_delivery\":\"None\",\"lmp\":\"2024-08-08\",\"edc\":\"2025-05-15\",\"gp\":0,\"status\":\"Delivered\"}','2024-08-13 14:48:41','2024-08-13 14:48:41'),(32,1,0,'pregnancy_form_profiles','updatePregnancy','success','Updated successfully','{\"pregnancy_id\":3,\"personal_profile_id\":1,\"post_partum\":\"0\",\"family_planning\":\"None\",\"type_of_delivery\":\"None\",\"lmp\":\"2024-08-08\",\"edc\":\"2025-05-15\",\"gp\":0,\"status\":\"Abort\"}','2024-08-13 14:48:45','2024-08-13 14:48:45'),(33,1,3,'pregnancy_form_profiles','archivePregnancy','success','Successful','[]','2024-08-13 14:49:03','2024-08-13 14:49:03'),(34,1,3,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":3,\"philhealth_number\":\"45\",\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-13 14:50:32','2024-08-13 14:50:32'),(35,1,1,'users','login','success','Success','','2024-08-13 14:52:45','2024-08-13 14:52:45'),(36,1,2,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":2,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-07-01\",\"sex\":\"Male\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Deceased\"}','2024-08-13 14:53:17','2024-08-13 14:53:17'),(37,1,1,'vaccinations','updateVaccination','success','Updated successfully','{\"id\":1,\"personal_profile_id\":1,\"vaccine\":\"111\",\"vaccinator\":\"sdsd\",\"dose\":0,\"vaccination_datetime\":\"2024-08-04 22:53:59\",\"remarks\":\"df\"}','2024-08-13 14:54:03','2024-08-13 14:54:03'),(38,1,1,'users','login','success','Success','','2024-08-13 14:55:27','2024-08-13 14:55:27'),(39,1,1,'users','login','success','Success','','2024-08-14 13:40:44','2024-08-14 13:40:44'),(40,1,1,'users','login','success','Success','','2024-08-14 14:07:43','2024-08-14 14:07:43'),(41,1,1,'users','login','success','Success','','2024-08-14 14:11:01','2024-08-14 14:11:01'),(42,1,1,'users','login','success','Success','','2024-08-14 14:50:30','2024-08-14 14:50:30'),(43,1,1,'users','login','success','Success','','2024-08-17 03:25:54','2024-08-17 03:25:54'),(44,1,1,'users','login','success','Success','','2024-08-17 03:27:48','2024-08-17 03:27:48'),(45,1,1,'users','login','success','Logged in successfully','','2024-08-17 03:47:50','2024-08-17 03:47:50'),(46,1,1,'users','login','success','Logged in successfully','','2024-08-17 03:52:51','2024-08-17 03:52:51'),(47,1,1,'users','login','success','Logged in successfully','','2024-08-17 07:03:37','2024-08-17 07:03:37'),(48,1,2,'household_profiles','updateHousehold','success','Updated successfully','{\"id\":2,\"personal_profile_id\":2,\"household_number\":\"HN-438600-5094-64\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"Shared\",\"water_supply\":\"None\",\"toilet\":\"Close Pit\"}','2024-08-17 07:05:33','2024-08-17 07:05:33'),(49,1,2,'household_profiles','updateHousehold','success','Updated successfully','{\"id\":2,\"personal_profile_id\":2,\"household_number\":\"HN-438600-5094-64\",\"nhts\":\"MCCT (Modified Conditional Cash Transfer)\",\"electricity\":\"Shared\",\"water_supply\":\"None\",\"toilet\":\"Close Pit\"}','2024-08-17 07:10:26','2024-08-17 07:10:26'),(50,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":null,\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:51:17','2024-08-17 07:51:17'),(51,1,3,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":3,\"philhealth_number\":\"45\",\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-17 07:51:19','2024-08-17 07:51:19'),(52,1,3,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":3,\"philhealth_number\":\"5646456\",\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":0,\"weight\":0,\"bmi\":0,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-17 07:51:22','2024-08-17 07:51:22'),(53,1,3,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":3,\"philhealth_number\":\"5646456\",\"blood_type\":\"B\",\"maintenance\":\"High-Blood\",\"height\":2,\"weight\":3,\"bmi\":7500,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-17 07:51:31','2024-08-17 07:51:31'),(54,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"jr\",\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:51:38','2024-08-17 07:51:38'),(55,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"jr\",\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:51:48','2024-08-17 07:51:48'),(56,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"jr\",\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:51:55','2024-08-17 07:51:55'),(57,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"jr\",\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:52:27','2024-08-17 07:52:27'),(58,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"sr\",\"birthdate\":\"2024-08-05\",\"age\":\"12 day\\/s old (0 months Newborn)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 07:52:49','2024-08-17 07:52:49'),(59,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"oo\",\"birthdate\":\"2024-08-04\",\"age\":\"13 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Others\"}','2024-08-17 07:55:05','2024-08-17 07:55:05'),(60,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"oo\",\"birthdate\":\"2024-08-04\",\"age\":\"13 day\\/s old (0 months Newborn)\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Others\"}','2024-08-17 07:55:07','2024-08-17 07:55:07'),(61,1,1,'health_profiles','updateHealthProfile','success','Updated successfully','{\"health_id\":1,\"philhealth_number\":\"E45\",\"blood_type\":\"A\",\"maintenance\":\"Diabetic\",\"height\":2,\"weight\":3,\"bmi\":7500,\"health_status\":\"High-Blood (Hypertension)\"}','2024-08-17 07:55:12','2024-08-17 07:55:12'),(62,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"oo\",\"birthdate\":\"2021-01-05\",\"age\":\"3 year\\/s old (43 months Toddler)\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Others\"}','2024-08-17 08:04:14','2024-08-17 08:04:14'),(63,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"sr\",\"birthdate\":\"1931-02-04\",\"age\":\"93 year\\/s old (1122 months Adult)\",\"sex\":\"Male\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 08:15:23','2024-08-17 08:15:23'),(64,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"345\",\"middlename\":\"3454\",\"suffix\":\"sr\",\"birthdate\":\"1931-02-04\",\"age\":\"93 year\\/s old (1122 months Adult)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 08:27:08','2024-08-17 08:27:08'),(65,1,4,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"pregnancy_id\":null,\"personal_profile_id\":3,\"post_partum\":45,\"family_planning\":\"Pills (Oral Contraceptives)\",\"type_of_delivery\":\"Vaginal Delivery (NSVD)\",\"lmp\":\"2024-08-06\",\"edc\":\"2025-05-13\",\"gp\":4,\"status\":\"Active\"}','2024-08-17 08:27:20','2024-08-17 08:27:20'),(66,1,3,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":3,\"lastname\":\"doe\",\"firstname\":\"hahahaha\",\"middlename\":\"3454\",\"suffix\":\"sr\",\"birthdate\":\"1931-02-04\",\"age\":\"93 year\\/s old (1122 months Adult)\",\"sex\":\"Female\",\"civil_status\":\"Married\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Move to another place\"}','2024-08-17 08:37:54','2024-08-17 08:37:54'),(67,1,1,'personal_profiles','updatePersonalProfile','success','Updated successfully','{\"id\":1,\"lastname\":\"345345\",\"firstname\":\"heheh\",\"middlename\":\"3454\",\"suffix\":\"oo\",\"birthdate\":\"2021-01-05\",\"age\":\"3 year\\/s old (43 months Toddler)\",\"sex\":\"Female\",\"civil_status\":\"Single\",\"educational_attainment\":\"Elementary Level\",\"work\":\"Farmer\",\"relation_ship_to_head\":\"Son\",\"phone_number\":\"09656585982\",\"status\":\"Others\"}','2024-08-17 08:38:02','2024-08-17 08:38:02'),(68,1,5,'pregnancy_form_profiles','insertPregnancy','success','Successful','{\"pregnancy_id\":null,\"personal_profile_id\":3,\"post_partum\":4,\"family_planning\":\"Condom\",\"type_of_delivery\":\"Vaginal Delivery (NSVD)\",\"lmp\":\"2024-08-04\",\"edc\":\"2025-05-11\",\"gp\":4,\"status\":\"Active\"}','2024-08-17 08:38:59','2024-08-17 08:38:59'),(69,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:05:37','2024-08-19 12:05:37'),(70,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:13:03','2024-08-19 12:13:03'),(71,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:28:38','2024-08-19 12:28:38'),(72,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:32:51','2024-08-19 12:32:51'),(73,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:37:39','2024-08-19 12:37:39'),(74,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:51:55','2024-08-19 12:51:55'),(75,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:53:06','2024-08-19 12:53:06'),(76,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:53:34','2024-08-19 12:53:34'),(77,1,1,'users','login','success','Logged in successfully','','2024-08-19 12:55:01','2024-08-19 12:55:01'),(78,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:03:08','2024-08-19 13:03:08'),(79,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:08:41','2024-08-19 13:08:41'),(80,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:11:45','2024-08-19 13:11:45'),(81,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:15:53','2024-08-19 13:15:53'),(82,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:16:22','2024-08-19 13:16:22'),(83,1,1,'users','login','success','Logged in successfully','','2024-08-19 13:17:26','2024-08-19 13:17:26');
/*!40000 ALTER TABLE `audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `health_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint unsigned NOT NULL,
  `philhealth_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health_profiles`
--

LOCK TABLES `health_profiles` WRITE;
/*!40000 ALTER TABLE `health_profiles` DISABLE KEYS */;
INSERT INTO `health_profiles` VALUES (1,1,'E45','A','Diabetic',2,3,7500,'High-Blood (Hypertension)',0,'2024-08-13 13:39:15','2024-08-17 07:55:12'),(2,2,NULL,'B','High-Blood',0,0,0,'PWD (Person with Disability)',0,'2024-08-13 13:51:00','2024-08-13 13:51:00'),(3,3,'5646456','B','High-Blood',2,3,7500,'High-Blood (Hypertension)',0,'2024-08-13 13:51:30','2024-08-17 07:51:31');
/*!40000 ALTER TABLE `health_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `household_profiles`
--

DROP TABLE IF EXISTS `household_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `household_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint NOT NULL,
  `household_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nhts` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `electricity` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `water_supply` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `toilet` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `household_profiles`
--

LOCK TABLES `household_profiles` WRITE;
/*!40000 ALTER TABLE `household_profiles` DISABLE KEYS */;
INSERT INTO `household_profiles` VALUES (1,1,'HN-630172-1604-22','4P’S (Pantawid Pamilyang Pilipino Program)','Shared','Deep Well','Flash Type',0,'2024-08-13 13:39:15','2024-08-13 13:39:15'),(2,2,'HN-438600-5094-64','MCCT (Modified Conditional Cash Transfer)','Shared','None','Close Pit',0,'2024-08-13 13:51:00','2024-08-17 07:10:26');
/*!40000 ALTER TABLE `household_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (206,'0001_01_01_000000_create_users_table',1),(207,'0001_01_01_000001_create_cache_table',1),(208,'0001_01_01_000002_create_jobs_table',1),(209,'2024_08_03_131511_create_personal_access_tokens_table',1),(210,'2024_08_04_025432_create_household_profiles_table',1),(211,'2024_08_04_025554_personal_profiles',1),(212,'2024_08_04_025630_create_health_profiles_table',1),(213,'2024_08_04_025810_create_pregnancy_form_profiles_table',1),(214,'2024_08_10_151249_vaccination',1),(215,'2024_08_10_154231_audit_trails',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
/*!50503 SET character_set_client = utf8mb4 */;
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
  `phone_number` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Active' COMMENT 'eg. Active, Died, Move to another place, Others',
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_profiles_household_profile_id_foreign` (`household_profile_id`),
  CONSTRAINT `personal_profiles_household_profile_id_foreign` FOREIGN KEY (`household_profile_id`) REFERENCES `household_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_profiles`
--

LOCK TABLES `personal_profiles` WRITE;
/*!40000 ALTER TABLE `personal_profiles` DISABLE KEYS */;
INSERT INTO `personal_profiles` VALUES (1,'345345','heheh','3454','oo','2021-01-05','Female','Single','Elementary Level','Farmer',1,'Son','09656585982','Others',0,'2024-08-13 13:39:15','2024-08-17 08:38:02'),(2,'345345','345','3454',NULL,'2024-07-01','Male','Single','Elementary Level','Farmer',2,'Son','09656585982','Deceased',0,'2024-08-13 13:51:00','2024-08-13 14:53:17'),(3,'doe','hahahaha','3454','sr','1931-02-04','Female','Married','Elementary Level','Farmer',2,'Son','09656585982','Move to another place',0,'2024-08-13 13:51:30','2024-08-17 08:37:54');
/*!40000 ALTER TABLE `personal_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregnancy_form_profiles`
--

DROP TABLE IF EXISTS `pregnancy_form_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregnancy_form_profiles`
--

LOCK TABLES `pregnancy_form_profiles` WRITE;
/*!40000 ALTER TABLE `pregnancy_form_profiles` DISABLE KEYS */;
INSERT INTO `pregnancy_form_profiles` VALUES (1,1,'0','None','None','2024-08-08','2025-05-15',0,'Delivered',0,'2024-08-13 13:50:28','2024-08-13 14:48:41'),(2,1,'2','Depo (Depo-Provera)','Vaginal Delivery (NSVD)','2024-08-06','2025-05-13',2,'Active',0,'2024-08-13 14:20:58','2024-08-13 14:20:58'),(3,1,'0','None','None','2024-08-08','2025-05-15',0,'Abort',1,'2024-08-13 14:40:10','2024-08-13 14:49:03'),(4,3,'45','Pills (Oral Contraceptives)','Vaginal Delivery (NSVD)','2024-08-06','2025-05-13',4,'Active',0,'2024-08-17 08:27:20','2024-08-17 08:27:20'),(5,3,'4','Condom','Vaginal Delivery (NSVD)','2024-08-04','2025-05-11',4,'Active',0,'2024-08-17 08:38:59','2024-08-17 08:38:59');
/*!40000 ALTER TABLE `pregnancy_form_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('hsvoUzdTNgN681pwxodPesPmAeEwURzNuEJrRTq4',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2JsMVJ2M3pYcVpDQjQwcGFlYUxvVXpJWWY5ZEVSQTdlZFBUNnBpeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3QvaGVhbHRoZGF0YWVhc2FzZS9wdWJsaWMvcHJvZmlsZS9ob3VzZWhvbGQiO319',1724073450);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` smallint NOT NULL DEFAULT '1' COMMENT '0 => Admin, 1 => BHW',
  `archive` smallint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin',NULL,NULL,'$2y$12$B8bh0BimZje4w7hKZ7ky6uuQVei7BcVi5yrh6PAzzrwaazNMYkEM.',0,0,NULL,'2024-08-13 13:38:40','2024-08-13 13:38:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccinations`
--

DROP TABLE IF EXISTS `vaccinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccinations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_profile_id` bigint unsigned NOT NULL,
  `vaccine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaccinator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dose` smallint NOT NULL DEFAULT '0',
  `vaccination_datetime` timestamp NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `archive` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vaccinations_personal_profile_id_foreign` (`personal_profile_id`),
  CONSTRAINT `vaccinations_personal_profile_id_foreign` FOREIGN KEY (`personal_profile_id`) REFERENCES `personal_profiles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccinations`
--

LOCK TABLES `vaccinations` WRITE;
/*!40000 ALTER TABLE `vaccinations` DISABLE KEYS */;
INSERT INTO `vaccinations` VALUES (1,1,'111','sdsd',0,'2024-08-04 14:53:59','df',0,'2024-08-13 13:39:25','2024-08-13 14:54:03'),(2,1,'xd','gdfg',2,'2024-08-04 13:39:18','gfg',1,'2024-08-13 13:39:47','2024-08-13 13:44:12'),(3,1,'3434','3434',0,'2024-08-04 14:45:14','34',0,'2024-08-13 14:45:20','2024-08-13 14:45:20');
/*!40000 ALTER TABLE `vaccinations` ENABLE KEYS */;
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

-- Dump completed on 2024-08-19 21:20:05
