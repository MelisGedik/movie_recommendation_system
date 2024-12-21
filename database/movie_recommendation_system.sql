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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (8,19,22,'accepted','2024-12-15 14:37:55','2024-12-15 14:39:10'),(10,19,20,'accepted','2024-12-15 14:53:42','2024-12-15 15:24:50'),(11,23,20,'accepted','2024-12-15 15:35:36','2024-12-15 15:36:32'),(12,23,19,'accepted','2024-12-15 15:37:12','2024-12-15 15:38:59'),(13,20,22,'accepted','2024-12-15 15:59:36','2024-12-15 15:59:54'),(14,25,19,'accepted','2024-12-16 08:38:16','2024-12-16 08:38:58'),(15,26,19,'accepted','2024-12-16 10:01:59','2024-12-16 10:02:22'),(16,27,19,'accepted','2024-12-21 10:13:57','2024-12-21 10:14:20'),(17,19,28,'accepted','2024-12-21 10:51:26','2024-12-21 11:01:48'),(18,28,20,'accepted','2024-12-21 11:02:14','2024-12-21 12:06:10'),(19,19,27,'accepted','2024-12-21 11:13:44','2024-12-21 11:13:57'),(20,27,26,'accepted','2024-12-21 11:15:31','2024-12-21 12:16:45'),(22,29,20,'accepted','2024-12-21 12:53:06','2024-12-21 12:53:32'),(23,29,28,'pending','2024-12-21 12:53:17','2024-12-21 12:53:17'),(24,26,20,'pending','2024-12-21 12:57:09','2024-12-21 12:57:09');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,'Inception','Sci-Fi','2010-07-16','A thief who steals corporate secrets...','images/poster1.jpg','Christopher Nolan',2.50,'2024-11-24 10:47:20'),(2,'The Godfather','Crime','1972-03-24','The aging patriarch of an organized...','images/poster2.jpg','Francis Ford Coppola',4.50,'2024-11-24 10:47:20'),(3,'Parasite','Thriller','2019-05-30','Greed and class discrimination...','images/poster3.jpg','Bong Joon Ho',4.70,'2024-11-24 10:47:20'),(4,'The Shawshank Redemption','Drama','1994-09-22','Two imprisoned men bond over a number of years...','images/poster4.jpg','Frank Darabont',3.00,'2024-11-24 20:26:17'),(5,'The Dark Knight','Action','2008-07-18','When the menace known as the Joker emerges...','images/poster5.jpg','Christopher Nolan',3.00,'2024-11-24 20:26:17'),(6,'Forrest Gump','Drama','1994-07-06','The presidencies of Kennedy and Johnson...','images/poster6.jpg','Robert Zemeckis',4.70,'2024-11-24 20:26:17'),(7,'Pulp Fiction','Crime','1994-10-14','The lives of two mob hitmen, a boxer, a gangster...','images/poster7.jpg','Quentin Tarantino',4.80,'2024-11-24 20:26:17'),(8,'The Matrix','Sci-Fi','1999-03-31','A computer hacker learns from mysterious rebels...','images/poster8.jpg','Lana Wachowski, Lilly Wachowski',4.00,'2024-11-24 20:26:17'),(9,'Fight Club','Drama','1999-10-15','An insomniac office worker and a devil-may-care soap...','images/poster9.jpg','David Fincher',4.80,'2024-11-24 20:26:17'),(10,'The Lord of the Rings: The Fellowship of the Ring','Fantasy','2001-12-19','A meek Hobbit and eight companions...','images/poster10.jpg','Peter Jackson',4.80,'2024-11-24 20:26:17'),(11,'The Lord of the Rings: The Two Towers','Fantasy','2002-12-18','While Frodo and Sam edge closer...','images/poster11.jpg','Peter Jackson',4.80,'2024-11-24 20:26:17'),(12,'The Lord of the Rings: The Return of the King','Fantasy','2003-12-17','Gandalf and Aragorn lead the World of Men...','images/poster12.jpg','Peter Jackson',5.00,'2024-11-24 20:26:17'),(13,'Star Wars: Episode V - The Empire Strikes Back','Sci-Fi','1980-05-21','After the rebels are overpowered...','images/poster13.jpg','Irvin Kershner',4.70,'2024-11-24 20:26:17'),(14,'Schindler’s List','Drama','1993-12-15','In German-occupied Poland during World War II...','images/poster14.jpg','Steven Spielberg',4.00,'2024-11-24 20:26:17'),(15,'The Green Mile','Drama','1999-12-10','The lives of guards on Death Row...','images/poster15.jpg','Frank Darabont',4.80,'2024-11-24 20:26:17'),(16,'The Silence of the Lambs','Thriller','1991-02-14','A young F.B.I. cadet must receive...','images/poster16.jpg','Jonathan Demme',4.70,'2024-11-24 20:26:17'),(17,'Gladiator','Action','2000-05-05','A former Roman General sets out to exact vengeance...','images/poster17.jpg','Ridley Scott',4.60,'2024-11-24 20:26:17'),(18,'Titanic','Romance','1997-12-19','A seventeen-year-old aristocrat falls in love...','images/poster18.jpg','James Cameron',4.60,'2024-11-24 20:26:17'),(19,'Saving Private Ryan','War','1998-07-24','Following the Normandy Landings...','images/poster19.jpg','Steven Spielberg',4.80,'2024-11-24 20:26:17'),(20,'Interstellar','Sci-Fi','2014-11-07','A team of explorers travel through a wormhole...','images/poster20.jpg','Christopher Nolan',4.70,'2024-11-24 20:26:17'),(21,'The Prestige','Drama','2006-10-20','After a tragic accident, two stage magicians...','images/poster21.jpg','Christopher Nolan',4.60,'2024-11-24 20:26:17'),(22,'The Lion King','Animation','1994-06-24','Lion prince Simba and his father...','images/poster22.jpg','Roger Allers, Rob Minkoff',4.33,'2024-11-24 20:26:17'),(23,'Toy Story','Animation','1995-11-22','A cowboy doll is profoundly threatened...','images/poster23.jpg','John Lasseter',4.70,'2024-11-24 20:26:17'),(24,'Coco','Animation','2017-11-22','Aspiring musician Miguel, confronted...','images/poster24.jpg','Lee Unkrich, Adrian Molina',4.80,'2024-11-24 20:26:17'),(25,'Inside Out','Animation','2015-06-19','After young Riley is uprooted...','images/poster25.jpg','Pete Docter, Ronnie del Carmen',4.70,'2024-11-24 20:26:17'),(26,'Up','Animation','2009-05-29','78-year-old Carl Fredricksen travels to Paradise Falls...','images/poster26.jpg','Pete Docter, Bob Peterson',4.70,'2024-11-24 20:26:17'),(27,'The Incredibles','Animation','2004-11-05','A family of undercover superheroes...','images/poster27.jpg','Brad Bird',4.60,'2024-11-24 20:26:17'),(28,'Spider-Man: Into the Spider-Verse','Animation','2018-12-14','Teen Miles Morales becomes Spider-Man...','images/poster28.jpg','Bob Persichetti, Peter Ramsey, Rodney Rothman',4.70,'2024-11-24 20:26:17'),(29,'Avengers: Endgame','Action','2019-04-26','After the devastating events of Avengers: Infinity War...','images/poster29.jpg','Anthony Russo, Joe Russo',4.60,'2024-11-24 20:26:17'),(30,'Black Panther','Action','2018-02-16','TChalla, heir to the hidden but advanced...','images/poster30.jpg','Ryan Coogler',4.60,'2024-11-24 20:26:17'),(31,'Iron Man','Action','2008-05-02','After being held captive in an Afghan cave...','images/poster31.jpg','Jon Favreau',5.00,'2024-11-24 20:26:17'),(32,'Captain America: The Winter Soldier','Action','2014-04-04','As Steve Rogers struggles to embrace...','images/poster32.jpg','Anthony Russo, Joe Russo',4.70,'2024-11-24 20:26:17'),(33,'Doctor Strange','Action','2016-11-04','While on a journey of physical and spiritual healing...','images/poster33.jpg','Scott Derrickson',4.60,'2024-11-24 20:26:17'),(34,'Guardians of the Galaxy','Action','2014-08-01','A group of intergalactic criminals...','images/poster34.jpg','James Gunn',4.70,'2024-11-24 20:26:17'),(35,'Shrek','Animation','2001-05-18','A mean lord exiles fairytale creatures...','images/poster35.jpg','Andrew Adamson, Vicky Jenson',1.00,'2024-11-24 20:26:17'),(36,'Frozen','Animation','2013-11-27','When their kingdom becomes trapped in perpetual winter...','images/poster36.jpg','Chris Buck, Jennifer Lee',4.50,'2024-11-24 20:26:17'),(37,'The Social Network','Drama','2010-10-01','The story of Harvard student Mark Zuckerberg...','images/poster37.jpg','David Fincher',4.60,'2024-11-24 20:26:17'),(38,'Whiplash','Drama','2014-10-10','A promising young drummer enrolls...','images/poster38.jpg','Damien Chazelle',4.80,'2024-11-24 20:26:17'),(39,'La La Land','Romance','2016-12-09','While navigating their careers in Los Angeles...','images/poster39.jpg','Damien Chazelle',4.70,'2024-11-24 20:26:17'),(40,'The Grand Budapest Hotel','Comedy','2014-03-28','A writer encounters the owner...','images/poster40.jpg','Wes Anderson',4.60,'2024-11-24 20:26:17'),(41,'The Wolf of Wall Street','Biography','2013-12-25','Based on the true story of Jordan Belfort...','images/poster41.jpg','Martin Scorsese',4.60,'2024-11-24 20:26:17'),(42,'The Irishman','Crime','2019-11-27','A mob hitman recalls his possible involvement...','images/poster42.jpg','Martin Scorsese',4.50,'2024-11-24 20:26:17'),(43,'Goodfellas','Crime','1990-09-19','The story of Henry Hill and his life...','images/poster43.jpg','Martin Scorsese',4.80,'2024-11-24 20:26:17'),(44,'Casino','Crime','1995-11-22','A tale of greed, deception, money...','images/poster44.jpg','Martin Scorsese',4.70,'2024-11-24 20:26:17'),(45,'Django Unchained','Western','2012-12-25','With the help of a German bounty hunter...','images/poster45.jpg','Quentin Tarantino',4.70,'2024-11-24 20:26:17'),(46,'Once Upon a Time in Hollywood','Drama','2019-07-26','A faded television actor and his stunt double...','images/poster46.jpg','Quentin Tarantino',4.50,'2024-11-24 20:26:17'),(47,'Inglourious Basterds','War','2009-08-21','In Nazi-occupied France during World War II...','images/poster47.jpg','Quentin Tarantino',4.60,'2024-11-24 20:26:17'),(48,'The Hateful Eight','Western','2015-12-25','In the dead of a Wyoming winter...','images/poster48.jpg','Quentin Tarantino',4.50,'2024-11-24 20:26:17'),(49,'The Revenant','Drama','2015-12-25','A frontiersman on a fur trading expedition...','images/poster49.jpg','Alejandro G. Iñárritu',4.70,'2024-11-24 20:26:17'),(50,'Birdman','Comedy','2014-10-17','A washed-up superhero actor attempts...','images/poster50.jpg','Alejandro G. Iñárritu',4.60,'2024-11-24 20:26:17'),(51,'The Room','Drama','2003-06-27','Johnny is a successful banker with a great life...','images/poster51.jpg','Tommy Wiseau',2.90,'2024-11-24 20:26:33'),(52,'Cats','Musical','2019-12-20','A tribe of cats must decide annually...','images/poster52.jpg','Tom Hooper',2.70,'2024-11-24 20:26:33'),(53,'Batman & Robin','Action','1997-06-20','Batman and Robin try to keep their relationship...','images/poster53.jpg','Joel Schumacher',5.00,'2024-11-24 20:26:33'),(54,'Gigli','Comedy','2003-08-01','Larry Gigli is assigned to kidnap...','images/poster54.jpg','Martin Brest',2.60,'2024-11-24 20:26:33'),(55,'Battlefield Earth','Sci-Fi','2000-05-12','In the year 3000, Earth is ruled...','images/poster55.jpg','Roger Christian',2.40,'2024-11-24 20:26:33'),(56,'Movie 43','Comedy','2013-01-25','A series of interconnected short films...','images/poster56.jpg','Various Directors',4.00,'2024-11-24 20:26:33'),(57,'Jack and Jill','Comedy','2011-11-11','Family guy Jack persuades his twin sister Jill...','images/poster57.jpg','Dennis Dugan',4.00,'2024-11-24 20:26:33'),(58,'Dragonball Evolution','Action','2009-04-10','The young warrior Son Goku sets out...','images/poster58.jpg','James Wong',2.50,'2024-11-24 20:26:33'),(59,'Superbabies: Baby Geniuses 2','Comedy','2004-08-27','A group of smart-talking toddlers...','images/poster59.jpg','Bob Clark',2.00,'2024-11-24 20:26:33'),(60,'Slender Man','Horror','2018-08-10','In a small town, a group of friends...','images/poster60.jpg','Sylvain White',3.20,'2024-11-24 20:26:33'),(61,'Deneme','Tragedy','2000-12-06','What does the fox say? Ding ding ding ding din-di-di-di-din.','images/poster61.jpg',NULL,0.00,'2024-12-06 16:34:58'),(62,'deneme2','Tragedy','2007-01-01','The song that started the chocolate revolution.','images/poster62.jpg',NULL,0.00,'2024-12-15 16:23:06'),(63,'Finding Nemo','Animation','2003-05-30','After his son is captured in the Great Barrier Reef and taken to Sydney, a timid clownfish sets out on a journey to bring him home.','images/poster63.jpg','Andrew Stanton, Lee Unkrich',4.80,'2024-12-21 12:24:11'),(64,'The Lego Movie','Animation','2014-02-07','An ordinary Lego construction worker, thought to be the prophesied special, is recruited to join a quest to stop an evil tyrant.','images/poster64.jpg','Phil Lord, Christopher Miller',4.60,'2024-12-21 12:24:11'),(65,'Monsters, Inc.','Animation','2001-11-02','In order to power the city, monsters have to scare children, but then a little girl enters their world.','images/poster65.jpg','Pete Docter, David Silverman, Lee Unkrich',4.70,'2024-12-21 12:24:11'),(66,'Big Hero 6','Animation','2014-11-07','A special bond develops between plus-sized inflatable robot Baymax, and prodigy Hiro Hamada.','images/poster66.jpg','Don Hall, Chris Williams',4.70,'2024-12-21 12:24:11'),(67,'Ratatouille','Animation','2007-06-29','A rat who can cook makes an unusual alliance with a young kitchen worker at a famous restaurant.','images/poster67.jpg','Brad Bird, Jan Pinkava',4.80,'2024-12-21 12:24:11'),(68,'Zootopia','Animation','2016-03-04','In a city of anthropomorphic animals, a rookie bunny cop and a cynical con artist fox must work together.','images/poster68.jpg','Byron Howard, Rich Moore, Jared Bush',4.70,'2024-12-21 12:24:11'),(69,'Kung Fu Panda','Animation','2008-06-06','The Dragon Warrior has to clash against the savage Tai Lung as Chinas fate hangs in the balance.','images/poster69.jpg','Mark Osborne, John Stevenson',4.70,'2024-12-21 12:24:11'),(70,'How to Train Your Dragon','Animation','2010-03-26','A hapless young Viking who aspires to hunt dragons becomes the unlikely friend of a young dragon himself.','images/poster70.jpg','Dean DeBlois, Chris Sanders',4.80,'2024-12-21 12:24:11'),(71,'Madagascar','Animation','2005-05-27','A group of animals who have spent all their life in a New York zoo find themselves in the jungles of Madagascar.','images/poster71.jpg','Eric Darnell, Tom McGrath',4.50,'2024-12-21 12:24:11'),(72,'Despicable Me','Animation','2010-07-09','When a criminal mastermind uses a trio of orphan girls as pawns, he finds their love profoundly changes him.','images/poster72.jpg','Pierre Coffin, Chris Renaud',4.60,'2024-12-21 12:24:11'),(73,'A Beautiful Mind','Biography','2001-12-21','After John Nash, a brilliant but asocial mathematician, accepts secret work in cryptography, his life takes a turn for the nightmarish.','images/poster73.jpg','Ron Howard',4.80,'2024-12-21 12:24:11'),(74,'The Truman Show','Drama','1998-06-05','An insurance salesman discovers his entire life is actually a reality TV show.','images/poster74.jpg','Peter Weir',4.70,'2024-12-21 12:24:11'),(75,'Amélie','Romance','2001-04-25','Amélie is an innocent and naive girl in Paris with her own sense of justice.','images/poster75.jpg','Jean-Pierre Jeunet',4.80,'2024-12-21 12:24:11'),(76,'No Country for Old Men','Crime','2007-11-21','Violence and mayhem ensue after a hunter stumbles upon a drug deal gone wrong.','images/poster76.jpg','Ethan Coen, Joel Coen',4.70,'2024-12-21 12:24:11'),(77,'The Departed','Crime','2006-10-06','An undercover cop and a mole in the police attempt to identify each other.','images/poster77.jpg','Martin Scorsese',4.80,'2024-12-21 12:24:11'),(78,'The Pianist','Biography','2002-09-25','A Polish Jewish musician struggles to survive the destruction of the Warsaw ghetto.','images/poster78.jpg','Roman Polanski',4.80,'2024-12-21 12:24:11'),(79,'The Great Gatsby','Drama','2013-05-10','A writer and wall street trader, Nick, finds himself drawn to the past and lifestyle of his millionaire neighbor, Jay Gatsby.','images/poster79.jpg','Baz Luhrmann',4.60,'2024-12-21 12:24:11'),(80,'The Shining','Horror','1980-05-23','A family heads to an isolated hotel for the winter where an evil presence influences the father.','images/poster80.jpg','Stanley Kubrick',4.70,'2024-12-21 12:24:11'),(81,'Alien','Sci-Fi','1979-05-25','A commercial vessel encounters a deadly life form after investigating an unknown transmission.','images/poster81.jpg','Ridley Scott',4.80,'2024-12-21 12:24:11'),(82,'Blade Runner','Sci-Fi','1982-06-25','A blade runner must pursue and terminate four replicants who stole a ship in space.','images/poster82.jpg','Ridley Scott',4.70,'2024-12-21 12:24:11'),(83,'The Big Lebowski','Comedy','1998-03-06','Jeff \"The Dude\" Lebowski gets involved in a big case of mistaken identity.','images/poster83.jpg','Joel Coen, Ethan Coen',4.60,'2024-12-21 12:24:11'),(84,'12 Angry Men','Drama','1957-04-10','A jury holdout attempts to prevent a miscarriage of justice by forcing his colleagues to reconsider.','images/poster84.jpg','Sidney Lumet',5.00,'2024-12-21 12:24:11'),(85,'The Breakfast Club','Comedy','1985-02-15','Five high school students meet in Saturday detention and discover how they have a lot more in common.','images/poster85.jpg','John Hughes',4.60,'2024-12-21 12:24:11'),(86,'Eternal Sunshine of the Spotless Mind','Romance','2004-03-19','When their relationship turns sour, a couple undergoes a medical procedure to erase each other from their memories.','images/poster86.jpg','Michel Gondry',4.80,'2024-12-21 12:24:11'),(87,'The Sixth Sense','Thriller','1999-08-06','A boy who communicates with spirits seeks the help of a disheartened child psychologist.','images/poster87.jpg','M. Night Shyamalan',4.70,'2024-12-21 12:24:11'),(88,'The Bourne Identity','Action','2002-06-14','A man is picked up by a fishing boat, bullet-riddled and suffering from amnesia.','images/poster88.jpg','Doug Liman',4.60,'2024-12-21 12:24:11'),(89,'Skyfall','Action','2012-11-09','Bonds loyalty to M is tested as her past comes back to haunt her.','images/poster89.jpg','Sam Mendes',4.70,'2024-12-21 12:24:11'),(90,'Gravity','Sci-Fi','2013-10-04','Two astronauts work together to survive after an accident leaves them stranded in space.','images/poster90.jpg','Alfonso Cuarón',4.60,'2024-12-21 12:24:11'),(91,'The Hurt Locker','War','2008-10-10','During the Iraq War, a Sergeant is tasked with defusing bombs.','images/poster91.jpg','Kathryn Bigelow',4.70,'2024-12-21 12:24:11'),(92,'Million Dollar Baby','Drama','2004-12-15','A determined woman works with a hardened boxing trainer to become a professional.','images/poster92.jpg','Clint Eastwood',4.80,'2024-12-21 12:24:11'),(93,'Slumdog Millionaire','Drama','2008-11-12','A Mumbai teenager reflects on his life after being accused of cheating on a game show.','images/poster93.jpg','Danny Boyle, Loveleen Tandan',4.80,'2024-12-21 12:24:11'),(94,'The Curious Case of Benjamin Button','Drama','2008-12-25','Tells the story of Benjamin Button, a man who starts aging backwards.','images/poster94.jpg','David Fincher',4.70,'2024-12-21 12:24:11'),(95,'Dead Poets Society','Drama','1989-06-09','An English teacher inspires his students to seize the day and follow their dreams.','images/poster95.jpg','Peter Weir',4.80,'2024-12-21 12:24:11'),(96,'Apollo 13','Drama','1995-06-30','NASA must devise a strategy to return a damaged spacecraft to Earth.','images/poster96.jpg','Ron Howard',4.70,'2024-12-21 12:24:11'),(97,'Bohemian Rhapsody','Biography','2018-11-02','The story of the legendary rock band Queen.','images/poster97.jpg','Bryan Singer',4.60,'2024-12-21 12:24:11'),(98,'Joker','Drama','2019-10-04','In Gothams fractured society, a man struggles to find his place.','images/poster98.jpg','Todd Phillips',4.70,'2024-12-21 12:24:11'),(99,'The Kings Speech','Biography','2010-12-25','The story of King George VIs efforts to overcome his stammer.','images/poster99.jpg','Tom Hooper',4.80,'2024-12-21 12:24:11'),(100,'Life is Beautiful','Comedy','1997-12-20','A Jewish father and his family find joy and resilience in a Nazi concentration camp.','images/poster100.jpg','Roberto Benigni',4.90,'2024-12-21 12:24:11');
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (20,19,8,4,'What an eye opening movie!','2024-12-12 18:27:44'),(21,19,26,5,'I teared up while watching...','2024-12-12 18:42:02'),(22,19,16,3,'boriingggg','2024-12-12 18:44:56'),(23,19,23,5,'amazing','2024-12-12 19:05:48'),(24,22,7,5,'nice','2024-12-13 17:31:06'),(25,19,5,3,'kinda boring','2024-12-15 13:25:42'),(26,19,22,4,'denemedeneme','2024-12-15 13:30:52'),(27,19,34,4,'good','2024-12-15 13:54:08'),(28,19,14,4,'-','2024-12-16 07:32:08'),(29,25,23,5,'most amazing movie ever','2024-12-16 08:38:00'),(30,26,13,5,'vvvb','2024-12-16 10:00:37'),(31,27,23,4,'müko','2024-12-21 10:13:07'),(32,19,35,1,'','2024-12-21 12:01:20'),(33,29,22,4,'What a nice movie to watch with family!','2024-12-21 12:52:16'),(34,20,22,5,'best movie ever!','2024-12-21 12:56:30');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_movie_selections`
--

DROP TABLE IF EXISTS `user_movie_selections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_movie_selections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `movie_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `user_movie_selections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_movie_selections_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_movie_selections`
--

LOCK TABLES `user_movie_selections` WRITE;
/*!40000 ALTER TABLE `user_movie_selections` DISABLE KEYS */;
INSERT INTO `user_movie_selections` VALUES (18,19,29),(19,19,53),(20,19,50),(21,19,32),(22,19,52),(23,19,1),(24,19,25),(25,19,3),(26,19,19),(27,20,29),(28,20,53),(29,20,55),(30,20,50),(31,20,30),(32,20,24),(33,20,61),(34,20,34),(35,20,1),(36,20,47),(45,22,29),(46,22,53),(47,22,55),(48,22,50),(49,22,30),(50,22,32),(51,22,44),(52,22,52),(53,22,24),(54,22,45),(55,23,59),(56,23,40),(57,23,12),(58,23,11),(59,23,49),(60,23,51),(61,23,4),(62,23,37),(72,25,29),(73,25,53),(74,25,55),(75,25,50),(76,25,30),(77,25,32),(78,25,44),(79,25,24),(80,25,61),(81,26,29),(82,26,53),(83,26,55),(84,26,50),(85,26,30),(86,26,32),(87,26,44),(88,26,52),(89,27,29),(90,27,32),(91,27,33),(92,27,9),(93,27,6),(94,27,36),(95,27,34),(96,27,25),(97,28,29),(98,28,53),(99,28,55),(100,28,50),(101,28,30),(102,28,32),(103,28,44),(104,29,29),(105,29,66),(106,29,24),(107,29,72),(108,29,33),(109,29,63),(110,29,36),(111,29,17),(112,29,34),(113,29,70);
/*!40000 ALTER TABLE `user_movie_selections` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'admin','admin@example.com','$2y$10$Dznp4v5lQCUu.bqtMuCL3.lfqZtVc3CjlQ.Isj3Jl9XyHV6e1aKmW','admin',NULL,'2024-12-06 16:25:32','2024-12-06 16:25:32'),(19,'melis','melis@gmail.com','$2y$10$U9Qc5dbUS7gyHicVcLoPYOftEOkmlTrIJQH69MOQ.u/R4DoxpO.LO','user',NULL,'2024-12-12 18:18:03','2024-12-15 16:41:00'),(20,'asude','asude@gmail.com','$2y$10$pjwBxq.Ebc2KUdt5aj5Ty.RQD3wE2Osz9mYpr1G2Psrq.GKWbsFja','user',NULL,'2024-12-12 19:08:09','2024-12-12 19:08:09'),(22,'derya1','derya1@gmail.com','$2y$10$JH.b9KF/vLiTPHO1NMWSdeHUUpkoC7UNe3nBJlnBJeXUmBxNyTpgW','user',NULL,'2024-12-13 17:30:20','2024-12-13 17:30:20'),(23,'irem','irem@gmail.com','$2y$10$IXFY2Ivay2cRwq82gG4vHOy206lEJksHsx2rFQhDBDp3abGKKPv16','user',NULL,'2024-12-15 15:35:07','2024-12-15 15:35:07'),(25,'doğa','doga@gmail.com','$2y$10$qZlN/Q372URX9iYUZcTJmuvUzbnLuas8.6YkEfIh757XRtuz3mypi','user',NULL,'2024-12-16 08:37:16','2024-12-16 08:37:16'),(26,'deneme1','deneme1@gmail.com','$2y$10$DNvP2GB3NOzRkM8h0IO9p./TcunLPr52HofIGZF4dWQjgggNn72Fe','user',NULL,'2024-12-16 09:59:50','2024-12-16 09:59:50'),(27,'lili','lili@gmail.com','$2y$10$C/bqhHzuwPr9nHcPGa4et.nvQv/miPt5YnH8d1kk979RVL0dQQ5e.','user',NULL,'2024-12-21 10:11:55','2024-12-21 10:11:55'),(28,'deneme3','deneme3@gmail.com','$2y$10$NuRyRunggRjyd2OhlBWOIu588tZExGMeiO44Bo1r32aoWWhbJLHK6','user',NULL,'2024-12-21 10:40:49','2024-12-21 10:40:49'),(29,'deneme 4','deneme4@gmail.com','$2y$10$.YItWn3YyTVJDmcbSfxmWustJU8SAtX9peuhGt.BemHnvE9GpTZ5W','user',NULL,'2024-12-21 12:51:16','2024-12-21 12:51:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watchlist`
--

LOCK TABLES `watchlist` WRITE;
/*!40000 ALTER TABLE `watchlist` DISABLE KEYS */;
INSERT INTO `watchlist` VALUES (35,19,16,'2024-12-12 18:21:47'),(36,19,26,'2024-12-12 18:21:54'),(37,19,22,'2024-12-12 18:22:01'),(38,19,23,'2024-12-12 19:05:33'),(39,20,17,'2024-12-12 19:08:24'),(40,22,7,'2024-12-13 17:30:53'),(41,22,15,'2024-12-13 17:32:20'),(43,19,34,'2024-12-15 13:51:53'),(44,19,52,'2024-12-15 13:54:44'),(45,25,23,'2024-12-16 08:37:40'),(46,26,13,'2024-12-16 10:00:20'),(47,27,23,'2024-12-21 10:12:46'),(48,20,8,'2024-12-21 12:55:19');
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

-- Dump completed on 2024-12-21 19:06:12
