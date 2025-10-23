CREATE DATABASE  IF NOT EXISTS `sergiodaw` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sergiodaw`;
-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: sergiodaw
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `pdaw_aves`
--

DROP TABLE IF EXISTS `pdaw_aves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_aves` (
  `especie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `familia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comun` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingles` varchar(59) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default.jpg',
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`especie`),
  KEY `fk_familia_familias` (`familia`),
  CONSTRAINT `fk_familia_familias` FOREIGN KEY (`familia`) REFERENCES `pdaw_familias` (`familia`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Especies de aves objeto de censo registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_aves`
--

LOCK TABLES `pdaw_aves` WRITE;
/*!40000 ALTER TABLE `pdaw_aves` DISABLE KEYS */;
INSERT INTO `pdaw_aves` VALUES ('Calidris Alba','Scolopacidae','CALALB','Correlimos Tridáctilo','Sanderling','default.png','https://seo.org/ave/correlimos-tridactilo/'),('Gavia Stellata','Gaviidae','GAVSTE','Colimbo Chico','Red-throated Loon','default.png','https://seo.org/ave/colimbo-chico/'),('Geronticus Eremita','Threskiornithidae','GERERE','Ibis Eremita','Northern Bald Ibis','default.jpg','https://seo.org/ave/ibis-eremita/'),('Platalea Leurocodia','Threskiornithidae','PLALEU','Espátula Común','Eurasian Spoonbill','default.jpg','https://seo.org/ave/espatula-comun/'),('Plegadis Falcinellus','Threskiornithidae','PLEFAL','Morito Común','Glossy Ibis','default.jpg','https://seo.org/ave/morito-comun');
/*!40000 ALTER TABLE `pdaw_aves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_censos`
--

DROP TABLE IF EXISTS `pdaw_censos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_censos` (
  `id_jornada` int unsigned NOT NULL,
  `especie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` time NOT NULL,
  `cantidad` int unsigned NOT NULL,
  `nubosidad` enum('Ninguno','10','20','30','40','50','60','70','80','90','100','Desconocido') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibilidad` enum('0','1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dirViento` enum('SIN','N','NE','E','SE','S','SO','O','NO','VAR','DES') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `velViento` enum('0','1','2','3','4','5','6','7','8','9','10') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `procedencia` enum('N','NE','E','SE','S','SO','O','NO','DES') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `destino` enum('N','NE','E','SE','S','SO','O','NO','DES') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `altVuelo` enum('0','1','2','3','4','5','6') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `formaVuelo` enum('LINHOR','LINVER','VSI','VAS','AMO','OTR') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `distCosta` enum('DBO','BO','LMA','FR','CAN','MED','HOR') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_jornada`,`especie`,`hora`),
  KEY `fk_especie_censos` (`especie`),
  CONSTRAINT `fk_especie_censos` FOREIGN KEY (`especie`) REFERENCES `pdaw_aves` (`especie`) ON UPDATE CASCADE,
  CONSTRAINT `fk_idjornada_censos` FOREIGN KEY (`id_jornada`) REFERENCES `pdaw_jornadas` (`id_jornada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Datos censales registrados en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_censos`
--

LOCK TABLES `pdaw_censos` WRITE;
/*!40000 ALTER TABLE `pdaw_censos` DISABLE KEYS */;
INSERT INTO `pdaw_censos` VALUES (2,'Geronticus Eremita','10:59:59',7,'60','2','S','4','SE','NO','3','LINHOR','FR','Joe pisha el bando de las 11:00 que ya tenia todo recogido!!'),(2,'Platalea Leurocodia','09:00:00',100,'10','3','O','1','NE','SO','3','VAS','BO','Killo! Estas no pasan en verano... Ojú la resaca de navidad'),(2,'Plegadis Falcinellus','09:45:00',10,'20','3','NO','2','N','E','3','AMO','FR','Los moritos de campo de golf killo!! no han tomado el pelo'),(3,'Gavia Stellata','21:50:36',1000,'10','3','O','1','NO','SO','1','LINHOR','DBO','Esto es una prueba para pasar la jornadas al históricos y luego proceder a cancelarla'),(7,'Calidris Alba','20:30:29',25,'Ninguno','4','SIN','0','N','S','0','OTR','FR','Esto es una prueba para la tarea3/4 del proyecto....'),(7,'Calidris Alba','20:48:34',35,'Ninguno','3','O','1','DES','DES','0','OTR','FR','Estan en un estero picoteando en el limo mientras juegan al baloncesto, vamos como yo les digo, pues el soniquete que hacen mientras se alimentan es muy similiar al sonidos de los zapatos deprotivos en una cancha de baloncesto.'),(7,'Platalea Leurocodia','20:43:53',5,'Ninguno','0','SIN','0','DES','DES','0','OTR','FR','Esto es seguro en la Salina Santa Teresa donde suelen anidar todos lo años....'),(9,'Calidris Alba','21:55:57',1,'Ninguno','0','SIN','0','N','N','0','LINHOR','DBO','Probando finalizar jornada desde el histórico....');
/*!40000 ALTER TABLE `pdaw_censos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_familias`
--

DROP TABLE IF EXISTS `pdaw_familias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_familias` (
  `familia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripción` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codOrden` int unsigned NOT NULL,
  PRIMARY KEY (`familia`),
  KEY `fk_codorden_orden` (`codOrden`),
  CONSTRAINT `fk_codorden_orden` FOREIGN KEY (`codOrden`) REFERENCES `pdaw_ordenes` (`codOrden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Faamilias de aves registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_familias`
--

LOCK TABLES `pdaw_familias` WRITE;
/*!40000 ALTER TABLE `pdaw_familias` DISABLE KEYS */;
INSERT INTO `pdaw_familias` VALUES ('Accipitridae','Aves de tamaño pequeño, mediano y grande. Tienen pico corto, fuerte y muy curvado; la mandíbula superior tiene diente redondeado, y la inferior con muesca en el lugar correspondiente. Las fosas nasales están situadas en un abultamiento situado en la base del pico llamado \"cera\". Cabeza plana en la parte superior, con los ojos situados lateralmente. Alas anchas. Patas robustas con tarsos emplumados hasta los dedos; pies con poderosas garras con uñas largas, curvas y aceradas. La hembra es de mayor tamaño. La mayoría son aves depredadoras que se alimentan de animales vivos; algunas especies se nutren de carroña.',9),('Aegithalidae','Pájaros pequeños de cola muy larga. Pico muy pequeño. Son muy activos y tienden a formar grupos fuera de la época de cría, a veces mixtos con páridos, familia en la que estuvieron englobados años atrás. Alimentación basada en insectos y larvas. Una sola especie nidifica en España.',22),('Alaudidae','Aves terrestres de tamaño pequeño. Pico de mediana longitud, recto y generalmente cónico. El dedo pulgar generalmente tiene la uña larga y bastante recta. Plumaje críptico en tonos pardos. Ambos sexos tienen parecido el plumaje, pero las hembras son más pequeñas. Muchas especies tienen canto agradable, con frecuencia entonado desde el aire. Con frecuencia forman bandos fuera de la época de cría',22),('Alcedinidae','Aves de tamaño mediano-pequeño y cuerpo rechoncho. Cuello corto, cabeza grande y potente pico. Alas cortas y redondeadas adaptadas para la inmersión. La cola y los tarsos son igualmente cortos. Vuelo muy rápido y directo.',20),('Anatidae','Aves acuáticas. Poseen pico ancho (excepto en el caso de las serretas), con una placa córnea en el extremo llamada \"uña\". El borde de las mandíbulas está revestido por unas pequeñas láminas que actúan como filtro, reteniendo el alimento y dejando salir el agua. Cuello largo. Cola corta. Las patas tienen 4 dedos: 3 anteriores (unidos por membrana interdigital) y 1 posterior situado más alto. Tras la muda estival pierden durante un tiempo la capacidad de volar, pues reemplazan todas las remeras a la vez. Algunos patos se alimentan parcialmente en tierra, y los gansos son eminentemente terrestres.',1),('Apodidae','Aves de tamaño pequeño. Pico corto y boca ancha adaptada a la caza de insectos en vuelo. Alas largas, estrechas y curvadas que les dotan de veloz vuelo. Cola corta bifurcada. Las patas presentan tarsos cortos y emplumados, con los 4 dedos desnudos y dirigidos hacia delante. Piel gruesa. Son aves aéreas que descansan en superficies verticales, pero nunca se posan en el suelo. Son migradoras.',19),('Ardeidae','Aves de tamaño mediano a grande. Poseen cuello, patas y pico largos, este último cónico. Alas anchas y redondeadas. Cola redondeada. Vuelan pausadamente con el cuello contraído en forma de \"S\" y las patas extendidas. Nidifican en colonias.',7),('Bombycillidae','Una sola especie en Europa, ocasional en España. Aves arbóreas de tamaño pequeño y cuerpo rechoncho, con el pico, las alas y las patas cortas. La cabeza está coronada por una cresta conspicua. Sexos parecidos. Posan con postura erguida, y están dotadas de vuelo rápido y de trayectoria recta. Condición gregaria, sobre todo durante el invierno. Generalmente son pájaros poco asustadizos.',22),('Burhinidae','Aves terrestres de tamaño mediano. Tienen pico corto, recto y fuerte. Cabeza y ojos grandes. Alas largas. Cola cuneada. Patas largas y rodillas robustas; el pie tiene 3 dedos dirigidos hacia delante, y están unidos por una membrana en la base. Tienen carácter tímido. Se alimenta principalmente de noche. Ambos sexos son iguales.',12),('Caprimulgidae','Aves de tamaño pequeño-mediano de costumbres crepusculares y nocturnas. Cabeza grande, ancha y plana. Pico corto y boca muy ancha adaptada a la caza de insectos en vuelo. Ojos grandes. Alas largas y puntiagudas. Cola larga y redondeada. Tarsos muy cortos y emplumados, y el pie tiene 3 dedos hacia delante (el central con la uña más larga y dentada) y 1 hacia detrás. Plumaje suave y mimético. Piel muy fina y blanda. En vuelo se muestran silenciosos y erráticos.',18),('Certhiidae','Pájaros arbóreos de tamaño pequeño. Pico largo, delgado y curvado. Alas de longitud mediana y redondeadas. Cola larga, rígida y con ápices puntiagudos que ayudan al pájaro a trepar. No hay dimorfismo sexual. Se alimentan de insectos y arañas.',22),('Charadriidae','Aves de tamaño mediano y pequeño. Tienen pico corto y recto, cabeza grande y redondeada, cuello corto y ojos grandes; cuerpo rechoncho. Los chorlitos tienen las alas largas y puntiagudas, y el pie sólo tiene 3 dedos dirigidos hacia delante. Las avefrías tienen las alas muy anchas y redondeadas, y el pie tiene dedo pulgar, que es pequeño y está situado más alto.',12),('Ciconiidae','Aves de tamaño grande. Poseen cuello, patas y pico largos, este último cónico. Las plumas inferiores del cuello son más alargadas. Alas anchas. Cola redondeada. Vuelan con el cuello y las patas extendidos.',7),('Cinclidae','Aves acuáticas de tamaño pequeño y cuerpo rechoncho. Alas cortas y redondeadas. Cola corta. Patas largas. Nadan y bucean, y son capaces de andar por debajo del agua. Una sola especie nidifica en Europa.',22),('Columbidae','Aves de tamaño mediano-pequeño con cuerpo rechoncho y cabeza pequeña. Pico débil, recto con la punta curvada y con un abultamiento en la base (llamado \"cera\") en el que se alojan las fosas nasales. Alas largas y fuertes que proporcionan un vuelo rápido. Cola larga cuadrada o redondeada. Tarsos cortos. Presentan pies con 4 dedos, 3 hacia delante y 1 hacia atrás. Caminan a pasos. Se alimentan de semillas y fruta.',14),('Coraciidae','Aves de tamaño mediano y aspecto rechoncho. Pico fuerte, cabeza grande, alas largas y puntiagudas, cuello y patas cortos. Cola larga, cuadrada, y con las 2 rectrices externas más largas (que le dan aspecto de bifurcada).',20),('Corvidae','Aves de tamaño mediano y grande, de costumbres terrestres. Es el grupo de mayor tamaño del orden passeriformes. Tienen las patas y el pico fuertes, este último bastante largo, algo curvo y con cerdas en la base. Ambos sexos tienen el mismo plumaje, y los jóvenes son parecidos a los adultos. Plumajes muy variados que van desde el enteramente negro del cuervo al vivamente coloreado del arrendajo. Alimentación omnívora.',22),('Cuculidae','Aves de tamaño mediano-grande. Silueta esbelta con alas largas y puntiagudas. Pico ligeramente decurvado. Cola larga. Tarsos cortos. El pie presenta 2 dedos dispuestos hacia delante y los otros 2 hacia atrás. Presenta la piel muy fina y blanda. Son especies parásitas.',16),('Emberizidae','Aves terrestres de tamaño pequeño. Pico corto y cónico típico de las especies granívoras. A excepción de Triguero, todas las especies son dimórficas. Los nidos tienen forma de cuenco, y son construidos por las hembras.',22),('Estrildiidae','Sin datos decriptivos.',22),('Falconidae','Aves de tamaño pequeño a mediano. Tienen pico corto y curvado, con diente afilado en la mandíbula superior y una muesca en el lugar correspondiente de la inferior. Las fosas nasales están situadas en un abultamiento situado en la base del pico llamado \"cera\". Cabeza grande y plana en la parte superior, con los ojos situados lateralmente. Alas largas y puntiagudas. Cola de mediana longitud, estrecha y redondeada. Patas robustas con tarsos desnudos; pies con fuertes garras y dedos largos. Son aves de vuelo rápido. La hembra es de mayor tamaño.',10),('Fringillidae','Pájaros de tamaño pequeño. Presentan pico corto y cónico. Algunas especies son dimórmicas. Tienen alimentación mixta, aunque las semillas constituyen un porcentaje importante en su dieta. Plumajes de coloridos discretos con mayoría de tonos pardos y grises.',22),('Gaviidae','Aves marinas de tamaño grande y pico estrecho y cónico. Cuello bastante largo. Cuerpo alargado. Las alas son pequeñas y puntiagudas, y están colocadas muy atrás. Cola corta. Patas cortas y colocadas de igual modo muy atrás (disposición que favorece el buceo). Los tarsos son planos. Pies con 4 dedos, 3 dispuestos hacia delante (y unidos por membrana interdigital) y el pulgar (más pequeño) hacia atrás y situado más alto. Son excelentes nadadoras y buceadoras, pero muy torpes en tierra, donde tienen que ayudarse con frecuencia de las alas. Cuando nadan sumergen bastante el cuerpo. En vuelo llevan las patas extendidas y el cuello extendido hacia abajo.',3),('Glareolidae','Aves terrestres de tamaño pequeño y mediano. Los corredores tienen el pico largo y curvado en la punta. Cuello corto. Alas puntiagudas. Cola corta y redondeada. Patas largas y delgadas; el pie tiene 3 dedos dirigidos hacia delante, el interior más largo y con el borde interior de la uña dentado. Las canasteras se asemejan a las golondrinas de mar. Poseen pico corto. Las alas son muy largas y puntiagudas. Cola ahorquillada. Las patas tienen 4 dedos; el dedo central tiene el borde interior de la uña dentado.',12),('Gruidae','Aves terrestres de tamaño grande, con el cuello y las patas largas. Pico recto y puntiagudo. Son similares a las cigüeñas y garzas, aunque no están emparentadas. Tienen las alas anchas, y las plumas secundarias son muy alargadas y cuelgan sobre la cola. Vuelan con las patas y el cuello extendidos, este último inclinado hacia abajo. Durante la migración vuelan en formación en \"V\" o en línea.',11),('Haematopodidae','Aves de tamaño mediano. Tienen pico largo, recto, fuerte y comprimido lateralmente. Cuello corto. Alas largas y puntiagudas. Cola corta. Patas robustas; el pie tiene 3 dedos dirigidos hacia delante, y están unidos por una membrana en la base.',12),('Hirundinida','Aves esbeltas de tamaño pequeño y gran dominio aéreo. Pico corto, triangular y plano; boca muy ancha adaptada para la caza de insectos en vuelo. Alas muy largas. Cola escotada o ahorquillada. Tarsos cortos y débiles. Son especies gregarias y migradoras.',22),('Laniidae','Pájaros de tamaño mediano. Presentan la cabeza grande y pico fuerte y ganchudo. Alas cortas. Cola larga, redondeada o escalonada. Especies depredadoras que se alimentan de insectos, pequeñas aves, roedores. Tienen la costumbre de empalar a sus presas en las púas de los espinos. Tienen carácter agresivo y solitario. En vuelo describen pauta ondulada',22),('Laridae','Aves acuáticas de tamaño mediano y pequeño. Grandes dominadoras del aire. Alas largas y puntiagudas. Pies palmeados, y el pulgar es pequeño y no tiene membrana. Son aves gregarias que frecuentan aguas marinas y del interior. Las golondrinas de mar son aves de pico estrecho y puntiagudo. Cola ahorquillada. Patas cortas con pies pequeños. La gaviotas son aves de mayor tamaño que las anteriores. El pico presenta la mandíbula superior con la punta curvada. Las alas son largas y estrechas. Cola cuadrada o redondeada. Patas y pies mayores que los del grupo anterior. Son buenas nadadoras, y en tierra andan con el cuerpo bastante horizontal. El macho suele ser de tamaño superior.',12),('Meropidae','Aves muy estilizadas, con las alas largas, puntiagudas y triangulares. Cola redondeada, con las dos rectrices centrales más largas. Pico largo y algo decurvado. Piel fina y dura. Alimentación insectívora, basada en abejas y avispas.',20),('Motacillidae','Aves terrestres de tamaño pequeño y cola más o menos larga, que con frecuencia mueven. Patas largas. Tendencia gregaria fuera de la época de cría. Se alimentan fundamentalmente de insectos y arañas. Los bisbitas son de tonalidades pardas, tienen los dedos largos y con la uña del pulgar larga o muy larga y aguda; ambos sexos son iguales. Las lavanderas tienen el plumaje más definido, con colores más variados y diferencias de plumaje en macho y hembra.',22),('Muscicapidae','Aves de tamaño pequeño y pico corto y ancho en la base adaptado para la caza de insectos en vuelo. Alas largas. Patas cortas y débiles. Se posan con el cuerpo muy erguido. En el suelo andan con dificultad. Alimentación exclusiva de insectos y arañas. Las 2 especies que habitan en España son migradoras.',22),('Oriolidae','Aves arbóreas de tamaño mediano. Presentan pico fuerte, alas largas y tarsos cortos. Los sexos presentan plumajes distintos, vivamente coloreado en el macho. Sólo una especie cría en Europa.',22),('Otididae','Aves terrestres grandes, de cuello largo y grueso, y pico corto. Alas largas y anchas. Patas largas y robustas; el pie sólo tiene 3 dedos, anchos y dispuestos hacia delante (adaptados a la carrera). En vuelo llevan las alas y el cuello extendidos.',11),('Pandionidae','Una especie con distribución mundial. Ave de tamaño grande. Alas largas y anguladas. Ambos sexos tienen plumaje similar. Las patas tienen 4 dedos, y el externo es reversible; las plantas de los pies son espinosas para facilitar la captura de peces. Alimentación piscívora (casi exclusiva).',9),('Paridae','Pájaros arbóreos de tamaño pequeño. Son especies muy activas que con frecuencia se cuelgan acrobáticamente de las ramas. Tienen el pico corto y las alas redondeadas. Fuera de la época de cría suelen formar grupos mixtos con otras especies, sobre todo con mitos y agateadores.',22),('Passeridae','Pájaros de tamaño pequeño. Presentan pico corto y cónico. Algunas especies son dimórmicas. Tienen alimentación mixta, aunque las semillas constituyen un porcentaje importante en su dieta. Plumajes de coloridos discretos con mayoría de tonos pardos y grises.',22),('Pelecanidae','Aves acuáticas de tamaño muy grande. Sexos semejantes. Tienen el pico muy grande con una voluminosa bolsa debajo del mismo, alas largas y anchas, cola corta y pies palmeados. Capaces de pescar bien desde la superficie del agua bien zambulléndose desde el aire. Son gregarias para pescar, anidar y migrar.',6),('Phalacrocoracidae','Aves acuáticas de tamaño grande. Cuerpo alargado y cabeza pequeña. Pico largo y estrecho, con la punta en forma de gancho. Cola larga y escalonada. Alas cortas y puntiagudas. Los pies presentan los 4 dedos dispuestos hacia delante y unidos por membrana. Vuelan con el cuello y las patas extendidos, en formación lineal o en \"V\". Frecuentan áreas costeras y aguas del interior. Realizan zambullidas, y crían en colonias.',6),('Phasianidae','Tienen el pico corto y fuerte. Alas cortas y redondeadas. Patas robustas que emplean en la carrera y para escarbar en la tierra. Los pies tienen 4 dedos, 3 dispuestos hacia delante y unidos en la base por una pequeña membrana, y el pulgar situado más alto adopta en los machos aspecto de espolón o protuberancia roma. Excepto el faisán, presentan la cola más o menos corta.',2),('Phoenicopteridae','Aves acuáticas de cuello y patas muy largos. Pico muy grande, y decurvado hacia la parte central. Los pies tienen los 3 dedos delanteros unidos por membrana, y el posterior es muy pequeño y está situado más alto. Son aves muy gregarias.',8),('Picidae','Los pícidos son aves zigodáctilas, es decir, que tienen dos dedos dispuestos hacia adelante y dos hacia atrás. Gracias a esta disposición pueden trepar más fácilmente por los troncos y las ramas de los árboles. Los huesos del cráneo y el pico están soldados entre sí formando una envoltura homogénea que protege al cerebro, evitando cualquier posible daño al realizar los violentos golpeos contra la madera. Además, tienen otra serie de rasgos que les diferencian de las demás especies, tales como la larga lengua con la que extraen el alimento y la cola de plumas rígidas y puntiagudas que suponen un importante punto de apoyo a la hora de trepar. Alas redondeadas y vuelo ondulante. La diferenciación sexual se observa en el colorido del plumaje de la cabeza. El torcecuello tiene el plumaje suave y la cola redondeada, que no utiliza para trepar. Además, el pico no es tan poderoso como el del resto de los pícidos.',21),('Podicipedidae','Aves acuáticas de tamaño pequeño a mediano. Pico recto y puntiagudo. Cuerpo alargado y rechoncho. Alas bastante pequeñas. Cola muy corta, tanto que parecen no tener. Las patas, que son cortas, están colocadas muy atrás, esta disposición facilita el buceo, no así el andar en tierra que lo hacen de forma dificultosa y con el cuerpo erguido; tarsos planos; los pies tienen 3 dedos lobulados dirigidos hacia delante y el pulgar rodeado por un borde membranoso; uñas anchas y planas. Nadan con el cuerpo bastante sumergido y el cuello erguido. Vuelan con el cuello extendido e inclinado hacia abajo. Las plumas de los flancos forman una especie de bolsas, donde guardan a los polluelos durante los primeros días de vida; después, los llevan en la espalda.',4),('Procellariidae','Aves acuáticas de tamaño pequeño a mediano. Pico recto y puntiagudo. Cuerpo alargado y rechoncho. Alas bastante pequeñas. Cola muy corta, tanto que parecen no tener. Las patas, que son cortas, están colocadas muy atrás, esta disposición facilita el buceo, no así el andar en tierra que lo hacen de forma dificultosa y con el cuerpo erguido; tarsos planos; los pies tienen 3 dedos lobulados dirigidos hacia delante y el pulgar rodeado por un borde membranoso; uñas anchas y planas. Nadan con el cuerpo bastante sumergido y el cuello erguido. Vuelan con el cuello extendido e inclinado hacia abajo. Las plumas de los flancos forman una especie de bolsas, donde guardan a los polluelos durante los primeros días de vida; después, los llevan en la espalda.',5),('Prunellidae','Aves de tamaño pequeño parecidas a los gorriones, pero con el pico grácil. Las alas son redondeadas, y los tarsos cortos. En el suelo caminan con el cuerpo muy agachado y horizontal. Alimentación granívora e insectívora.',22),('Psittacidae','Sin datos descriptivos.',15),('Pteroclidae','Aves de tamaño mediano-pequeño con cuerpo rechoncho y cabeza pequeña. Pico corto. Cuello corto. Alas largas y puntiagudas. Cola larga cuneiforme o puntiaguda. Tarsos cortos y emplumados. El pie tiene el dedo posterior atrofiado.',13),('Rallidae','Aves de tamaño pequeño y mediano. Cuerpo estrecho que les permite desenvolverse con soltura entre la abundante vegetación. Alas cortas y redondeadas. Cola corta, que a menudo llevan levantada. Tarsos largos, y los pies con los dedos muy largos, lobulados en las fochas, adecuados para andar sobre las plantas acuáticas. En vuelo dejan colgar las patas.',11),('Recurvirostridae','Aves de tamaño grande y cabeza pequeña. Cuello largo. Tienen pico muy largo y recto (cigüeñuelas) o curvado hacia arriba (avocetas). Las patas son largas (avocetas) o muy largas (cigüeñuelas). Las cigüeñuelas tienen 3 dedos dirigidos hacia delante y unidos por una membrana. Las avocetas tienen además dedo posterior, que es muy pequeño y está colocado más alto.',12),('Remizidae','Aves de tamaño pequeño y pico fino y puntiagudo. En comportamiento se parecen mucho a los Páridos, con quienes están emparentados. Una sola especie presente en España.',22),('Scolopacidae','Aves de tamaño pequeño a grande. Tienen pico generalmente largo y fino. Alas puntiagudas. En esta familia se agrupan especies muy diferentes tanto anatómica como biológicamente. Los correlimos son aves pequeñas de pico fino y recto o ligeramente curvado, cola cuadrada; las hembras son más grandes que los machos y tienen el pico más largo. Los combatientes tienen el pico parecido a los correlimos, con la base cubierta de plumas cortas; el macho es de mayor tamaño, y el plumaje es muy distinto en verano e igual en invierno. Las agachadizas y las chochas son aves de tamaño mediano o pequeño, pico muy largo y ojos situados muy altos y hacia la parte posterior del cráneo. La cola es corta, redondeada o cuneada. Las chochas tienen la tibia emplumada; las agachadizas tienen la parte inferior desnuda; son de costumbres crepusculares y nocturnas. Las agujas tienen el pico muy largo y levemente curvado hacia arriba, alas largas y puntiagudas, cola cuadrada, patas largas con la parte inferior de la tibia desnuda. Los zarapitos son limícolas de tamaño mediano o grande, con el pico muy largo y decurvado; alas largas y cola redondeada, patas largas, con la parte inferior de la tibia desnuda. Los archibebes y andarríos son aves de tamaño pequeño y mediano que tienen el pico largo y puntiagudo; el cuello y las patas son largos, con alas largas y puntiagudas, cola redondeada o cuadrada. Los vuelvepiedras son aves pequeñas que tienen el pico relativamente corto, recio, puntiagudo y ligeramente curvado hacia arriba. Las patas son cortas y fuertes.',12),('Sittidae','Aves de tamaño pequeño. Pico largo, fuerte y recto. Cuello y patas cortos; los pies son fuertes, muy desarrollados con largos dedos. La cola también es corta, ancha y redondeada. Las alas son largas y puntiagudas. Al trepar no se ayudan de la cola.',22),('Sternidae','Aves acuáticas de tamaño pequeño y mediano que tienen el aspecto de gaviotas estilizadas. Ambos sexos son semejantes. Tienen el pico puntiagudo, fino y carente de punta ganchuda. Tienen las alas más estrechas que las gaviotas, la cola bifurcada y las patas cortas, con los pies palmeados. En el aire se caracterizan por tener un vuelo boyante, realizando frecuentes cernidos sobre el agua. Algunos miembros (pagazas y charranes) se zambullen en el agua.',12),('Strigidae','Aves depredadoras de tamaño pequeño a grande. Tienen la cabeza grande, cara aplanada y ojos dirigidos hacia delante. Pico muy curvo y poco saliente. En la cara presentan disco facial. Cuello bastante largo, aunque lo llevan muy contraído. Pueden girar la cabeza 360o sin cambiar la posición del cuerpo. Tarsos cortos y emplumados; pie con 4 dedos, el exterior puede dirigirse hacia delante o hacia atrás. Las alas son largas, anchas y redondeadas. Plumaje muy suave y suelto, a causa de ello tienen vuelo muy silencioso. Algunas especies presentan penachos auriculares. La hembra es de mayor tamaño que el macho. Son de actividad preferentemente nocturna, aunque algunos pueden cazar con pleno sol. El alimento lo tragan entero, devolviendo al cabo del tiempo las materias no digeribles (huesos, pelos) en forma de bolas llamadas egagrópilas. Alguna especie es migradora.',17),('Sturnidae','Aves de tamaño mediano-pequeño y cuerpo rechoncho. Tienen el pico largo, recto y cónico. Las alas son cortas y puntiagudas. Cola corta y cuadrada. Alimentación omnívora. Vuelo rápido de trayectoria recta. Nidifican en oquedades. Fuera de la época de cría son gregarios.',22),('Sylviidae','Pájaros arbóreos de tamaño pequeño, cuerpo esbelto y pico fino. Son muy activos. Plumajes de colores discretos basados principalmente en tonos pardos, verdes o grises. Dimorfismo sexual en las currucas. Alimentación basada en insectos y arañas. Algunos destacan por el canto. Muchas especies son migradoras.',22),('Tetraonidae','Aves de tamaño grande y mediano. Tienen el pico corto y fuerte. Alas cortas y redondeadas. Patas robustas con tarsos emplumados. Carecen de espolones. En vuelo baten con fuerza las alas seguido por planeos.',2),('Threskiornithidae','Aves acuáticas de tamaño mediano a grande. Poseen cuello y patas largos. Pico largo, recto, plano y con la punta espatulada (espátulas) o decurvado (moritos). Vuelan con el cuello y las patas extendidas. Nidifican en colonias, a menudo mixtas con garzas.',7),('Tichodromadidae','Pájaros de tamaño pequeño. Tienen caracteres compartidos con agateadores y trepadores. De los primeros tiene el pico, que es largo, fino y decurvado. A los trepadores se les parece en que al trepar no se ayudan de la cola.',22),('Troglodytidae','Aves de tamaño pequeño y cuerpo rechoncho. Las alas son cortas y redondeadas. La cola también es corta, y casi siempre la llevan levantada. Ambos sexos tienen el mismo plumaje. Son pájaros de carácter solitario, y con frecuencia polígamos. Esta familia está representada en Europa por una sola especie.',22),('Turdidae','Aves de tamaño mediano-pequeño y cuerpo esbelto. Pico de longitud media y más o menos grácil. Los tarsos son fuertes y más bien largos. En su conjunto destacan por su calidad canora. Muchas de las especies son migradoras.',22),('Tytonidae','Aves depredadoras de tamaño mediano. Tienen la cabeza grande, cara aplanada y ojos dirigidos hacia delante. Pico muy curvo y poco saliente. En la cara presentan disco facial en forma de corazón. Cuello bastante largo, aunque lo llevan muy contraído. Pueden girar la cabeza 360o sin cambiar la posición del cuerpo. Tarsos largos y emplumados; pie con 4 dedos, el exterior puede dirigirse hacia delante o hacia atrás. Las alas son largas, anchas y redondeadas. Cola corta. Plumaje muy suave y suelto, a causa de ello tienen vuelo muy silencioso. La hembra es de mayor tamaño que el macho. Son de actividad preferentemente nocturna, aunque con frecuencia se le observa en los crepúsculos. El alimento lo tragan entero, devolviendo al cabo del tiempo las materias no digeridas (huesos, pelos) en forma de bolas llamadas egagrópilas',17),('Upupidae','Aves de tamaño mediano. Las abubillas son aves en las que destaca el penacho de plumas eréctiles a modo de cresta. El plumaje es un contraste entre el pardo anaranjado general y el barrado de negro y blanco de las alas y cola. Alas largas, anchas y redondeadas. Cola cuadrada. Tarsos cortos. Tiene la piel muy blanda y fina. Pauta de vuelo muy ondulado.',20);
/*!40000 ALTER TABLE `pdaw_familias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_jornadas`
--

DROP TABLE IF EXISTS `pdaw_jornadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_jornadas` (
  `id_jornada` int unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `informacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `estado` enum('PUBLICADA','ABIERTA','CERRADA','CANCELADA','VALIDADA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asistencia` tinyint(1) DEFAULT '0',
  `observatorio` int unsigned NOT NULL,
  PRIMARY KEY (`id_jornada`),
  KEY `fk_jornadas_observatorios` (`observatorio`),
  CONSTRAINT `fk_jornadas_observatorios` FOREIGN KEY (`observatorio`) REFERENCES `pdaw_observatorios` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jornadas censales registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_jornadas`
--

LOCK TABLES `pdaw_jornadas` WRITE;
/*!40000 ALTER TABLE `pdaw_jornadas` DISABLE KEYS */;
INSERT INTO `pdaw_jornadas` VALUES (1,'Marismas del Marambay','2025-01-06','09:00:00','14:00:00','Killo pisha que es día de Reyes mi mujer me destierra','CANCELADA',0,1),(2,'Marismas Carboneros','2025-01-12','08:00:00','11:00:00','El cafe con churros esta prohibido<br><<--- El usuario administrador Pelostaticos ha validado la jornada a las: 07-05-2025 21:18:06','VALIDADA',1,2),(3,'Marinas en la Torre de Tajo','2025-05-07','09:00:00','12:00:00','Llevarse algo para pricar y ropa abrigo<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 07-05-2025 21:49:40<br><<--- El usuario responsable Pelostaticos cancelar esta jornada por los motivos: Esto es una prueba para ver el funcionamiento de la cancelación de jornadas desde el historico...','CANCELADA',0,3),(7,'Espátulas en el Cuartel del Mar','2025-05-07','08:00:00','13:00:00','Presentación al voluntariado del proyecto de la Plataforma Correplayas<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 04-05-2025 20:40:21<br><<--- El usuario responsable Pelostaticos ha finalizado la jornada a las: 07-05-2025 21:12:39<br><<--- El usuario administrador Pelostaticos ha validado la jornada a las: 07-05-2025 21:17:44','VALIDADA',1,2),(8,'Jornada prueba gestor censos','2025-05-07','08:00:00','13:00:00','Estoy probando las distintas funcionalidades del gestor de censos...<br><<--- El usuario responsable Pelostaticos cancelar esta jornada por los motivos: Esta jornada era de prueba para ver el funcionamiento de la cancelación de jornadas en modo restringido...','CANCELADA',0,1),(9,'Otra jornada de pruebas','2025-05-07','08:00:00','13:00:00','Esto es para probar que se puede finalizar una jornada desde el historico de censos...<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 07-05-2025 21:55:38<br><<--- El usuario responsable Pelostaticos ha finalizado la jornada a las: 07-05-2025 21:57:01<br><<--- El usuario administrador Pelostaticos ha validado la jornada a las: 07-05-2025 21:57:20','CERRADA',1,4),(10,'Mi jornada de prueba','2025-05-08','08:00:00','13:00:00','Quiero probar arreglos de gestor de jornadas....<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 08-05-2025 14:53:54<br><<--- El usuario responsable Pelostaticos cancelar esta jornada por los motivos: Se cancela por cuestiones meteorologicas.','CANCELADA',0,1),(11,'Mi jornada de prueba','2025-05-08','08:00:00','13:00:00','Quiero probar que un usuario aquó inscrito no pueda inscribirse en la otra jornada para este día<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 08-05-2025 19:42:20','CERRADA',0,1),(12,'Otra jornada de pruebas','2025-05-08','08:00:00','13:00:00','Aquí la jornada a la que no puede inscribirse el mismo usuario.<br><<--- El usuario responsable Pelostaticos cancelar esta jornada por los motivos: Esto era una simple prueba!!!','CANCELADA',0,1),(13,'El modo restringido de participantes','2025-05-12','08:00:00','13:00:00','Esto es una prueba del gestor de participantes en modo restringido...<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 12-05-2025 19:03:27<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 12-05-2025 19:07:32<br><<--- El usuario responsable Pelostaticos ha iniciado la jornada a las: 12-05-2025 19:09:16','CERRADA',0,2),(14,'Presentación PDAW','2025-05-21','08:00:00','13:00:00','Deseando terminar la parte del gestor de participantes en Impress....','ABIERTA',0,4);
/*!40000 ALTER TABLE `pdaw_jornadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_localidades`
--

DROP TABLE IF EXISTS `pdaw_localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_localidades` (
  `localidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`localidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lista de localidades y provincia';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_localidades`
--

LOCK TABLES `pdaw_localidades` WRITE;
/*!40000 ALTER TABLE `pdaw_localidades` DISABLE KEYS */;
INSERT INTO `pdaw_localidades` VALUES ('Algeciras','Cádiz'),('Barbate','Cádiz'),('Cádiz','Cádiz'),('Chiclana de la Frontera','Cádiz'),('Chipiona','Cádiz'),('Conil de la Frontera','Cádiz'),('Demo','Demo'),('La Linea de la Concepción','Cádiz'),('Los Barrios','Cádiz'),('Puerto de Santa María','Cádiz'),('Puerto Real','Cádiz'),('Rota','Cádiz'),('San Fernando','Cádiz'),('San Roque','Cádiz'),('Sanlúcar de Barrameda','Cádiz'),('Tarifa','Cádiz'),('Trebujena','Cádiz'),('Vejer de la Frontera','Cádiz'),('Zahara de los Atunes','Cádiz');
/*!40000 ALTER TABLE `pdaw_localidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_observatorios`
--

DROP TABLE IF EXISTS `pdaw_observatorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_observatorios` (
  `codigo` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `localidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `historia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default.jpg',
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Observatorios registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_observatorios`
--

LOCK TABLES `pdaw_observatorios` WRITE;
/*!40000 ALTER TABLE `pdaw_observatorios` DISABLE KEYS */;
INSERT INTO `pdaw_observatorios` VALUES (1,'Marambay','CA-33 salida Torregorda - Casa del Arrierillo','Cádiz','https://www.google.com/maps/place/Marambay/@36.4650659,-6.2488048,392m/data=!3m1!1e3!4m6!3m5!1s0xd0dd335f3e9e4c7:0x718afdf6f3b1da13!8m2!3d36.465129!4d-6.2463583!16s%2Fg%2F11jpxd8lk_?authuser=0&entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoJLDEwMjExNjQwSAFQAw%3D%3D','Se ubica en las abandonadas Salinas de Roqueta y Preciosa, muy próximas al observatorio del salina dolores.','default.png','https://marambay.com'),(2,'Salina de Carboneros','Carretera de la Barosa - Sendero Salinas Carboneros','Chiclana de la Frontera','https://www.google.com/maps/place/Salina+de+Carboneros+(Abandonada)/@36.3910614,-6.1878023,720m/data=!3m2!1e3!4b1!4m6!3m5!1s0xd0c33b0bb5aaeff:0xba3356b211cddd9e!8m2!3d36.3921151!4d-6.1851841!16s%2Fg%2F11xf9z4jq?authuser=0&entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoJLDEwMjExNjQwSAFQAw%3D%3D','El templo de hercules gaditano','default.png','https://www.juntadeandalucia.es/medioambiente/portal/web/ventanadelvisitante/detalle-buscador-mapa/-/asset_publisher/Jlbxh2qB3NwR/content/salina-de-carboneros/255035'),(3,'Torre del Tajo','Av. de la Mar - Ctra A2223 -  Sendero Torre del Tajo','Barbate','https://maps.app.goo.gl/1mKThcq7RWsPn9ym6','Torre vigía de la época de los piratas berberiscos','default.png','https://www.juntadeandalucia.es/medioambiente/portal/web/ventanadelvisitante/detalle-buscador-mapa/-/asset_publisher/Jlbxh2qB3NwR/content/torre-del-tajo/255035'),(4,'Torre Bermeja','Calle de la asunción, s/n','Chiclana de la Frontera','https://www.google.com/maps/place/Torre+Bermeja,+11139+Chiclana+de+la+Frontera,+C%C3%A1diz/@36.3750178,-6.1936964,17z/data=!3m1!4b1!4m6!3m5!1s0xd0c33cdeaa8f841:0xead057eef471cf17!8m2!3d36.3750178!4d-6.1911215!16s%2Fg%2F11_qtpcpm?authuser=0&entry=ttu&g_ep=EgoyMDI1MDQyMy4wIKXMDSoJLDEwMjExNjQwSAFQAw%3D%3D','Ninguna','default.png','https://es.wikipedia.org/wiki/Torre_Bermeja_(Chiclana_de_la_Frontera)');
/*!40000 ALTER TABLE `pdaw_observatorios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_ordenes`
--

DROP TABLE IF EXISTS `pdaw_ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_ordenes` (
  `codOrden` int unsigned NOT NULL AUTO_INCREMENT,
  `orden` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`codOrden`),
  UNIQUE KEY `orden` (`orden`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Ordenes de familias de aves registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_ordenes`
--

LOCK TABLES `pdaw_ordenes` WRITE;
/*!40000 ALTER TABLE `pdaw_ordenes` DISABLE KEYS */;
INSERT INTO `pdaw_ordenes` VALUES (9,'Accipitriformes'),(1,'Anseriformes'),(19,'Apodiformes'),(18,'Caprimulgiformes'),(12,'Charadriiformes'),(7,'Ciconiiformes'),(14,'Columbiformes'),(20,'Coraciiformes'),(16,'Cuculiformes'),(10,'Falconiformes'),(2,'Galliformes'),(3,'Gaviiformes'),(11,'Gruiformes'),(22,'Passeriformes'),(6,'Pelecaniformes'),(8,'Phoenicopteriformes'),(21,'Piciformes'),(4,'Podiciformes'),(5,'Procellariiformes'),(15,'Psittaciformes'),(13,'Pterocliformes'),(17,'Strigiformes');
/*!40000 ALTER TABLE `pdaw_ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_participantes`
--

DROP TABLE IF EXISTS `pdaw_participantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_participantes` (
  `id_jornada` int unsigned NOT NULL,
  `usuario` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inscripcion` timestamp NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asiste` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_jornada`,`usuario`),
  KEY `fk_usuario_participantes` (`usuario`),
  CONSTRAINT `fk_idjornada_participantes` FOREIGN KEY (`id_jornada`) REFERENCES `pdaw_jornadas` (`id_jornada`),
  CONSTRAINT `fk_usuario_participantes` FOREIGN KEY (`usuario`) REFERENCES `pdaw_usuarios` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Participantes inscritos en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_participantes`
--

LOCK TABLES `pdaw_participantes` WRITE;
/*!40000 ALTER TABLE `pdaw_participantes` DISABLE KEYS */;
INSERT INTO `pdaw_participantes` VALUES (1,'06360c7c286a8deb87696c30e1a4d0f28d6c5464b3cf49193c258912a06efc69','2024-12-24 21:00:00','Pido a Papa Noel que cambie la fecha por favor',0),(2,'a137f45813199b33a086881eb41ce5faa3e3a13cd73eabe5a4e128380f92b584','2025-01-06 19:00:00','Que peazo regalos de Reyes hijo!!!',1),(3,'71241a1e56357a568b6e9663e380211cf7e88646d952bf5e328eab7cd5546c47','2024-01-24 11:17:00','Luego buen pescaito, atún y pasteles comerás',1),(3,'92522571789bdf470b127a23822c024f6da4fd1df50b7e8ad22478fd2f2a105c','2024-01-24 11:00:00','Ese Parque natural de la Breña que preciosidad',0),(7,'0d8c5593235d3f30753cc10dfb2e05638c984cde2aedfb5a450df9f41cb18fda','2025-05-01 13:51:11','Estoy deseando presentarle al voluntariado la Plataforma Correplayas...',1),(9,'0d8c5593235d3f30753cc10dfb2e05638c984cde2aedfb5a450df9f41cb18fda','2025-05-07 19:55:09','Deseando probar esta última funcionalidad para dejar depurado el gestor de censos....',1),(11,'0d8c5593235d3f30753cc10dfb2e05638c984cde2aedfb5a450df9f41cb18fda','2025-05-08 17:40:35','Probando un supuesto error al editar jornadas',1),(13,'0d8c5593235d3f30753cc10dfb2e05638c984cde2aedfb5a450df9f41cb18fda','2025-05-09 14:18:13','Hola!!',0),(13,'50d96e3ea045a5cee46c6b84b240995c1ce3b6b84d62914d40564b9ca0bbc97c','2025-05-09 12:56:18','Estoy deseando ver como funciona esta plaatforma y su proyecto de aves...',0),(13,'f9e4796ca2da1b371a2e50cc11b02dceb3dc256a494ef78a987f3ff9b67c6d88','2025-05-09 14:51:40','Hola! Caracola!!',0);
/*!40000 ALTER TABLE `pdaw_participantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_personas`
--

DROP TABLE IF EXISTS `pdaw_personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_personas` (
  `documento` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('DNI','NIE','PASAPORTE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido1` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido2` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_postal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`documento`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_localidad_personas` (`localidad`),
  KEY `fk_usuario_personas` (`usuario`),
  CONSTRAINT `fk_localidad_personas` FOREIGN KEY (`localidad`) REFERENCES `pdaw_localidades` (`localidad`) ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_personas` FOREIGN KEY (`usuario`) REFERENCES `pdaw_usuarios` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Personas registradas en la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_personas`
--

LOCK TABLES `pdaw_personas` WRITE;
/*!40000 ALTER TABLE `pdaw_personas` DISABLE KEYS */;
INSERT INTO `pdaw_personas` VALUES ('00000000T','DNI','Flesk','Jamón','Tocino','flesk.jamontocino@sergiopdaw.xampp.local','-','-','Puerto de Santa María','-','1fb874166b28aeb4a5d9c3f92c0df65de24aae07982afcb5a39d851a7f4e07a4'),('11000236Q','DNI','susanita','tiene','un ratón','susanita.tieneunraton@gmail.com','-','-','Cádiz','','92522571789bdf470b127a23822c024f6da4fd1df50b7e8ad22478fd2f2a105c'),('12345678Z','DNI','Demo','Plataforma','Correplayas','info@correplayas.bitgarcia.es','-','-','Demo','-','50d96e3ea045a5cee46c6b84b240995c1ce3b6b84d62914d40564b9ca0bbc97c'),('36574869Q','DNI','Spring','Gambas','Ajillo','spring.gambasajillo@sergiopdaw.xampp.local','-','-','Puerto de Santa María','-','f9e4796ca2da1b371a2e50cc11b02dceb3dc256a494ef78a987f3ff9b67c6d88'),('A01278952','NIE','anibal','the','team A','anibal.theteama@yahoo.com','-','-','Chiclana de la Frontera','','a137f45813199b33a086881eb41ce5faa3e3a13cd73eabe5a4e128380f92b584'),('B45123098','PASAPORTE','fulanito','del jamón','iberico','fulanito.deljamoniberico@romerocarvajal.es','652487632','C/ Cualquiera, 8','Puerto Real','11500','71241a1e56357a568b6e9663e380211cf7e88646d952bf5e328eab7cd5546c47');
/*!40000 ALTER TABLE `pdaw_personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_roles`
--

DROP TABLE IF EXISTS `pdaw_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_roles` (
  `rol` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permiso1` tinyint(1) NOT NULL,
  `permiso2` tinyint(1) NOT NULL,
  `permiso3` tinyint(1) NOT NULL,
  `permiso4` tinyint(1) NOT NULL,
  `permiso5` tinyint(1) NOT NULL,
  `permiso6` tinyint(1) NOT NULL,
  `permiso7` tinyint(1) NOT NULL,
  `permiso8` tinyint(1) NOT NULL,
  `permiso9` tinyint(1) NOT NULL,
  `permiso10` tinyint(1) NOT NULL,
  `permiso11` tinyint(1) NOT NULL,
  `permiso12` tinyint(1) NOT NULL,
  `permiso13` tinyint(1) NOT NULL,
  `permiso14` tinyint(1) NOT NULL,
  `permiso15` tinyint(1) NOT NULL,
  `permiso16` tinyint(1) NOT NULL,
  `permiso17` tinyint(1) NOT NULL,
  `permiso18` tinyint(1) NOT NULL,
  `permiso19` tinyint(1) NOT NULL,
  `permiso20` tinyint(1) NOT NULL,
  `permiso21` tinyint(1) NOT NULL,
  `permiso22` tinyint(1) NOT NULL,
  `permiso23` tinyint(1) NOT NULL,
  `permiso24` tinyint(1) NOT NULL,
  `permiso25` tinyint(1) NOT NULL,
  `permiso26` tinyint(1) NOT NULL,
  `permiso27` tinyint(1) NOT NULL,
  `permiso28` tinyint(1) NOT NULL,
  `permiso29` tinyint(1) NOT NULL,
  `permiso30` tinyint(1) NOT NULL,
  `permiso31` tinyint(1) NOT NULL,
  `permiso32` tinyint(1) NOT NULL,
  `permiso33` tinyint(1) NOT NULL,
  `permiso34` tinyint(1) NOT NULL,
  `permiso35` tinyint(1) NOT NULL,
  `permiso36` tinyint(1) NOT NULL,
  `permiso37` tinyint(1) NOT NULL,
  `permiso38` tinyint(1) NOT NULL,
  `permiso39` tinyint(1) NOT NULL,
  `permiso40` tinyint(1) NOT NULL,
  `permiso41` tinyint(1) NOT NULL,
  PRIMARY KEY (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Roles de plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_roles`
--

LOCK TABLES `pdaw_roles` WRITE;
/*!40000 ALTER TABLE `pdaw_roles` DISABLE KEYS */;
INSERT INTO `pdaw_roles` VALUES ('administrador',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),('coordinador',1,1,1,1,0,1,0,0,0,1,0,0,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,0,1,0,0,1,1,0,1,0,0,1,1),('voluntario',1,1,1,1,0,1,0,0,0,1,0,0,1,1,1,1,1,1,0,1,1,1,0,0,1,0,0,1,1,0,1,0,0,1,1,0,1,0,0,1,1);
/*!40000 ALTER TABLE `pdaw_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pdaw_usuarios`
--

DROP TABLE IF EXISTS `pdaw_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdaw_usuarios` (
  `codigo` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasenya` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('ACTIVO','DESACTIVO','BAJA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `fk_usuario_rol` (`rol`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol`) REFERENCES `pdaw_roles` (`rol`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Usuarios de la plataforma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdaw_usuarios`
--

LOCK TABLES `pdaw_usuarios` WRITE;
/*!40000 ALTER TABLE `pdaw_usuarios` DISABLE KEYS */;
INSERT INTO `pdaw_usuarios` VALUES ('06360c7c286a8deb87696c30e1a4d0f28d6c5464b3cf49193c258912a06efc69','usuario3','8cdf2abf536d6c97e413724532038ba21aeb56d2766d695d384bfb4bcb2bcf5b','BAJA','voluntario'),('0d8c5593235d3f30753cc10dfb2e05638c984cde2aedfb5a450df9f41cb18fda','Python','b04d6b8650af46311f20a0b97e1f555c8177e5125f65014eee4113aef68075f9','BAJA','administrador'),('1fb874166b28aeb4a5d9c3f92c0df65de24aae07982afcb5a39d851a7f4e07a4','Flesk','e165b8d11fd156fdd2252b6aa3ff3189cfc703884c6fd398dbbc884799069c84','ACTIVO','voluntario'),('23377fc0bb37979f447e4b78074600f228c0a37690439aaa42a56d5c874f921a','Basic','238f6db9b118651bc2f0479ba51ace76da9981fe09c518151e2c02f32d76c657','BAJA','administrador'),('5','usuario5','1234567890yempiezaoraves','BAJA','voluntario'),('50d96e3ea045a5cee46c6b84b240995c1ce3b6b84d62914d40564b9ca0bbc97c','demo','76696ae435ec5e0606e98fd1489406d4735ce9a1cfb05f5995acaacf53519229','ACTIVO','administrador'),('71241a1e56357a568b6e9663e380211cf7e88646d952bf5e328eab7cd5546c47','usuario4','69e9861e58d87057162ed7db22a98a90e334cc6b9f815679c24e677176e66f0c','DESACTIVO','coordinador'),('92522571789bdf470b127a23822c024f6da4fd1df50b7e8ad22478fd2f2a105c','usuario1','4d1669ac9896bee14ca3113af72c92717d533dc485d8d75338bf70af2f9245aa','ACTIVO','voluntario'),('a137f45813199b33a086881eb41ce5faa3e3a13cd73eabe5a4e128380f92b584','Laravel','093d601899bdb72f04ac03664ad2dacc2b5e5b7617a5719fee6b58a43d22404c','ACTIVO','administrador'),('f9e4796ca2da1b371a2e50cc11b02dceb3dc256a494ef78a987f3ff9b67c6d88','Spring','ca4322e47bf562f0fa4aef3d2a65c465912ea43d3d6d034b050d37e3e197f3fc','ACTIVO','voluntario');
/*!40000 ALTER TABLE `pdaw_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-23 19:50:43
