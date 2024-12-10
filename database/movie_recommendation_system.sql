-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: movie_rec
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `status` enum('pending','accepted') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friendships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friendships_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
INSERT INTO `friendships` VALUES (1,1,2,'accepted','2024-11-24 10:47:20'),(3,7,5,'accepted','2024-11-24 21:29:53'),(4,7,4,'accepted','2024-11-24 21:29:59'),(5,5,4,'pending','2024-11-24 21:41:16'),(6,5,6,'pending','2024-11-24 21:41:19');
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `activity` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `description` text,
  `poster_url` varchar(255) DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `rating_avg` decimal(3,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,'Inception','Sci-Fi','2010-07-16','A thief who steals corporate secrets...','images/poster1.jpg','Christopher Nolan',1.00,'2024-11-24 10:47:20'),(2,'The Godfather','Crime','1972-03-24','The aging patriarch of an organized...','images/poster2.jpg','Francis Ford Coppola',4.50,'2024-11-24 10:47:20'),(3,'Parasite','Thriller','2019-05-30','Greed and class discrimination...','images/poster3.jpg','Bong Joon Ho',4.70,'2024-11-24 10:47:20'),(4,'The Shawshank Redemption','Drama','1994-09-22','Two imprisoned men bond over a number of years...','images/poster4.jpg','Frank Darabont',3.00,'2024-11-24 20:26:17'),(5,'The Dark Knight','Action','2008-07-18','When the menace known as the Joker emerges...','images/poster5.jpg','Christopher Nolan',4.80,'2024-11-24 20:26:17'),(6,'Forrest Gump','Drama','1994-07-06','The presidencies of Kennedy and Johnson...','images/poster6.jpg','Robert Zemeckis',4.70,'2024-11-24 20:26:17'),(7,'Pulp Fiction','Crime','1994-10-14','The lives of two mob hitmen, a boxer, a gangster...','images/poster7.jpg','Quentin Tarantino',4.80,'2024-11-24 20:26:17'),(8,'The Matrix','Sci-Fi','1999-03-31','A computer hacker learns from mysterious rebels...','images/poster8.jpg','Lana Wachowski, Lilly Wachowski',4.70,'2024-11-24 20:26:17'),(9,'Fight Club','Drama','1999-10-15','An insomniac office worker and a devil-may-care soap...','images/poster9.jpg','David Fincher',4.80,'2024-11-24 20:26:17'),(10,'The Lord of the Rings: The Fellowship of the Ring','Fantasy','2001-12-19','A meek Hobbit and eight companions...','images/poster10.jpg','Peter Jackson',4.80,'2024-11-24 20:26:17'),(11,'The Lord of the Rings: The Two Towers','Fantasy','2002-12-18','While Frodo and Sam edge closer...','images/poster11.jpg','Peter Jackson',4.80,'2024-11-24 20:26:17'),(12,'The Lord of the Rings: The Return of the King','Fantasy','2003-12-17','Gandalf and Aragorn lead the World of Men...','images/poster12.jpg','Peter Jackson',4.90,'2024-11-24 20:26:17'),(13,'Star Wars: Episode V - The Empire Strikes Back','Sci-Fi','1980-05-21','After the rebels are overpowered...','images/poster13.jpg','Irvin Kershner',4.70,'2024-11-24 20:26:17'),(14,'Schindler’s List','Drama','1993-12-15','In German-occupied Poland during World War II...','images/poster14.jpg','Steven Spielberg',4.90,'2024-11-24 20:26:17'),(15,'The Green Mile','Drama','1999-12-10','The lives of guards on Death Row...','images/poster15.jpg','Frank Darabont',4.80,'2024-11-24 20:26:17'),(16,'The Silence of the Lambs','Thriller','1991-02-14','A young F.B.I. cadet must receive...','images/poster16.jpg','Jonathan Demme',4.70,'2024-11-24 20:26:17'),(17,'Gladiator','Action','2000-05-05','A former Roman General sets out to exact vengeance...','images/poster17.jpg','Ridley Scott',4.60,'2024-11-24 20:26:17'),(18,'Titanic','Romance','1997-12-19','A seventeen-year-old aristocrat falls in love...','images/poster18.jpg','James Cameron',4.60,'2024-11-24 20:26:17'),(19,'Saving Private Ryan','War','1998-07-24','Following the Normandy Landings...','images/poster19.jpg','Steven Spielberg',4.80,'2024-11-24 20:26:17'),(20,'Interstellar','Sci-Fi','2014-11-07','A team of explorers travel through a wormhole...','images/poster20.jpg','Christopher Nolan',4.70,'2024-11-24 20:26:17'),(21,'The Prestige','Drama','2006-10-20','After a tragic accident, two stage magicians...','images/poster21.jpg','Christopher Nolan',4.60,'2024-11-24 20:26:17'),(22,'The Lion King','Animation','1994-06-24','Lion prince Simba and his father...','images/poster22.jpg','Roger Allers, Rob Minkoff',4.80,'2024-11-24 20:26:17'),(23,'Toy Story','Animation','1995-11-22','A cowboy doll is profoundly threatened...','images/poster23.jpg','John Lasseter',4.70,'2024-11-24 20:26:17'),(24,'Coco','Animation','2017-11-22','Aspiring musician Miguel, confronted...','images/poster24.jpg','Lee Unkrich, Adrian Molina',4.80,'2024-11-24 20:26:17'),(25,'Inside Out','Animation','2015-06-19','After young Riley is uprooted...','images/poster25.jpg','Pete Docter, Ronnie del Carmen',4.70,'2024-11-24 20:26:17'),(26,'Up','Animation','2009-05-29','78-year-old Carl Fredricksen travels to Paradise Falls...','images/poster26.jpg','Pete Docter, Bob Peterson',4.70,'2024-11-24 20:26:17'),(27,'The Incredibles','Animation','2004-11-05','A family of undercover superheroes...','images/poster27.jpg','Brad Bird',4.60,'2024-11-24 20:26:17'),(28,'Spider-Man: Into the Spider-Verse','Animation','2018-12-14','Teen Miles Morales becomes Spider-Man...','images/poster28.jpg','Bob Persichetti, Peter Ramsey, Rodney Rothman',4.70,'2024-11-24 20:26:17'),(29,'Avengers: Endgame','Action','2019-04-26','After the devastating events of Avengers: Infinity War...','images/poster29.jpg','Anthony Russo, Joe Russo',4.60,'2024-11-24 20:26:17'),(30,'Black Panther','Action','2018-02-16','TChalla, heir to the hidden but advanced...','images/poster30.jpg','Ryan Coogler',4.60,'2024-11-24 20:26:17'),(31,'Iron Man','Action','2008-05-02','After being held captive in an Afghan cave...','images/poster31.jpg','Jon Favreau',4.60,'2024-11-24 20:26:17'),(32,'Captain America: The Winter Soldier','Action','2014-04-04','As Steve Rogers struggles to embrace...','images/poster32.jpg','Anthony Russo, Joe Russo',4.70,'2024-11-24 20:26:17'),(33,'Doctor Strange','Action','2016-11-04','While on a journey of physical and spiritual healing...','images/poster33.jpg','Scott Derrickson',4.60,'2024-11-24 20:26:17'),(34,'Guardians of the Galaxy','Action','2014-08-01','A group of intergalactic criminals...','images/poster34.jpg','James Gunn',4.70,'2024-11-24 20:26:17'),(35,'Shrek','Animation','2001-05-18','A mean lord exiles fairytale creatures...','images/poster35.jpg','Andrew Adamson, Vicky Jenson',4.70,'2024-11-24 20:26:17'),(36,'Frozen','Animation','2013-11-27','When their kingdom becomes trapped in perpetual winter...','images/poster36.jpg','Chris Buck, Jennifer Lee',4.50,'2024-11-24 20:26:17'),(37,'The Social Network','Drama','2010-10-01','The story of Harvard student Mark Zuckerberg...','images/poster37.jpg','David Fincher',4.60,'2024-11-24 20:26:17'),(38,'Whiplash','Drama','2014-10-10','A promising young drummer enrolls...','images/poster38.jpg','Damien Chazelle',4.80,'2024-11-24 20:26:17'),(39,'La La Land','Romance','2016-12-09','While navigating their careers in Los Angeles...','images/poster39.jpg','Damien Chazelle',4.70,'2024-11-24 20:26:17'),(40,'The Grand Budapest Hotel','Comedy','2014-03-28','A writer encounters the owner...','images/poster40.jpg','Wes Anderson',4.60,'2024-11-24 20:26:17'),(41,'The Wolf of Wall Street','Biography','2013-12-25','Based on the true story of Jordan Belfort...','images/poster41.jpg','Martin Scorsese',4.60,'2024-11-24 20:26:17'),(42,'The Irishman','Crime','2019-11-27','A mob hitman recalls his possible involvement...','images/poster42.jpg','Martin Scorsese',4.50,'2024-11-24 20:26:17'),(43,'Goodfellas','Crime','1990-09-19','The story of Henry Hill and his life...','images/poster43.jpg','Martin Scorsese',4.80,'2024-11-24 20:26:17'),(44,'Casino','Crime','1995-11-22','A tale of greed, deception, money...','images/poster44.jpg','Martin Scorsese',4.70,'2024-11-24 20:26:17'),(45,'Django Unchained','Western','2012-12-25','With the help of a German bounty hunter...','images/poster45.jpg','Quentin Tarantino',4.70,'2024-11-24 20:26:17'),(46,'Once Upon a Time in Hollywood','Drama','2019-07-26','A faded television actor and his stunt double...','images/poster46.jpg','Quentin Tarantino',4.50,'2024-11-24 20:26:17'),(47,'Inglourious Basterds','War','2009-08-21','In Nazi-occupied France during World War II...','images/poster47.jpg','Quentin Tarantino',4.60,'2024-11-24 20:26:17'),(48,'The Hateful Eight','Western','2015-12-25','In the dead of a Wyoming winter...','images/poster48.jpg','Quentin Tarantino',4.50,'2024-11-24 20:26:17'),(49,'The Revenant','Drama','2015-12-25','A frontiersman on a fur trading expedition...','images/poster49.jpg','Alejandro G. Iñárritu',4.70,'2024-11-24 20:26:17'),(50,'Birdman','Comedy','2014-10-17','A washed-up superhero actor attempts...','images/poster50.jpg','Alejandro G. Iñárritu',4.60,'2024-11-24 20:26:17'),(51,'The Room','Drama','2003-06-27','Johnny is a successful banker with a great life...','images/poster51.jpg','Tommy Wiseau',2.90,'2024-11-24 20:26:33'),(52,'Cats','Musical','2019-12-20','A tribe of cats must decide annually...','images/poster52.jpg','Tom Hooper',2.70,'2024-11-24 20:26:33'),(53,'Batman & Robin','Action','1997-06-20','Batman and Robin try to keep their relationship...','images/poster53.jpg','Joel Schumacher',5.00,'2024-11-24 20:26:33'),(54,'Gigli','Comedy','2003-08-01','Larry Gigli is assigned to kidnap...','images/poster54.jpg','Martin Brest',2.60,'2024-11-24 20:26:33'),(55,'Battlefield Earth','Sci-Fi','2000-05-12','In the year 3000, Earth is ruled...','images/poster55.jpg','Roger Christian',2.40,'2024-11-24 20:26:33'),(56,'Movie 43','Comedy','2013-01-25','A series of interconnected short films...','images/poster56.jpg','Various Directors',3.20,'2024-11-24 20:26:33'),(57,'Jack and Jill','Comedy','2011-11-11','Family guy Jack persuades his twin sister Jill...','images/poster57.jpg','Dennis Dugan',4.00,'2024-11-24 20:26:33'),(58,'Dragonball Evolution','Action','2009-04-10','The young warrior Son Goku sets out...','images/poster58.jpg','James Wong',2.50,'2024-11-24 20:26:33'),(59,'Superbabies: Baby Geniuses 2','Comedy','2004-08-27','A group of smart-talking toddlers...','images/poster59.jpg','Bob Clark',2.00,'2024-11-24 20:26:33'),(60,'Slender Man','Horror','2018-08-10','In a small town, a group of friends...','images/poster60.jpg','Sylvain White',3.20,'2024-11-24 20:26:33'),(61,'Deneme','Tragedy','2000-12-06','What does the fox say? Ding ding ding ding din-di-di-di-din.','',NULL,0.00,'2024-12-06 16:34:58');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `review` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_chk_1` CHECK ((`rating` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (10,4,1,1,'fuck','2024-12-06 15:34:42'),(11,4,53,5,'yeah','2024-12-06 15:42:40'),(12,4,57,4,'haha','2024-12-06 16:07:31'),(13,4,4,3,'hjhgkhgj','2024-12-06 17:49:59');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommendations`
--

DROP TABLE IF EXISTS `recommendations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recommendations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `generated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommendations`
--

LOCK TABLES `recommendations` WRITE;
/*!40000 ALTER TABLE `recommendations` DISABLE KEYS */;
INSERT INTO `recommendations` VALUES (1,1,3,95.50,'2024-11-24 10:47:20'),(2,2,1,89.00,'2024-11-24 10:47:20');
/*!40000 ALTER TABLE `recommendations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared_watchlists`
--

DROP TABLE IF EXISTS `shared_watchlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shared_watchlists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sharer_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `shared_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sharer_id` (`sharer_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `shared_watchlists_ibfk_1` FOREIGN KEY (`sharer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shared_watchlists_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shared_watchlists_ibfk_3` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared_watchlists`
--

LOCK TABLES `shared_watchlists` WRITE;
/*!40000 ALTER TABLE `shared_watchlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `shared_watchlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'john_doe','john@example.com','hashed_password1','user',NULL,'2024-11-24 10:47:20','2024-11-24 10:47:20'),(2,'jane_smith','jane@example.com','hashed_password2','user',NULL,'2024-11-24 10:47:20','2024-11-24 10:47:20'),(4,'melis','melis@gmail.com','$2y$10$Vqu8JV9V9Fw4YwXOPM.SuOkRbaH8aExCgb9psIruuPzYeNjnpHjCq','user',NULL,'2024-11-24 11:02:36','2024-11-24 11:02:36'),(5,'asude','asude@gmail.com','$2y$10$Eta6tmVfNU/EvAKwbKwvY.ZyX2SaAR.6190uwJ/YAU0uiElgoyIwK','user',NULL,'2024-11-24 11:19:22','2024-11-24 11:19:22'),(6,'irem','irem@gmail.com','$2y$10$j4EYt3zsSUTROlJSHv7PwOxw7/aW7kC9dN6U4uDO9OczLdcHJhrQq','user',NULL,'2024-11-24 11:34:56','2024-11-24 11:34:56'),(7,'doğa','doga@gmail.com','$2y$10$rsR//GD95m2GnM0NJw0nb.NFlOQE3WvZ7Qy7D2hhyAA.wc6.rBThO','user',NULL,'2024-11-24 12:26:23','2024-11-24 12:26:23'),(8,'ahmet','ahmet@gmail.com','$2y$10$qrWDnBL2NbXGDUMv/v3G5O70OqEYlDL910Cw5RaVTtn.20ExOJnSu','user',NULL,'2024-11-24 21:52:45','2024-11-24 21:52:45'),(9,'deneme','deneme@gmail.com','$2y$10$w4P0UDeXXnKCVMtgywHdpuR86zEH9oYHrM93X40n/7MZMPjfsYFIa','user',NULL,'2024-11-25 05:34:10','2024-11-25 05:34:10'),(13,'admin','admin@example.com','$2y$10$Dznp4v5lQCUu.bqtMuCL3.lfqZtVc3CjlQ.Isj3Jl9XyHV6e1aKmW','admin',NULL,'2024-12-06 16:25:32','2024-12-06 16:25:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watched_movies`
--

DROP TABLE IF EXISTS `watched_movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `watched_movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `watched_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `watched_movies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `watched_movies_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watched_movies`
--

LOCK TABLES `watched_movies` WRITE;
/*!40000 ALTER TABLE `watched_movies` DISABLE KEYS */;
INSERT INTO `watched_movies` VALUES (1,1,1,'2024-11-24 10:47:20'),(2,1,2,'2024-11-24 10:47:20'),(3,2,3,'2024-11-24 10:47:20');
/*!40000 ALTER TABLE `watched_movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `watchlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watchlist`
--

LOCK TABLES `watchlist` WRITE;
/*!40000 ALTER TABLE `watchlist` DISABLE KEYS */;
INSERT INTO `watchlist` VALUES (1,1,3,'2024-11-24 10:47:20'),(2,2,1,'2024-11-24 10:47:20'),(3,2,2,'2024-11-24 10:47:20'),(5,5,1,'2024-11-24 11:24:21'),(13,4,1,'2024-11-24 12:22:02'),(14,7,3,'2024-11-24 12:26:43'),(16,4,53,'2024-11-24 20:43:49'),(17,6,1,'2024-11-24 20:59:30'),(18,7,4,'2024-11-24 21:00:36'),(19,7,1,'2024-11-24 21:30:46'),(20,7,53,'2024-11-24 21:35:30'),(21,4,2,'2024-11-24 22:03:20'),(23,4,14,'2024-11-24 22:40:24'),(24,9,2,'2024-11-25 05:34:36'),(25,9,4,'2024-11-25 05:34:46'),(26,4,57,'2024-12-06 16:01:11');
/*!40000 ALTER TABLE `watchlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-10 22:05:52
