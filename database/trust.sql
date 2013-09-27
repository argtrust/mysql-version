-- MySQL dump 10.13  Distrib 5.1.47, for redhat-linux-gnu (x86_64)
--
-- Host: jsalvitdbinstance.cku3opv9prdt.us-east-1.rds.amazonaws.com    Database: trust
-- ------------------------------------------------------
-- Server version	5.5.27-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agent_has_beliefs`
--

DROP TABLE IF EXISTS `agent_has_beliefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_has_beliefs` (
  `agentBeliefID` int(11) NOT NULL AUTO_INCREMENT,
  `agentID` int(11) NOT NULL,
  `beliefID` int(11) NOT NULL,
  `level` decimal(18,2) NOT NULL,
  `isInferred` smallint(6) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`agentBeliefID`,`timestep`,`sessionID`)
) ENGINE=InnoDB AUTO_INCREMENT=433 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agent_trust`
--

DROP TABLE IF EXISTS `agent_trust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_trust` (
  `trustID` int(11) NOT NULL AUTO_INCREMENT,
  `trustingAgent` int(11) NOT NULL,
  `trustedAgent` int(11) NOT NULL,
  `level` decimal(18,2) NOT NULL,
  `isInferred` smallint(6) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`trustID`,`sessionID`,`timestep`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agents` (
  `agentID` int(11) NOT NULL AUTO_INCREMENT,
  `agentName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`agentID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `argument_attacks_argument`
--

DROP TABLE IF EXISTS `argument_attacks_argument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `argument_attacks_argument` (
  `questionArgumentID` int(11) NOT NULL AUTO_INCREMENT,
  `attackFromID` int(11) NOT NULL,
  `attackToID` int(11) NOT NULL,
  `attackType` varchar(45) NOT NULL,
  `isFromRule` int(11) NOT NULL,
  `isToRule` int(11) NOT NULL,
  `fromBeliefID` int(11) NOT NULL,
  `toBeliefID` int(11) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`questionArgumentID`,`timestep`,`sessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `arguments`
--

DROP TABLE IF EXISTS `arguments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arguments` (
  `argumentID` int(11) NOT NULL AUTO_INCREMENT,
  `beliefID` int(11) NOT NULL,
  `questionID` int(11) DEFAULT NULL,
  `supportsArgumentID` int(11) DEFAULT NULL,
  `isLeaf` smallint(6) NOT NULL,
  `isSupported` smallint(6) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`argumentID`,`sessionID`,`timestep`)
) ENGINE=InnoDB AUTO_INCREMENT=701 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `belief_has_premises`
--

DROP TABLE IF EXISTS `belief_has_premises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `belief_has_premises` (
  `beliefPremiseID` int(11) NOT NULL AUTO_INCREMENT,
  `beliefID` int(11) NOT NULL,
  `premiseID` int(11) NOT NULL,
  `isNegated` smallint(6) NOT NULL,
  PRIMARY KEY (`beliefPremiseID`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `belief_names`
--

DROP TABLE IF EXISTS `belief_names`;
/*!50001 DROP VIEW IF EXISTS `belief_names`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `belief_names` (
  `beliefID` int(11),
  `beliefName` varchar(106),
  `isRule` smallint(6)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `beliefs`
--

DROP TABLE IF EXISTS `beliefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beliefs` (
  `beliefID` int(11) NOT NULL AUTO_INCREMENT,
  `conclusionID` int(11) NOT NULL,
  `isNegated` smallint(6) NOT NULL,
  `isRule` smallint(6) NOT NULL,
  PRIMARY KEY (`beliefID`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `constants` (
  `constantID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`constantID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inferred_beliefs`
--

DROP TABLE IF EXISTS `inferred_beliefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inferred_beliefs` (
  `inferenceID` int(11) NOT NULL AUTO_INCREMENT,
  `inferredBeliefID` int(11) NOT NULL,
  `appliedBeliefID` int(11) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`inferenceID`,`sessionID`,`timestep`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inferred_trust`
--

DROP TABLE IF EXISTS `inferred_trust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inferred_trust` (
  `inferenceID` int(11) NOT NULL AUTO_INCREMENT,
  `inferredTrustID` int(11) NOT NULL,
  `appliedTrustID` int(11) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`inferenceID`,`sessionID`,`timestep`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parent_argument`
--

DROP TABLE IF EXISTS `parent_argument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_argument` (
  `parentArgumentID` int(11) NOT NULL AUTO_INCREMENT,
  `argumentID` int(11) DEFAULT NULL,
  `questionID` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `level` double DEFAULT NULL,
  `sessionID` varchar(45) DEFAULT NULL,
  `timestep` int(11) DEFAULT NULL,
  PRIMARY KEY (`parentArgumentID`)
) ENGINE=InnoDB AUTO_INCREMENT=10104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parent_argument_attacks_argument`
--

DROP TABLE IF EXISTS `parent_argument_attacks_argument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_argument_attacks_argument` (
  `fromParentArgID` int(11) NOT NULL,
  `toParentArgID` int(11) NOT NULL,
  `attackType` varchar(45) DEFAULT NULL,
  `isIncluded` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`fromParentArgID`,`toParentArgID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parent_argument_has_argument`
--

DROP TABLE IF EXISTS `parent_argument_has_argument`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_argument_has_argument` (
  `parentArgumentID` int(11) NOT NULL,
  `argumentID` int(11) NOT NULL,
  PRIMARY KEY (`parentArgumentID`,`argumentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `predicate_has_constant`
--

DROP TABLE IF EXISTS `predicate_has_constant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predicate_has_constant` (
  `predicateConstantID` int(11) NOT NULL AUTO_INCREMENT,
  `predicateID` int(11) NOT NULL,
  `constantID` int(11) NOT NULL,
  PRIMARY KEY (`predicateConstantID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `predicate_has_constant_names`
--

DROP TABLE IF EXISTS `predicate_has_constant_names`;
/*!50001 DROP VIEW IF EXISTS `predicate_has_constant_names`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `predicate_has_constant_names` (
  `predicateConstantID` int(11),
  `predicateName` varchar(45),
  `constantName` varchar(55)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `predicates`
--

DROP TABLE IF EXISTS `predicates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predicates` (
  `predicateID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`predicateID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `question_attacks_arguments`
--

DROP TABLE IF EXISTS `question_attacks_arguments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_attacks_arguments` (
  `questionArgumentID` int(11) NOT NULL AUTO_INCREMENT,
  `questionID` int(11) NOT NULL,
  `argumentID` int(11) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`questionArgumentID`,`sessionID`,`timestep`)
) ENGINE=InnoDB AUTO_INCREMENT=701 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `question_has_status`
--

DROP TABLE IF EXISTS `question_has_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_has_status` (
  `questionStatusID` int(11) NOT NULL AUTO_INCREMENT,
  `questionID` int(11) NOT NULL,
  `statusID` int(11) NOT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`questionStatusID`,`sessionID`,`timestep`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `questionID` int(11) NOT NULL AUTO_INCREMENT,
  `agentID` int(11) NOT NULL,
  `conclusionID` int(11) NOT NULL,
  `isNegated` smallint(6) NOT NULL,
  `isAttack` smallint(6) NOT NULL,
  `isProcessed` smallint(6) NOT NULL,
  `isSupported` smallint(6) NOT NULL,
  `attackType` varchar(45) DEFAULT NULL,
  `sessionID` varchar(45) NOT NULL,
  `timestep` int(11) NOT NULL,
  PRIMARY KEY (`questionID`,`sessionID`,`timestep`)
) ENGINE=InnoDB AUTO_INCREMENT=471 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(45) DEFAULT NULL,
  `statusType` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_session`
--

DROP TABLE IF EXISTS `user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionID` varchar(45) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `current_timestep` int(11) DEFAULT '1',
  `userid` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Secondary` (`sessionID`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'trust'
--
/*!50003 DROP PROCEDURE IF EXISTS `copy_beliefs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `copy_beliefs`(IN userSessionID varchar(55), IN fromStep INT, IN toStep int, IN excludeFactID int, IN excludeAgentID int)
BEGIN
insert into agent_has_beliefs (agentID, beliefID, level, isInferred,sessionID,timestep)
select ab.agentID, b.beliefID, ab.level,ab.isInferred,userSessionID,toStep
    from beliefs b
    inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
    inner join agent_trust at on (at.trustedAgent = ab.agentID) and at.sessionID = ab.sessionID and at.timestep = ab.timestep
where ab.sessionID = userSessionID and ab.timestep = fromStep and ab.isInferred = 0
and not b.beliefID in (excludeFactID) and not ab.agentID in (excludeAgentID)
union
select ab.agentID, b.beliefID, ab.level,ab.isInferred,userSessionID,toStep
    from beliefs b
    inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
where ab.sessionID = userSessionID and ab.timestep = fromStep and ab.isInferred = 0
and not b.beliefID in (excludeFactID) and not ab.agentID in (excludeAgentID);


END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `copy_fact` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `copy_fact`(IN userSessionID varchar(55), IN fromStep INT, IN toStep int, IN excludeFactID int)
BEGIN
insert into agent_has_beliefs (agentID, beliefID, level, isInferred,sessionID,timestep)
select ab.agentID, b.beliefID, ab.level,ab.isInferred,userSessionID,toStep
    from beliefs b
    inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
    inner join agent_trust at on (at.trustingAgent = ab.agentID or at.trustedAgent = ab.agentID) and at.sessionID = ab.sessionID and at.timestep = ab.timestep
where ab.sessionID = userSessionID and ab.timestep = fromStep and b.isRule = 0  and ab.isInferred = 0
and not b.beliefID in (excludeFactID);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `copy_question` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `copy_question`(IN userSessionID varchar(55), IN fromStep INT, IN toStep int, IN excludeQuestionID int)
BEGIN
INSERT INTO questions (agentID, conclusionID, isNegated, isAttack, isProcessed, isSupported, attackType, sessionID, timestep)
SELECT agentID, conclusionID, isNegated, isAttack, 0, 0, NULL, userSessionID, toStep
from questions
where sessionID = userSessionID and timestep = fromStep and isAttack = 0
and not questionID in (excludeQuestionID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `copy_rules` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `copy_rules`(IN userSessionID varchar(55), IN fromStep INT, IN toStep int, IN excludeRuleID int)
BEGIN
insert into agent_has_beliefs (agentID, beliefID, level, isInferred,sessionID,timestep)
select ab.agentID, b.beliefID, ab.level,isInferred,userSessionID,toStep
    from beliefs b
    inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
where ab.sessionID = userSessionID and ab.timestep = fromStep and b.isRule = 1  and isInferred = 0
and not b.beliefID in (excludeRuleID);


END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `copy_trust` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `copy_trust`(IN userSessionID varchar(55), IN fromStep INT, IN toStep int, IN excludeTrustID int)
BEGIN
insert into agent_trust (trustingAgent, trustedAgent, level, isInferred, sessionID, timestep)
select trustingAgent, trustedAgent, level, 0, userSessionID, toStep
from agent_trust
where sessionID = userSessionID and timestep = fromStep and isInferred = 0
and not trustingAgent in (excludeTrustID)
and not trustedAgent in (excludeTrustID);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `delete_fact` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `delete_fact`(IN userSessionID varchar(55),IN factID int)
BEGIN
  DECLARE timestep int;
  SELECT current_timestep INTO timestep FROM user_session WHERE sessionID = userSessionID;
  UPDATE user_session SET current_timestep = timestep+1 WHERE sessionID = userSessionID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getAgents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `getAgents`(IN sessionIDParam varchar(55), IN timestepParam int)
BEGIN

SELECT DISTINCT agentID, agentName FROM agents 
INNER JOIN agent_trust on (trustingAgent = agentID or trustedAgent = agentID) 
where sessionID = sessionIDParam and timestep=timestepParam;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getFacts` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `getFacts`(IN sessionIDParam varchar(55), IN timestepParam int, IN includeConclusions int, IN onlyConclusions int)
BEGIN
IF onlyConclusions = 1 THEN 

    select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, ab.level, max(pa.status), count(distinct pa.status) as argStatus 
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		inner join parent_argument pa on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep 
		where ab.agentID = 1 and b.isRule = 0 and a.isSupported = 1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam
		group by b.beliefID, b.isNegated, p.name, c.name, ab.level;

ELSEIF includeConclusions = 1 THEN
		select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 0 and a.isSupported = 1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam;
ELSE
		select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 0 and a.isSupported = 1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam
		and b.beliefID NOT IN (select distinct b.beliefID 
								from arguments a 
								inner join beliefs b on b.beliefID = a.beliefID 
								inner join parent_argument pa on pa.argumentID = a.argumentID 
											and pa.sessionID = a.sessionID 
											and pa.timestep = a.timestep 
								where a.sessionID = sessionIDParam and a.timestep=timestepParam);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `getRules` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`trust_user`@`%`*/ /*!50003 PROCEDURE `getRules`(IN sessionIDParam varchar(55), IN timestepParam int, IN includeConclusions int, IN onlyConclusions int)
BEGIN
IF onlyConclusions = 1 THEN 
    select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, ab.level, max(pa.status), count(distinct pa.status) as argStatus 
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		inner join parent_argument pa on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep 
		where ab.agentID = 1 and b.isRule = 1 and a.isSupported = 1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam
		group by b.beliefID, b.isNegated, p.name, c.name, ab.level;

ELSEIF includeConclusions = 1 THEN
  select distinct b.beliefID, CASE 
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID  
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 1 and a.isSupported=1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam;
ELSE
  select distinct b.beliefID, CASE 
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID  
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 1 and a.isSupported=1
		and ab.sessionID = sessionIDParam and ab.timestep=timestepParam
		and b.beliefID NOT IN (select distinct b.beliefID 
								from arguments a 
								inner join beliefs b on b.beliefID = a.beliefID 
								inner join parent_argument pa on pa.argumentID = a.argumentID 
											and pa.sessionID = a.sessionID 
											and pa.timestep = a.timestep 
								where a.sessionID = sessionIDParam and a.timestep=timestepParam);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `belief_names`
--

/*!50001 DROP TABLE IF EXISTS `belief_names`*/;
/*!50001 DROP VIEW IF EXISTS `belief_names`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`trust_user`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `belief_names` AS select `b`.`beliefID` AS `beliefID`,(case when (`b`.`isNegated` = 0) then concat(`pc`.`predicateName`,'(',`pc`.`constantName`,')') else concat('NOT ',`pc`.`predicateName`,'(',`pc`.`constantName`,')') end) AS `beliefName`,`b`.`isRule` AS `isRule` from (`beliefs` `b` join `predicate_has_constant_names` `pc` on((`pc`.`predicateConstantID` = `b`.`conclusionID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `predicate_has_constant_names`
--

/*!50001 DROP TABLE IF EXISTS `predicate_has_constant_names`*/;
/*!50001 DROP VIEW IF EXISTS `predicate_has_constant_names`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`trust_user`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `predicate_has_constant_names` AS select `pc`.`predicateConstantID` AS `predicateConstantID`,`p`.`name` AS `predicateName`,`c`.`name` AS `constantName` from ((`predicate_has_constant` `pc` join `predicates` `p` on((`p`.`predicateID` = `pc`.`predicateID`))) join `constants` `c` on((`c`.`constantID` = `pc`.`constantID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-27 14:02:10
