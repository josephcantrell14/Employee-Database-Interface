# noinspection SqlNoDataSourceInspectionForFile

/*
 Navicat Premium Data Transfer

 Source Server         : leviathan
 Source Server Type    : MySQL
 Source Server Version : 50095
 Source Host           : leviathan.cc.gatech.edu:3306
 Source Schema         : staff_feedback

 Target Server Type    : MySQL
 Target Server Version : 50095
 File Encoding         : 65001

 Date: 17/07/2017 14:47:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for person
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `gtAccount` varchar(20) NOT NULL,
  `firstName` varchar(64) NOT NULL,
  `lastName` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `status` varchar(1) NOT NULL,
  `Mgr` varchar(1) NOT NULL,
  `supervisor` varchar(20) NOT NULL,
  `dept` varchar(128) NOT NULL,
  PRIMARY KEY  (`gtAccount`),
  UNIQUE KEY `gtAccount` (`gtAccount`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of person
-- ----------------------------
BEGIN;
INSERT INTO `person` VALUES ('jcantrell32', 'Joseph', 'Cantrell', 'jcantrell32@cc.gatech.edu', 'A', 'N', 'mt53', 'Computing  College of');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
