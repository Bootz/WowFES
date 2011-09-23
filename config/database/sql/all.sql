SET NAMES utf8;
SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS `crazychufun`;
USE `crazychufun`;

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `loginID`                      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT                                              ,
  `username`                     VARCHAR(32) NOT NULL                                                                 ,
  `password`                     VARCHAR(256) NOT NULL                                                                ,
  `email`                        VARCHAR(256) NOT NULL                                                                ,
  `status`                       VARCHAR(16) NOT NULL                                                                 ,
  `createdBy`                    VARCHAR(32) NOT NULL                                                                 ,
  `createdTime`                  TIMESTAMP NOT NULL DEFAULT 0                                                         ,
  `lastUpdatedBy`                VARCHAR(32) NOT NULL                                                                 ,
  `lastUpdatedTime`              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP             ,
  PRIMARY KEY (`loginID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `recipeID`                     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT                                              ,
  `name`                         VARCHAR(128) NOT NULL                                                                ,
  `ingredient`                   TEXT NOT NULL                                                                        ,
  `step`                         TEXT NOT NULL                                                                        ,
  `tips`                         TEXT NOT NULL                                                                        ,
  `extra`                        TEXT NOT NULL                                                                        ,
  `image`                        VARCHAR(256) NOT NULL                                                                ,
  `createdBy`                    VARCHAR(32) NOT NULL                                                                 ,
  `createdTime`                  TIMESTAMP NOT NULL DEFAULT 0                                                         ,
  `lastUpdatedBy`                VARCHAR(32) NOT NULL                                                                 ,
  `lastUpdatedTime`              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP             ,
  PRIMARY KEY (`recipeID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

SET FOREIGN_KEY_CHECKS=1;

SET NAMES utf8;
USE `crazychufun`;

LOCK TABLES `login` WRITE;
INSERT INTO `login` VALUES (1,"admin","admin","admin@crazychufun.com","ENABLED","","","","");
UNLOCK TABLES;

LOCK TABLES `recipe` WRITE;
INSERT INTO `recipe` VALUES (1,"五榖雞丁米炒飯","五榖飯:1:碗;雞蛋:2:個;魚板丁:20:克;青蔥末:20:克;雞肉丁:50:克;三色豆:30:克;","雞蛋打入碗中，攪拌均勻成蛋液。;取鍋，加入少許油燒熱，倒入作法2的蛋液炒勻至水份收乾。;續加入魚板丁、青蔥末、雞肉丁、三色豆炒香後，放入五榖飯和調味料大火拌炒均勻即可。;","喜歡抄飯乾一點的朋友，煮飯時的米/水比例可以 1比1 喔。","一人份","/uploads/20110915110658wNZjSy4wUWV4GoDb5cEbBS6NpEufSpyE五榖米炒飯.jpg","admin","","admin","");
INSERT INTO `recipe` VALUES (2,"香料雞丁","無骨雞腿排:1:個;紅甜椒:1/2:個;黃甜椒:1/2:個;甜豆:10:個;","首先將雞腿排洗淨，切成約5公分的正方形丁，再加入所有的醃料拌勻醃30分鐘備用。;紅甜椒、黃甜椒、甜豆都切成小菱形狀備用。;起一個炒鍋加入一大匙沙拉油，再加入作法1醃好的雞腿丁煎上色。;再加入作法2的所有材料和所有調味料一同翻炒均勻即可。;建議冷卻後可視個人喜好份量分裝，放冷凍保存。（冰箱冷藏約7～10天）;","記得要先把甜椒切成小菱形狀喔。","一人份","/uploads/20110915113207BmUMsQGRFD96irh4YVu65lM4ETQ3UaxW香料雞丁.jpg","admin","","admin","");
INSERT INTO `recipe` VALUES (3,"照燒烤雞翅","雞翅:3:個;小蕃茄:10:個;","將雞翅洗淨，再加入醃料的所有材料醃製30分鐘，備用。;再將小蕃茄洗淨對切備用。;將作法1、2的所有材料包入錫箔紙中，再放入預熱190℃的烤箱中，烤約20分鐘即可。;","雞翅醃製後會更入味喔。","一人份","/uploads/20110915114546WndvWWcpyQ91w1uvKJ32v0nU0V5LALEV照燒拷雞翅.jpg","admin","","admin","");
UNLOCK TABLES;
