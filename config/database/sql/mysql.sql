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

